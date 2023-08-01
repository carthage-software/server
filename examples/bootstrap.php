<?php

declare(strict_types=1);

namespace Carthage\Examples;

use DateTimeInterface;
use Monolog\Handler\AbstractHandler;
use Monolog\Level;
use Monolog\LogRecord;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use function zend_version;

use const PHP_SAPI;
use const PHP_VERSION;

require_once __DIR__.'/../vendor/autoload.php';

final class CarthageHandler extends AbstractHandler
{
    private HttpClientInterface $client;

    private int $bufferLimit = 0;
    private int $bufferSize = 0;
    private int $totalSent = 0;

    /**
     * @var LogRecord[]
     */
    private array $buffer = [];

    public function __construct(HttpClientInterface $httpClient, int $bufferLimit = 500, int|string|Level $level = Level::Debug, bool $bubble = true)
    {
        parent::__construct($level, $bubble);

        $this->bufferLimit = $bufferLimit;
        $this->client = $httpClient;
    }

    public function handle(LogRecord $record): bool
    {
        if ($record->level->isLowerThan($this->level)) {
            return false;
        }

        if ($this->bufferSize === $this->bufferLimit) {
            $this->flush();
        }

        $this->buffer[] = $record;
        ++$this->bufferSize;

        return false === $this->bubble;
    }

    public function flush(): void
    {
        if (0 === $this->bufferSize) {
            return;
        }

        echo '[log] flushing '.$this->bufferSize.' records'."\n";

        $collectLogs = [];
        foreach ($this->buffer as $record) {
            $attributes = $record->extra;
            $attributes['php_version'] = PHP_VERSION;
            $attributes['zend_version'] = zend_version();
            $attributes['php_sapi'] = PHP_SAPI;

            $tags = $attributes['tags'] ?? [];
            unset($attributes['tags']);

            $key = $record->channel.':'.$record->level->name.':'.$record->message;
            if (!isset($collectLogs[$key])) {
                $collectLogs[$key] = [
                    'log' => [
                        'namespace' => $record->channel,
                        'level' => $record->level->value,
                        'template' => $record->message,
                    ],
                    'entries' => [],
                ];
            }

            $collectLogs[$key]['entries'][] = [
                'source' => gethostname() ?: 'unknown',
                'context' => $record->context,
                'attributes' => $attributes,
                'tags' => $tags,
                'occurred_at' => $record->datetime->format(DateTimeInterface::RFC3339_EXTENDED),
            ];
        }

        $res = $this->client->request('POST', 'https://localhost/log-management/collect', [
            'json' => [
                'collect_logs' => array_values($collectLogs),
            ],
            'verify_peer' => false,
            'verify_host' => false,
        ]);

        if (202 !== $res->getStatusCode()) {
            echo 'failed to send logs';
            var_dump($res->getHeaders(false));

            return;
        }

        $this->buffer = [];
        $this->totalSent += $this->bufferSize;
        $this->bufferSize = 0;
    }

    public function __destruct()
    {
        $this->close();

        echo '[log] total sent: '.$this->totalSent."\n";
    }

    public function close(): void
    {
        $this->flush();
    }
}

return HttpClient::createForBaseUri('https://localhost/', [
    'verify_peer' => false,
    'verify_host' => false,
]);

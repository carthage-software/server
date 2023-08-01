<?php

declare(strict_types=1);

namespace Carthage\Tests\Functional\Presentation\LogManagement\Server\RequestHandler\Log;

use Carthage\Application\LogManagement\Command\Log\CollectLogCommand;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Infrastructure\Shared\Symfony\Test\FunctionalTestCase;
use Exception;
use Psl\Json;
use Psl\Type;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Transport\InMemory\InMemoryTransport;

final class CollectLogRequestHandlerTest extends FunctionalTestCase
{
    /**
     * @throws Exception
     */
    public function testSuccess(): void
    {
        $request = [
            'log' => [
                'namespace' => 'sql',
                'level' => Level::Info->value,
                'template' => 'query {query} took {time}ms',
            ],
            'entries' => [
                [
                    'source' => 'localhost',
                    'context' => [
                        'query' => 'SELECT * FROM users',
                        'time' => 10,
                    ],
                    'attributes' => [
                        'request_id' => '1234567890',
                    ],
                    'tags' => ['sql', 'query'],
                    'occurred_at' => '2021-01-01T00:00:00.000+00:00',
                ],
                [
                    'source' => 'localhost',
                    'context' => [
                        'query' => 'SELECT * FROM users',
                        'time' => 20,
                    ],
                    'attributes' => [
                        'request_id' => '1234567892',
                    ],
                    'tags' => ['sql', 'query'],
                    'occurred_at' => '2021-01-01T02:00:00.000+00:00',
                ],
                [
                    'source' => 'localhost',
                    'context' => [
                        'query' => 'SELECT * FROM users',
                        'time' => 30,
                    ],
                    'attributes' => [
                        'request_id' => '1234567891',
                    ],
                    'tags' => ['sql', 'query'],
                    'occurred_at' => '2021-01-01T01:00:00.000+00:00',
                ],
            ],
        ];

        $this->post('/log-management/log/collect', $request);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(202);

        /* @var InMemoryTransport $transport */
        $transport = $this->getContainer()->get('messenger.transport.async');
        /* @var list<Envelope> $envelopes */
        $envelopes = $transport->getSent();

        $command = ($envelopes[0] ?? null)?->getMessage();

        self::assertInstanceOf(CollectLogCommand::class, $command);

        $collectLog = $command->collectLog;

        self::assertSame($request['log']['namespace'], $collectLog->log->namespace);
        self::assertSame($request['log']['level'], $collectLog->log->level->value);
        self::assertSame($request['log']['template'], $collectLog->log->template);

        $entries = $collectLog->entries;

        self::assertCount(3, $entries);

        $transport->reset();
    }

    public function testBadRequestDueToMissingLog(): void
    {
        $this->post('/log-management/log/collect', []);

        self::assertResponseStatusCodeSame(400);
        self::assertResponseFormatSame('json');

        $data = Json\typed($this->browser->getResponse()->getContent() ?: '', Type\shape([
            'errors' => Type\vec(Type\shape([
                'code' => Type\non_empty_string(),
                'field' => Type\nullable(Type\non_empty_string()),
                'message' => Type\nullable(Type\non_empty_string()),
            ])),
        ]));

        self::assertCount(1, $data['errors']);

        self::assertSame('ad32d13f-c3d4-423b-909a-857b961eb720', $data['errors'][0]['code']);
        self::assertSame('log', $data['errors'][0]['field']);
        self::assertSame('Log must not be null.', $data['errors'][0]['message']);
    }

    /**
     * @throws Exception
     */
    public function testNoConflict(): void
    {
        $this->post('/log-management/log/collect', [
            'log' => [
                'namespace' => 'sql',
                'level' => Level::Info->value,
                'template' => 'query {query} took {time}ms',
            ],
            'entries' => [],
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(202);

        $this->post('/log-management/log/collect', [
            'log' => [
                'namespace' => 'sql',
                'level' => Level::Info->value,
                'template' => 'query {query} took {time}ms',
            ],
            'entries' => [],
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(202);
    }

    /**
     * @throws Exception
     */
    public function testNoEntriesIsOkay(): void
    {
        $this->post('/log-management/log/collect', [
            'log' => [
                'namespace' => 'sql',
                'level' => Level::Info->value,
                'template' => 'query {query} took {time}ms',
            ],
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(202);
    }
}

<?php

declare(strict_types=1);

namespace Carthage\Examples;

use Exception;
use Monolog;
use Symfony\Contracts\HttpClient\HttpClientInterface;

/** @var HttpClientInterface $client */
$client = require __DIR__.'/bootstrap.php';

$handler = new CarthageHandler($client, 5000);

for ($i = 1; $i <= 200; ++$i) {
    $processors = [
        new Monolog\Processor\ProcessIdProcessor(),
        new Monolog\Processor\TagProcessor(['php', 'symfony', 'monolog']),
    ];
   
    foreach (['default', 'event', 'deprecations'] as $channel) {
        $logger = new Monolog\Logger($channel, [$handler], $processors);

        $logger->emergency('Oh noes!', ['foo' => 'bar']);
        $logger->error('Exception! oh no! (' . $i . ')', ['exception' => new Exception('Oh noes!')]);

        foreach (Monolog\Level::cases() as $level) {
            $logger->log($level, 'Order #{order} has been deliveried!', ['order' => '1234567890']);
        }
    }
}

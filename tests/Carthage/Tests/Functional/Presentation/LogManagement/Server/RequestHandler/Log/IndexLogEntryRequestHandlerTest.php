<?php

declare(strict_types=1);

namespace Carthage\Tests\Functional\Presentation\LogManagement\Server\RequestHandler\Log;

use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Infrastructure\Shared\Symfony\Test\FunctionalTestCase;
use Psl\Json;
use Psl\Type;

final class IndexLogEntryRequestHandlerTest extends FunctionalTestCase
{
    public function testSuccess(): void
    {
        $this->purgeResource('log-management/log');

        $response = $this->post('/log-management/log', [
            'namespace' => 'events',
            'level' => Level::Debug->value,
            'template' => 'listener {listener} received message {message}',
        ]);

        self::assertResponseIsSuccessful();
        self::assertResponseFormatSame('json');

        $data = Json\typed($response->getContent() ?: '', Type\shape([
            'identity' => Type\non_empty_string(),
        ], true));

        $response = $this->post('/log-management/log/entry', [
            'log_identity' => $data['identity'],
            'source' => 'localhost',
            'context' => [
                'listener' => 'listener',
                'message' => 'message',
            ],
            'attributes' => [
                'attribute' => 'attribute',
            ],
            'tags' => ['tag'],
            'occurred_at' => '2021-01-01T00:00:00+00:00',
        ]);

        self::assertResponseIsSuccessful();

        $data = Json\typed($response->getContent() ?: '', Type\shape([
            'identity' => Type\non_empty_string(),
            'source' => Type\non_empty_string(),
            'context' => Type\shape([
                'listener' => Type\non_empty_string(),
                'message' => Type\non_empty_string(),
            ]),
            'attributes' => Type\shape([
                'attribute' => Type\non_empty_string(),
            ]),
            'tags' => Type\shape([
                0 => Type\non_empty_string(),
            ]),
            'occurred_at' => Type\non_empty_string(),
        ], true));

        self::assertSame('localhost', $data['source']);
        self::assertSame('listener', $data['context']['listener']);
        self::assertSame('message', $data['context']['message']);
        self::assertSame('attribute', $data['attributes']['attribute']);
        self::assertSame(['tag'], $data['tags']);
        self::assertSame('2021-01-01T00:00:00+00:00', $data['occurred_at']);
    }
}

<?php

declare(strict_types=1);

namespace Carthage\Tests\Functional\Presentation\LogManagement\Server\RequestHandler\Log;

use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Infrastructure\Shared\Symfony\Test\FunctionalTestCase;
use Psl\Json;
use Psl\Type;

final class CreateLogRequestHandlerTest extends FunctionalTestCase
{
    public function testSuccess(): void
    {
        $log = [
            'namespace' => 'events',
            'level' => Level::Debug->value,
            'template' => 'listener {listener} received message {message}',
        ];

        $this->post('/log-management/log', $log);

        self::assertResponseIsSuccessful();
        self::assertResponseFormatSame('json');

        $data = Json\typed($this->browser->getResponse()->getContent() ?: '', Type\shape([
            'type' => Type\non_empty_string(),
            'identity' => Type\non_empty_string(),
            'namespace' => Type\non_empty_string(),
            'level' => Type\shape([
                'value' => Type\int(),
                'name' => Type\non_empty_string(),
            ]),
            'template' => Type\non_empty_string(),
            'first_entry_occurred_at' => Type\nullable(Type\non_empty_string()),
            'last_entry_occurred_at' => Type\nullable(Type\non_empty_string()),
            'created_at' => Type\non_empty_string(),
            'updated_at' => Type\non_empty_string(),
        ]));

        self::assertSame('log', $data['type']);
        self::assertSame($log['namespace'], $data['namespace']);
        self::assertSame($log['level'], $data['level']['value']);
        self::assertSame($log['template'], $data['template']);
        self::assertNull($data['first_entry_occurred_at']);
        self::assertNull($data['last_entry_occurred_at']);
        self::assertMatchesRegularExpression('/^20[2-9][0-9]-[0-1][0-9]-[0-3][0-9]T[0-5][0-9]:[0-5][0-9]:[0-5][0-9]\.[0-9]{3}\+00:00$/', $data['created_at']);
        self::assertMatchesRegularExpression('/^20[2-9][0-9]-[0-1][0-9]-[0-3][0-9]T[0-5][0-9]:[0-5][0-9]:[0-5][0-9]\.[0-9]{3}\+00:00$/', $data['updated_at']);
    }

    public function testBadRequestDueToMissingInput(): void
    {
        $this->post('/log-management/log', []);

        self::assertResponseStatusCodeSame(400);
        self::assertResponseFormatSame('json');

        $data = Json\typed($this->browser->getResponse()->getContent() ?: '', Type\shape([
            'errors' => Type\vec(Type\shape([
                'code' => Type\non_empty_string(),
                'field' => Type\nullable(Type\non_empty_string()),
                'message' => Type\nullable(Type\non_empty_string()),
            ])),
        ]));

        self::assertCount(3, $data['errors']);

        self::assertSame('ad32d13f-c3d4-423b-909a-857b961eb720', $data['errors'][0]['code']);
        self::assertSame('namespace', $data['errors'][0]['field']);
        self::assertSame('Log namespace must not be null.', $data['errors'][0]['message']);

        self::assertSame('ad32d13f-c3d4-423b-909a-857b961eb720', $data['errors'][1]['code']);
        self::assertSame('level', $data['errors'][1]['field']);
        self::assertSame('Log level must not be null.', $data['errors'][1]['message']);

        self::assertSame('ad32d13f-c3d4-423b-909a-857b961eb720', $data['errors'][2]['code']);
        self::assertSame('template', $data['errors'][2]['field']);
        self::assertSame('Log template must not be null.', $data['errors'][2]['message']);
    }

    public function testBadRequestDueToInvalidLevel(): void
    {
        $this->post('/log-management/log', [
            'namespace' => 'events',
            'level' => 0,
            'template' => 'listener {listener} received message {message}',
        ]);

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

        self::assertSame('ae32d13f-a3d4-423b-909a-827b961eb741', $data['errors'][0]['code']);
        self::assertNull($data['errors'][0]['field']);
        self::assertNull($data['errors'][0]['message']);
    }

    public function testConflict(): void
    {
        $this->post('/log-management/log', [
            'namespace' => 'database',
            'level' => Level::Info->value,
            'template' => 'executed query {query}',
        ]);

        self::assertResponseIsSuccessful();

        $this->post('/log-management/log', [
            'namespace' => 'database',
            'level' => Level::Info->value,
            'template' => 'executed query {query}',
        ]);

        self::assertResponseStatusCodeSame(409);
    }
}

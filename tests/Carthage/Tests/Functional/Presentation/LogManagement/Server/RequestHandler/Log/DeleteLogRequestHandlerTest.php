<?php

declare(strict_types=1);

namespace Carthage\Tests\Functional\Presentation\LogManagement\Server\RequestHandler\Log;

use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Infrastructure\Shared\Symfony\Test\FunctionalTestCase;
use Psl\Json;
use Psl\Type;
use Symfony\Component\Uid\Ulid;

final class DeleteLogRequestHandlerTest extends FunctionalTestCase
{
    public function testSuccess(): void
    {
        $message = [
            'namespace' => 'events',
            'level' => Level::Debug->value,
            'template' => 'listener {listener} was invoked for event {event}',
        ];

        $this->post('/log-management/log', $message);

        self::assertResponseIsSuccessful();
        self::assertResponseFormatSame('json');

        $data = Json\typed($this->browser->getResponse()->getContent() ?: '', Type\shape([
            '@identity' => Type\non_empty_string(),
        ], allow_unknown_fields: true));

        $this->delete('/log-management/log/'.$data['@identity']);

        self::assertResponseIsSuccessful();
    }

    public function testNotFound(): void
    {
        $ulid = Ulid::fromString('01F9Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1Z1');
        $this->delete('/log-management/log/'.$ulid->toBase32());

        self::assertResponseStatusCodeSame(404);
    }
}

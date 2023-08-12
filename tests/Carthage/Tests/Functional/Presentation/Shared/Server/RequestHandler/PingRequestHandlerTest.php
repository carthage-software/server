<?php

declare(strict_types=1);

namespace Carthage\Tests\Functional\Presentation\Shared\Server\RequestHandler;

use Carthage\Infrastructure\Shared\Symfony\Test\FunctionalTestCase;
use DateTimeImmutable;
use DateTimeInterface;
use Psl\Json;
use Psl\Type;

final class PingRequestHandlerTest extends FunctionalTestCase
{
    public function testSuccess(): void
    {
        $this->browser->request('GET', '/ping');

        $response = $this->browser->getResponse();

        self::assertResponseIsSuccessful();
        self::assertResponseFormatSame('json');

        $data = Json\typed($response->getContent() ?: '', Type\shape([
            'type' => Type\literal_scalar('ping'),
            'quote' => Type\non_empty_string(),
            'time' => Type\non_empty_string(),
        ]));

        $time = DateTimeImmutable::createFromFormat(DateTimeInterface::RFC3339, $data['time']);

        self::assertInstanceOf(DateTimeImmutable::class, $time);
    }
}

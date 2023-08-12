<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Symfony\Test;

use Psl\Json;
use Psl\Type;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

abstract class FunctionalTestCase extends WebTestCase
{
    /**
     * @var 'test'|'dev'|'prod'|null
     */
    protected ?string $environment = null;
    protected ?bool $debug = null;

    protected KernelBrowser $browser;

    protected function setUp(): void
    {
        $options = [];
        if (null !== $this->environment) {
            $options['environment'] = $this->environment;
        }

        if (null !== $this->debug) {
            $options['debug'] = $this->debug;
        }

        $this->browser = static::createClient($options, [
            'CONTENT_TYPE' => 'application/json',
        ]);
    }

    protected function get(string $uri): Response
    {
        $this->browser->request('GET', $uri, [], [], [
            'CONTENT_TYPE' => 'application/json',
        ]);

        return $this->browser->getResponse();
    }

    protected function post(string $uri, array $data = []): Response
    {
        $this->browser->request('POST', $uri, [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], Json\encode($data));

        return $this->browser->getResponse();
    }

    protected function delete(string $uri): void
    {
        $this->browser->request('DELETE', $uri, [], [], [
            'CONTENT_TYPE' => 'application/json',
        ]);
    }

    protected function put(string $uri, array $data = []): Response
    {
        $this->browser->request('PUT', $uri, [], [], [
            'CONTENT_TYPE' => 'application/json',
        ], Json\encode($data));

        return $this->browser->getResponse();
    }

    /**
     * Purge a resource.
     */
    protected function purgeResource(string $resource): void
    {
        do {
            $collection = $this->get('/'.$resource);
            $data = Json\typed($collection->getContent() ?: '', Type\shape([
                'items' => Type\vec(Type\shape([
                    'identity' => Type\non_empty_string(),
                ], true)),
            ], true));

            foreach ($data['items'] as $item) {
                $this->delete('/'.$resource.'/'.$item['identity']);
            }
        } while ([] !== $data['items']);
    }
}

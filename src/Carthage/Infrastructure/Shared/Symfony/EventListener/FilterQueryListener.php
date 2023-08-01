<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Symfony\EventListener;

use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
use Symfony\Component\HttpKernel\Event\RequestEvent;

use function is_string;

#[AsEventListener(event: RequestEvent::class)]
final readonly class FilterQueryListener
{
    public function __invoke(RequestEvent $event): void
    {
        $request = $event->getRequest();
        foreach ($request->query->all() as $key => $value) {
            if (is_string($key) && '' === $value) {
                // Remove empty query parameters.
                $request->query->remove($key);
            }
        }
    }
}

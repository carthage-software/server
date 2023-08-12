<?php

declare(strict_types=1);

namespace Carthage\Application\Shared\QueryHandler;

use Carthage\Application\Shared\Query\PingQuery;
use Carthage\Application\Shared\Resource\PingResource;
use Psl\Iter;
use Psr\Clock\ClockInterface;

final readonly class PingQueryHandler implements QueryHandlerInterface
{
    private const QUOTES = [
        'I will either find a way, or make one.',
        'If we cannot find a way, we will make one.',
        'The mirrors in your mind can reflect the best of yourself, not the worst of someone else.',
        'Many things which nature makes difficult become easy to the man who uses his brains.',
        'Perception is a tool that\'s pointed on both ends.',
        'All good things to those who wait.',
        'Dogs keep a promise a person can\'t.',
        'We will find a way or we shall make one',
        'Discourtesy is unspeakably ugly to me.',
        'I was curious what would happen.',
    ];

    public function __construct(
        private ClockInterface $clock,
    ) {
    }

    public function __invoke(PingQuery $query): PingResource
    {
        $quote = Iter\random(self::QUOTES);
        $time = $this->clock->now();

        return PingResource::fromQuoteAndTime($quote, $time);
    }
}

<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Metric;

use Carthage\Application\MetricCollection\Resource\Metric\MetricNamespaceResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResource;

/**
 * @implements QueryInterface<CollectionResource<MetricNamespaceResource>>
 */
final class GetMetricNamespaceCollectionQuery implements QueryInterface
{
}

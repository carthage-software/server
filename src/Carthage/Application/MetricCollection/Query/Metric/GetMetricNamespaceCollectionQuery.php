<?php

declare(strict_types=1);

namespace Carthage\Application\MetricCollection\Query\Metric;

use Carthage\Application\MetricCollection\Resource\Metric\MetricNamespaceResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResourceInterface;

/**
 * @implements QueryInterface<CollectionResourceInterface<MetricNamespaceResource>>
 */
final class GetMetricNamespaceCollectionQuery implements QueryInterface
{
}

<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log;

use Carthage\Application\LogManagement\Resource\Log\LogNamespaceResource;
use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Application\Shared\Resource\CollectionResource;

/**
 * @implements QueryInterface<CollectionResource<LogNamespaceResource>>
 */
final class GetLogNamespaceCollectionQuery implements QueryInterface
{
}

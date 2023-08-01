<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Doctrine\EventListener;

use Doctrine\Bundle\DoctrineBundle\Attribute\AsDoctrineListener;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Schema\PostgreSQLSchemaManager;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;

/**
 * This event listener provides a work-around the pgsql schema bug in doctrine dbal.
 *
 * @see https://github.com/doctrine/dbal/issues/1110
 *
 * @psalm-suppress TypeDoesNotContainType
 * @psalm-suppress RedundantCondition
 */
#[AsDoctrineListener(ToolEvents::postGenerateSchema)]
final class PostgresSchemaListener
{
    /**
     * @throws Exception
     */
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schema_manager = $args
            ->getEntityManager()
            ->getConnection()
            ->createSchemaManager();

        if (!$schema_manager instanceof PostgreSQLSchemaManager) {
            return;
        }

        $schema = $args->getSchema();
        foreach ($schema_manager->listSchemaNames() as $namespace) {
            if (!$schema->hasNamespace($namespace)) {
                $schema->createNamespace($namespace);
            }
        }
    }
}

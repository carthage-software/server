<?php

declare(strict_types=1);

namespace Carthage\Application\LogManagement\Query\Log;

use Carthage\Application\Shared\Query\QueryInterface;
use Carthage\Domain\LogManagement\Enum\Log\Level;
use Carthage\Domain\LogManagement\Resource\Log\LogResource;
use Carthage\Domain\Shared\Criteria;
use Carthage\Domain\Shared\Entity\Identity;

/**
 * @implements QueryInterface<null|LogResource>
 */
final class GetLogQuery implements QueryInterface
{
    private function __construct(
        public Criteria\Criteria $criteria,
    ) {
    }

    public static function with(Criteria\Criteria $criteria): self
    {
        return new self($criteria);
    }

    public static function withIdentity(Identity $logIdentity): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Comparison::equal('id', $logIdentity),
        ));
    }

    public static function withLevelAndTemplateInNamespace(Level $level, string $template, string $namespace): self
    {
        return self::with(Criteria\Criteria::create(
            Criteria\Expression\Composition::and(
                Criteria\Expression\Comparison::equal('namespace', $namespace),
                Criteria\Expression\Comparison::equal('level', $level),
                Criteria\Expression\Comparison::equal('template', $template),
            ),
        ));
    }
}

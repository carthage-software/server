<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Resource\Summary;

use Carthage\Domain\MetricCollection\Entity\Summary\Summary;
use Carthage\Domain\MetricCollection\Enum\Metric\Temporality;
use Carthage\Domain\MetricCollection\Resource\Metric\MetricResource;
use DateTimeImmutable;
use Symfony\Component\Uid\Ulid;

/**
 * The SummaryResource class represents a summary metric in the system, designed for serialization.
 */
final readonly class SummaryResource extends MetricResource
{
    protected const TYPE = 'summary';

    public Temporality $temporality;

    /**
     * Constructs a SummaryResource.
     *
     * @param non-empty-string $namespace - The namespace of the summary
     * @param non-empty-string $name - The name of the summary
     * @param non-empty-string|null $description - The description of the summary
     * @param non-empty-string|null $unit - The unit of the summary
     */
    public function __construct(
        Ulid $id,
        string $namespace,
        string $name,
        ?string $description,
        ?string $unit,
        Temporality $temporality,
        DateTimeImmutable $createdAt,
        DateTimeImmutable $updatedAt,
    ) {
        parent::__construct($id, $namespace, $name, $description, $unit, $createdAt, $updatedAt);

        $this->temporality = $temporality;
    }

    public static function fromSummary(Summary $summary): self
    {
        return new self(
            $summary->getIdentity(),
            $summary->namespace,
            $summary->name,
            $summary->description,
            $summary->unit,
            $summary->temporality,
            $summary->createdAt,
            $summary->updatedAt,
        );
    }

    /**
     * @return array{
     *      "@type": non-empty-string,
     *      "@id": string,
     *      "namespace": non-empty-string,
     *      "name": non-empty-string,
     *      "description": non-empty-string|null,
     *      "unit": non-empty-string|null,
     *      "created_at": non-empty-string,
     *      "updated_at": non-empty-string,
     *      "temporality": array{
     *          "name": non-empty-string,
     *          "value": non-empty-string,
     *      },
     *  }
     */
    public function jsonSerialize(): array
    {
        $result = $this->jsonSerializeMetric();
        $result['temporality'] = $this->temporality->jsonSerialize();

        return $result;
    }
}

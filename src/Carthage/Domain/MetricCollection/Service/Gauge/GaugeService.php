<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Service\Gauge;

use Carthage\Domain\MetricCollection\DataTransferObject\Gauge\CreateGauge;
use Carthage\Domain\MetricCollection\Entity\Gauge\Gauge;
use Carthage\Domain\MetricCollection\Exception\Gauge\ConflictException;
use Carthage\Domain\MetricCollection\Exception\Gauge\NotFoundException;
use Carthage\Domain\MetricCollection\Repository\Gauge\GaugeRepositoryInterface;
use Symfony\Component\Uid\Ulid;

final readonly class GaugeService
{
    public function __construct(
        private GaugeRepositoryInterface $gaugeRepository,
    ) {
    }

    public function createGauge(CreateGauge $createGauge): Gauge
    {
        $gauge = $this->gaugeRepository->findOneWithNameInNamespace($createGauge->name, $createGauge->namespace);
        if (null !== $gauge) {
            throw ConflictException::whenCreatingGaugeThatAlreadyExists($createGauge->name, $createGauge->namespace, $gauge->getIdentity());
        }

        $gauge = new Gauge(
            $createGauge->namespace,
            $createGauge->name,
            $createGauge->description,
            $createGauge->unit,
        );

        $this->gaugeRepository->persist($gauge);

        return $gauge;
    }

    public function deleteGauge(Ulid $gaugeId): void
    {
        $gauge = $this->gaugeRepository->findOne($gaugeId);
        if (null === $gauge) {
            throw NotFoundException::whenDeletingNonExistingGauge($gaugeId);
        }

        $this->gaugeRepository->remove($gauge);
    }
}

<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Service\Gauge;

use Carthage\Domain\MetricCollection\DataTransferObject\Gauge\CreateGaugeDataPoint;
use Carthage\Domain\MetricCollection\Entity\Gauge\GaugeDataPoint;
use Carthage\Domain\MetricCollection\Exception\Gauge\NotFoundException;
use Carthage\Domain\MetricCollection\Repository\Gauge\GaugeDataPointRepositoryInterface;
use Carthage\Domain\MetricCollection\Repository\Gauge\GaugeRepositoryInterface;
use Carthage\Domain\Shared\Entity\Identity;

final readonly class GaugeDataPointService
{
    public function __construct(
        private GaugeRepositoryInterface $gaugeRepository,
        private GaugeDataPointRepositoryInterface $gaugeDataPointRepository,
    ) {
    }

    public function createGaugeDataPoint(CreateGaugeDataPoint $createGaugeDataPoint): GaugeDataPoint
    {
        $gauge = $this->gaugeRepository->findOne($createGaugeDataPoint->metricIdentity);
        if (null === $gauge) {
            throw NotFoundException::whenCreatingGaugeDataPointForNonExistingGauge($createGaugeDataPoint->metricIdentity);
        }

        $gaugeDataPoint = new GaugeDataPoint(
            $gauge,
            $createGaugeDataPoint->source,
            $createGaugeDataPoint->startAt,
            $createGaugeDataPoint->endAt,
            $createGaugeDataPoint->value,
            $createGaugeDataPoint->attributes,
        );

        $gauge->dataPoints->add($gaugeDataPoint);

        $this->gaugeDataPointRepository->persist($gaugeDataPoint);

        return $gaugeDataPoint;
    }

    public function deleteGaugeDataPoint(Identity $gaugeDataPointIdentity): void
    {
        $gaugeDataPoint = $this->gaugeDataPointRepository->findOne($gaugeDataPointIdentity);
        if (null === $gaugeDataPoint) {
            throw NotFoundException::whenDeletingNonExistingGaugeDataPoint($gaugeDataPointIdentity);
        }

        $this->gaugeDataPointRepository->remove($gaugeDataPoint);
    }
}

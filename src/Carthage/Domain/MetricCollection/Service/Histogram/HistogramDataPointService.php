<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Service\Histogram;

use Carthage\Domain\MetricCollection\DataTransferObject\Histogram\CreateHistogramDataPoint;
use Carthage\Domain\MetricCollection\Entity\Histogram\HistogramDataPoint;
use Carthage\Domain\MetricCollection\Exception\Histogram\NotFoundException;
use Carthage\Domain\MetricCollection\Repository\Histogram\HistogramDataPointRepositoryInterface;
use Carthage\Domain\MetricCollection\Repository\Histogram\HistogramRepositoryInterface;
use Carthage\Domain\Shared\Entity\Identity;

final readonly class HistogramDataPointService
{
    public function __construct(
        private HistogramRepositoryInterface $histogramRepository,
        private HistogramDataPointRepositoryInterface $histogramDataPointRepository,
    ) {
    }

    public function createHistogramDataPoint(CreateHistogramDataPoint $createHistogramDataPoint): HistogramDataPoint
    {
        $histogram = $this->histogramRepository->findOne($createHistogramDataPoint->metricIdentity);
        if (null === $histogram) {
            throw NotFoundException::whenCreatingHistogramDataPointForNonExistingHistogram($createHistogramDataPoint->metricIdentity);
        }

        $histogramDataPoint = new HistogramDataPoint(
            $histogram,
            $createHistogramDataPoint->source,
            $createHistogramDataPoint->startAt,
            $createHistogramDataPoint->endAt,
            $createHistogramDataPoint->lowerBound,
            $createHistogramDataPoint->upperBound,
            $createHistogramDataPoint->count,
            $createHistogramDataPoint->summation,
            $createHistogramDataPoint->minimum,
            $createHistogramDataPoint->maximum,
            $createHistogramDataPoint->bucketCounts,
            $createHistogramDataPoint->bucketBoundaries,
            $createHistogramDataPoint->attributes,
        );

        $histogram->dataPoints->add($histogramDataPoint);

        $this->histogramDataPointRepository->persist($histogramDataPoint);

        return $histogramDataPoint;
    }

    public function deleteHistogramDataPoint(Identity $histogramDataPointIdentity): void
    {
        $histogramDataPoint = $this->histogramDataPointRepository->findOne($histogramDataPointIdentity);
        if (null === $histogramDataPoint) {
            throw NotFoundException::whenDeletingNonExistingHistogramDataPoint($histogramDataPointIdentity);
        }

        $this->histogramDataPointRepository->remove($histogramDataPoint);
    }
}

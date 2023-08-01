<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Service\Summary;

use Carthage\Domain\MetricCollection\DataTransferObject\Summary\CreateSummaryDataPoint;
use Carthage\Domain\MetricCollection\Entity\Summary\SummaryDataPoint;
use Carthage\Domain\MetricCollection\Exception\Summary\NotFoundException;
use Carthage\Domain\MetricCollection\Repository\Summary\SummaryDataPointRepositoryInterface;
use Carthage\Domain\MetricCollection\Repository\Summary\SummaryRepositoryInterface;
use Symfony\Component\Uid\Ulid;

final readonly class SummaryDataPointService
{
    public function __construct(
        private SummaryRepositoryInterface $summaryRepository,
        private SummaryDataPointRepositoryInterface $summaryDataPointRepository,
    ) {
    }

    public function createSummaryDataPoint(CreateSummaryDataPoint $createSummaryDataPoint): SummaryDataPoint
    {
        $summary = $this->summaryRepository->findOne($createSummaryDataPoint->metric);
        if (null === $summary) {
            throw NotFoundException::whenCreatingSummaryDataPointForNonExistingSummary($createSummaryDataPoint->metric);
        }

        $sumDataPoint = new SummaryDataPoint(
            $summary,
            $createSummaryDataPoint->source,
            $createSummaryDataPoint->startAt,
            $createSummaryDataPoint->endAt,
            $createSummaryDataPoint->value,
            $createSummaryDataPoint->attributes,
        );

        $summary->dataPoints->add($sumDataPoint);

        $this->summaryDataPointRepository->persist($sumDataPoint);

        return $sumDataPoint;
    }

    public function deleteSummaryDataPoint(Ulid $summaryDataPointId): void
    {
        $summaryDataPoint = $this->summaryDataPointRepository->findOne($summaryDataPointId);
        if (null === $summaryDataPoint) {
            throw NotFoundException::whenDeletingNonExistingSummaryDataPoint($summaryDataPointId);
        }

        $this->summaryDataPointRepository->remove($summaryDataPoint);
    }
}

<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Service\Summary;

use Carthage\Domain\MetricCollection\DataTransferObject\Summary\CreateSummary;
use Carthage\Domain\MetricCollection\Entity\Summary\Summary;
use Carthage\Domain\MetricCollection\Exception\Summary\ConflictException;
use Carthage\Domain\MetricCollection\Exception\Summary\NotFoundException;
use Carthage\Domain\MetricCollection\Repository\Summary\SummaryRepositoryInterface;
use Symfony\Component\Uid\Ulid;

final readonly class SummaryService
{
    public function __construct(
        private SummaryRepositoryInterface $summaryRepository,
    ) {
    }

    public function createSummary(CreateSummary $createSummary): Summary
    {
        $summary = $this->summaryRepository->findOneWithNameInNamespace($createSummary->name, $createSummary->namespace);
        if (null !== $summary) {
            throw ConflictException::whenCreatingSummaryThatAlreadyExists($createSummary->name, $createSummary->namespace, $summary->getIdentity());
        }

        $summary = new Summary(
            $createSummary->namespace,
            $createSummary->name,
            $createSummary->temporality,
            $createSummary->description,
            $createSummary->unit,
        );

        $this->summaryRepository->persist($summary);

        return $summary;
    }

    public function deleteSummary(Ulid $summaryId): void
    {
        $summary = $this->summaryRepository->findOne($summaryId);
        if (null === $summary) {
            throw NotFoundException::whenDeletingNonExistingSummary($summaryId);
        }

        $this->summaryRepository->remove($summary);
    }
}

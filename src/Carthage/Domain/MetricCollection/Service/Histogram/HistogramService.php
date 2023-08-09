<?php

declare(strict_types=1);

namespace Carthage\Domain\MetricCollection\Service\Histogram;

use Carthage\Domain\MetricCollection\DataTransferObject\Histogram\CreateHistogram;
use Carthage\Domain\MetricCollection\Entity\Histogram\Histogram;
use Carthage\Domain\MetricCollection\Exception\Histogram\ConflictException;
use Carthage\Domain\MetricCollection\Exception\Histogram\NotFoundException;
use Carthage\Domain\MetricCollection\Repository\Histogram\HistogramRepositoryInterface;
use Carthage\Domain\Shared\Entity\Identity;

final readonly class HistogramService
{
    public function __construct(
        private HistogramRepositoryInterface $histogramRepository,
    ) {
    }

    public function createHistogram(CreateHistogram $createHistogram): Histogram
    {
        $histogram = $this->histogramRepository->findOneWithNameInNamespace($createHistogram->name, $createHistogram->namespace);
        if (null !== $histogram) {
            throw ConflictException::whenCreatingHistogramThatAlreadyExists($createHistogram->name, $createHistogram->namespace, $histogram->getIdentity());
        }

        $histogram = new Histogram(
            $createHistogram->namespace,
            $createHistogram->name,
            $createHistogram->temporality,
            $createHistogram->description,
            $createHistogram->unit,
        );

        $this->histogramRepository->persist($histogram);

        return $histogram;
    }

    public function deleteHistogram(Identity $histogramIdentity): void
    {
        $histogram = $this->histogramRepository->findOne($histogramIdentity);
        if (null === $histogram) {
            throw NotFoundException::whenDeletingNonExistingHistogram($histogramIdentity);
        }

        $this->histogramRepository->remove($histogram);
    }
}

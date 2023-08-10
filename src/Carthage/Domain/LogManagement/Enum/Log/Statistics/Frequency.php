<?php

declare(strict_types=1);

namespace Carthage\Domain\LogManagement\Enum\Log\Statistics;

enum Frequency: string
{
    case Yearly = 'yearly';
    case Quarterly = 'quarterly';
    case Monthly = 'monthly';
    case Weekly = 'weekly';
    case Daily = 'daily';
    case Hourly = 'hourly';
}

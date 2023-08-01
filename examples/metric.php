<?php

declare(strict_types=1);

namespace Carthage\Examples;

use DateTimeImmutable;
use DateTimeInterface;
use Psl\Async;
use Psl\SecureRandom;
use Symfony\Contracts\HttpClient\HttpClientInterface;

use function count;
use function zend_version;

use const PHP_EOL;
use const PHP_SAPI;
use const PHP_VERSION;

/** @var HttpClientInterface $client */
$client = require __DIR__.'/bootstrap.php';
$dataPoints = [
    'app' => [
        'user_registrations' => [],
        'articles_published' => [],
        'comments_posted' => [],
    ],
    'php' => [
        'memory' => [],
        'memory_peak' => [],
        'memory_real' => [],
        'memory_peak_real' => [],
        'load_average' => [],
    ],
];

for ($i = 1; $i <= 4; ++$i) {
    $start = new DateTimeImmutable();

    Async\sleep(0.2);
    $usersRegistered = SecureRandom\int(0, 1000);
    $articlesPublished = SecureRandom\int(0, 1000);
    $commentsPosted = SecureRandom\int(0, 1000);

    $end = new DateTimeImmutable();

    $dataPoints['app']['user_registrations'][] = [
        'start_at' => $start->format(DateTimeInterface::RFC3339_EXTENDED),
        'end_at' => $end->format(DateTimeInterface::RFC3339_EXTENDED),
        'value' => $usersRegistered,
    ];

    $dataPoints['app']['articles_published'][] = [
        'start_at' => $start->format(DateTimeInterface::RFC3339_EXTENDED),
        'end_at' => $end->format(DateTimeInterface::RFC3339_EXTENDED),
        'value' => $articlesPublished,
    ];

    $dataPoints['app']['comments_posted'][] = [
        'start_at' => $start->format(DateTimeInterface::RFC3339_EXTENDED),
        'end_at' => $end->format(DateTimeInterface::RFC3339_EXTENDED),
        'value' => $commentsPosted,
    ];

    $dataPoints['php']['memory'][] = [
        'start_at' => $start->format(DateTimeInterface::RFC3339_EXTENDED),
        'end_at' => $end->format(DateTimeInterface::RFC3339_EXTENDED),
        'value' => memory_get_usage(),
    ];

    $dataPoints['php']['memory_peak'][] = [
        'start_at' => $start->format(DateTimeInterface::RFC3339_EXTENDED),
        'end_at' => $end->format(DateTimeInterface::RFC3339_EXTENDED),
        'value' => memory_get_peak_usage(),
    ];

    $dataPoints['php']['memory_real'][] = [
        'start_at' => $start->format(DateTimeInterface::RFC3339_EXTENDED),
        'end_at' => $end->format(DateTimeInterface::RFC3339_EXTENDED),
        'value' => memory_get_usage(true),
    ];

    $dataPoints['php']['memory_peak_real'][] = [
        'start_at' => $start->format(DateTimeInterface::RFC3339_EXTENDED),
        'end_at' => $end->format(DateTimeInterface::RFC3339_EXTENDED),
        'value' => memory_get_peak_usage(true),
    ];

    $dataPoints['php']['load_average'][] = [
        'start_at' => $start->format(DateTimeInterface::RFC3339_EXTENDED),
        'end_at' => $end->format(DateTimeInterface::RFC3339_EXTENDED),
        'value' => sys_getloadavg()[0],
    ];

    echo 'completed iteration '.$i.PHP_EOL;
}

$map = static function (array $dataPoints): array {
    static $host;
    if (null === $host) {
        $host = gethostname() ?: 'unknown';
    }

    return array_map(static function (array $data) use ($host): array {
        return [
            'source' => $host,
            'start_at' => $data['start_at'],
            'end_at' => $data['end_at'],
            'value' => $data['value'],
            'attributes' => [
                'php_version' => PHP_VERSION,
                'zend_version' => zend_version(),
                'php_sapi' => PHP_SAPI,
            ],
        ];
    }, $dataPoints);
};

$gauges = [
    [
        'gauge' => [
            'namespace' => 'php',
            'name' => 'memory',
            'description' => 'The memory usage of the PHP process',
            'unit' => 'byte',
        ],
        'data_points' => $map($dataPoints['php']['memory']),
    ],
    [
        'gauge' => [
            'namespace' => 'php',
            'name' => 'memory_peak',
            'description' => 'The peak memory usage of the PHP process',
            'unit' => 'byte',
        ],
        'data_points' => $map($dataPoints['php']['memory_peak']),
    ],
    [
        'gauge' => [
            'namespace' => 'php',
            'name' => 'memory_real',
            'description' => 'The real memory usage of the PHP process',
            'unit' => 'byte',
        ],
        'data_points' => $map($dataPoints['php']['memory_real']),
    ],
    [
        'gauge' => [
            'namespace' => 'php',
            'name' => 'memory_peak_real',
            'description' => 'The peak real memory usage of the PHP process',
            'unit' => 'byte',
        ],
        'data_points' => $map($dataPoints['php']['memory_peak_real']),
    ],
    [
        'gauge' => [
            'namespace' => 'php',
            'name' => 'load_average',
            'description' => 'The load average of the PHP process',
            'unit' => 'byte',
        ],
        'data_points' => $map($dataPoints['php']['load_average']),
    ],
];

$summaries = [
    [
        'summary' => [
            'namespace' => 'app',
            'name' => 'user_registrations',
            'description' => 'The number of users registered',
            'unit' => null,
            'temporality' => 'DELTA',
        ],
        'data_points' => $map($dataPoints['app']['user_registrations']),
    ],
    [
        'summary' => [
            'namespace' => 'app',
            'name' => 'articles_published',
            'description' => 'The number of articles published',
            'unit' => null,
            'temporality' => 'DELTA',
        ],
        'data_points' => $map($dataPoints['app']['articles_published']),
    ],
    [
        'summary' => [
            'namespace' => 'app',
            'name' => 'comments_posted',
            'description' => 'The number of comments posted',
            'unit' => null,
            'temporality' => 'DELTA',
        ],
        'data_points' => $map($dataPoints['app']['comments_posted']),
    ],
];

$res = $client->request('POST', '/metric-collection/collect', [
    'json' => [
        'collect_gauges' => $gauges,
        'collect_summaries' => $summaries,
    ],
]);

if (202 !== $res->getStatusCode()) {
    echo 'failed to send metrics';

    var_dump($res->getHeaders(false), $res->getContent(false));

    return;
}

echo 'sent '.count($gauges).' gauges, with total of '.array_sum(array_map(static function (array $gauge): int {
    return count($gauge['data_points']);
}, $gauges)).' data points'.PHP_EOL;

echo 'sent '.count($summaries).' summaries, with total of '.array_sum(array_map(static function (array $summary): int {
    return count($summary['data_points']);
}, $summaries)).' data points'.PHP_EOL;

echo PHP_EOL;

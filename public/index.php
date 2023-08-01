<?php

use Carthage\Infrastructure\Shared\Symfony\Kernel;
use Symfony\Component\ErrorHandler\Debug;
use Symfony\Component\HttpFoundation\Request;

(static function (): void {
    require dirname(__DIR__) . '/config/bootstrap.php';

    $environment = $_SERVER['APP_ENV'] ?? 'dev';
    $debug = (bool) ($_SERVER['APP_DEBUG'] ?? ('prod' !== $environment));

    if ($debug) {
        umask(0000);

        if (class_exists(Debug::class)) {
            Debug::enable();
        }
    }
    
    $kernel = new Kernel($environment, $debug);

    $request = Request::createFromGlobals();

    $response = $kernel->handle($request);
    $response->send();

    $kernel->terminate($request, $response);
})();

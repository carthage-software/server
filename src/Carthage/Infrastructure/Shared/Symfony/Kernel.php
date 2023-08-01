<?php

declare(strict_types=1);

namespace Carthage\Infrastructure\Shared\Symfony;

use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

final class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * Configures the container.
     */
    private function configureContainer(ContainerConfigurator $container): void
    {
        $config = $this->getConfigDir();

        $container->import($config.'/{packages}/*.xml');
        $container->import($config.'/{packages}/'.$this->environment.'/*.xml');

        $container->import($config.'/{services}.xml');
    }

    /**
     * Adds or imports routes into your application.
     */
    private function configureRoutes(RoutingConfigurator $routes): void
    {
        $config = $this->getConfigDir();

        $routes->import($config.'/{routes}/'.$this->environment.'/*.xml');
        $routes->import($config.'/{routes}/*.xml');

        $routes->import($config.'/{routes}.xml');
    }
}

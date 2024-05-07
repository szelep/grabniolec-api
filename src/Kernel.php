<?php

namespace App;

use App\SharedKernel\Infrastructure\HttpClient\DependencyInjection\HttpClientExtension;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    protected function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->registerExtension(new HttpClientExtension());
        $container->loadFromExtension(HttpClientExtension::NAME);
    }
}

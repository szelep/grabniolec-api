<?php

declare(strict_types=1);

namespace App\SharedKernel\Infrastructure\HttpClient\DependencyInjection;

use App\SharedKernel\Infrastructure\HttpClient\Contract\ExternalApiClientInterface;
use App\SharedKernel\Infrastructure\HttpClient\Protocol\Rest\RestClient;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

final class HttpClientExtension extends Extension
{
    public const NAME = 'http_client';
    private const SERVICE_PREXIX = 'api_client.';
    private const CLIENT_FACTORY_METHOD = 'create';

    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $resolved = $container->resolveEnvPlaceholders($config, true);

        foreach ($resolved['rest_clients'] as $clientName => $args) {
            $this->registerClient($container, RestClient::class, $clientName, $args);
        }
    }

    private function registerClient(ContainerBuilder $container, string $clientClass, string $clientName, array $args): void
    {
        $serviceId = self::SERVICE_PREXIX.$clientName;
        $container->register($serviceId, $clientClass)
            ->setFactory([$clientClass, self::CLIENT_FACTORY_METHOD])
            ->setAutoconfigured(true)
            ->setAutowired(true)
            ->setArguments([
                ...self::normalizeArgs($args),
                '$clientName' => $clientName,
            ])
        ;

        $serviceAlias = \sprintf(
            '%s $%sClient',
            ExternalApiClientInterface::class,
            self::toCamelCase($clientName)
        );
        $container->setAlias($serviceAlias, $serviceId);
    }

    private static function normalizeArgs(array $args): array
    {
        $updated = [];
        foreach ($args as $key => $value) {
            $updated['$'.$key] = $value;
        }

        return $updated;
    }

    private static function toCamelCase(string $text): string
    {
        return \lcfirst(\str_replace('_', '', \ucwords($text, '_')));
    }
}

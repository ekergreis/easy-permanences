<?php

namespace App\DependencyInjection;

use Symfony\Component\Config\Definition\Exception\InvalidConfigurationException;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

/**
 * Injection de la configuration personnalisée.
 */
class AppExtension extends Extension
{
    /**
     * @param array            $configs
     * @param ContainerBuilder $container
     *
     * @throws InvalidConfigurationException En cas d'erreur de configuration
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $this->validateConfiguration($config);

        // Injecte la configuration dans les parameters
        $rootName = 'app';
        $container->setParameter($rootName, $config);
        $this->setConfigAsParameters($container, $config, $rootName);
    }

    /**
     * Injecte la configuration dans les parameters.
     * Permet d'accéder aux valeurs de la configuration
     * comme si elles étaient définies dans les parameters.
     *
     * @param ContainerBuilder $container
     * @param array            $params
     * @param string           $rootName
     *
     * @return void
     */
    private function setConfigAsParameters(ContainerBuilder &$container, array $params, $rootName): void
    {
        foreach ($params as $key => $value) {
            $name = sprintf('%s.%s', $rootName, $key);
            $container->setParameter($name, $value);
            if (is_array($value)) {
                $this->setConfigAsParameters($container, $value, $name);
            }
        }
    }

    /**
     * Valide la configuration.
     *
     * @param array $config
     *
     * @return void
     *
     * @throws InvalidConfigurationException
     */
    private function validateConfiguration(array $config): void
    {
        // Validation de la configuration
    }
}

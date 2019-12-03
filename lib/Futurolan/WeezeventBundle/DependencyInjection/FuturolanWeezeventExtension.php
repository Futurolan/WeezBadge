<?php


namespace Futurolan\WeezeventBundle\DependencyInjection;


use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\XmlFileLoader;
use Exception;

/**
 * Class FuturolanWeezeventExtension
 * @package Futurolan\WeezeventBundle\DependencyInjection
 */
class FuturolanWeezeventExtension extends Extension
{

    /**
     * @param array $configs
     * @param ContainerBuilder $container
     * @throws Exception
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new XmlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.xml');

        $configuration = $this->getConfiguration($configs, $container);
        $config = $this->processConfiguration($configuration, $configs);

        $definition = $container->getDefinition('futurolan_weezevent.client.weezevent_client');
        $definition->setArgument(1, $config['api']['url']);
        $definition->setArgument(2, $config['api']['key']);
        $definition->setArgument(3, $config['api']['username']);
        $definition->setArgument(4, $config['api']['password']);
    }
}
<?php


namespace Futurolan\WeezeventBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 * @package Futurolan\WeezeventBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @return TreeBuilder
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('futurolan_weezevent');
        $rootNode = $treeBuilder->getRootNode();

        $rootNode
            ->children()
                ->arrayNode('api')
                    ->info("API configuration")
                    ->children()
                        ->scalarNode('url')->defaultValue('https://api.weezevent.com/events')->end()
                        ->scalarNode('key')->defaultNull()->end()
                        ->scalarNode('token')->defaultNull()->end()
                    ->end()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }

}
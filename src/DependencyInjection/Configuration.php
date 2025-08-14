<?php

namespace Sendcloud\Bundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('sendcloud');

        $treeBuilder->getRootNode()
            ->children()
                ->scalarNode('base_url')->defaultValue('https://panel.sendcloud.sc/api/v3')->end()
                ->scalarNode('api_key')->isRequired()->cannotBeEmpty()->end()
                ->scalarNode('api_secret')->isRequired()->cannotBeEmpty()->end()
            ->end();

        return $treeBuilder;
    }
}


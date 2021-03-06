<?php

namespace Lemon\RestBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension as BaseExtension;
use Symfony\Component\DependencyInjection\Loader;

class Extension extends BaseExtension
{
    /**
     * @param array $configs
     * @param ContainerBuilder $container
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $container->setParameter('lemon_rest_object_envelope_class', $config['envelope']);
        $container->setParameter('lemon_rest_mappings', $config['mappings']);
        $container->setParameter('lemon_rest_formats', $config['formats']);
        $container->setParameter('lemon_rest_criteria_parsers', $config['criteria_parsers']);

        // Force pretty print for JMS on, no one likes their JSON ugly
        if (defined('JSON_PRETTY_PRINT')) {
            $container->setParameter(
                'jms_serializer.json_serialization_visitor.options',
                $container->getParameter('jms_serializer.json_serialization_visitor.options') | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES
            );
        }

        $loader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.yml');
    }

    public function getAlias()
    {
        return 'lemon_rest';
    }
}

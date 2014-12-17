<?php
namespace Lemon\RestBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class RegisterCriteriaParsersPass implements CompilerPassInterface
{
    /**
     * @param ContainerBuilder $container
     */
    public function process(ContainerBuilder $container)
    {
        $criteriaFactory = $container->getDefinition('lemon_rest.criteria.factory');

        $criteriaParsers = $container->getParameter('lemon_rest_criteria_parsers');

        foreach ($criteriaParsers as $criteriaParser) {
            if (strpos($criteriaParser, '@') !== 0) {
                throw new \InvalidArgumentException("The parameter 'lemon_rest.criteria_parsers' must be an array of services");
            } else if (!$container->hasDefinition($serviceName = ltrim($criteriaParser, '@'))) {
                throw new \InvalidArgumentException(sprintf("Service '%s' was not found", $criteriaParser));
            }

            $criteriaFactory->addMethodCall('addParser', array($container->getDefinition($serviceName)));
        }
    }
}

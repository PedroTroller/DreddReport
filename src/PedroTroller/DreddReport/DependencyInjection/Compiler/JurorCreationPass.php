<?php

namespace PedroTroller\DreddReport\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class JurorCreationPass implements CompilerPassInterface
{
    /**
     * {@inheritdoc}
     */
    public function process(ContainerBuilder $container)
    {
        $voters = $container->findTaggedServiceIds('security.voter');

        foreach ($voters as $id => $tags) {
            $serviceId = sprintf('dredd_report.%s.juror_voter', $id);
            $reference = $this->buildJurorDefitinion($container, $id, $serviceId);

            $container->setDefinition($serviceId, $reference);
            $container->getDefinition($id)->clearTag('security.voter');
        }
    }

    /**
     * @param ContainerBuilder $container
     * @param string           $wrappedId
     * @param string           $serviceId
     *
     * @return Definition
     */
    private function buildJurorDefitinion(ContainerBuilder $container, $wrappedId, $serviceId)
    {
        $defition = new Definition();
        $defition->setClass($container->getParameter('dredd_report.security.voter.juror_voter.class'));
        $defition->setArguments([
            new Reference($wrappedId),
            new Reference('dredd_report.court'),
        ]);
        $defition->addTag('security.voter');

        return $defition;
    }
}

<?php

namespace spec\PedroTroller\DreddReport\DependencyInjection\Compiler;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class JurorCreationPassSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PedroTroller\DreddReport\DependencyInjection\Compiler\JurorCreationPass');
    }

    function it_registers_voters(ContainerBuilder $container, Definition $definition1, Definition $definition2)
    {
        $container
            ->findTaggedServiceIds('security.voter')
            ->willReturn([
                'app.security.voter.owner_voter' => [],
                'app.security.voter.edit_voter' => [],
            ])
        ;

        $container
            ->getParameter('dredd_report.security.voter.juror_voter.class')
            ->willReturn('PedroTroller\DreddReport\Security\Voter\JurorVoter')
        ;

        $container
            ->getDefinition('app.security.voter.owner_voter')
            ->willReturn($definition1)
        ;

        $definition1->clearTag('security.voter')->shouldBeCalled();

        $container
            ->getDefinition('app.security.voter.edit_voter')
            ->willReturn($definition2)
        ;

        $definition2->clearTag('security.voter')->shouldBeCalled();

        $container
            ->setDefinition(
                'dredd_report.app.security.voter.owner_voter.juror_voter',
                Argument::type('Symfony\Component\DependencyInjection\Definition')
            )
            ->shouldBeCalled()
            ->will(function ($args) {
                list($service, $definition) = $args;

                expect($definition->getClass())
                    ->toBe('PedroTroller\DreddReport\Security\Voter\JurorVoter')
                ;
                expect((string) $definition->getArguments()[0])
                    ->toBe('app.security.voter.owner_voter')
                ;
                expect((string) $definition->getArguments()[1])
                    ->toBe('dredd_report.court')
                ;
            })
        ;

        $container
            ->setDefinition(
                'dredd_report.app.security.voter.edit_voter.juror_voter',
                Argument::type('Symfony\Component\DependencyInjection\Definition')
            )
            ->shouldBeCalled()
            ->will(function ($args) {
                list($service, $definition) = $args;

                expect($definition->getClass())
                    ->toBe('PedroTroller\DreddReport\Security\Voter\JurorVoter')
                ;
                expect((string) $definition->getArguments()[0])
                    ->toBe('app.security.voter.edit_voter')
                ;
                expect((string) $definition->getArguments()[1])
                    ->toBe('dredd_report.court')
                ;
            })
        ;

        $this->process($container);
    }
}

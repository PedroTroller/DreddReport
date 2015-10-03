<?php

namespace spec\PedroTroller\DreddReport\Security\Voter;

use PedroTroller\DreddReport\Court;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class JurorVoterSpec extends ObjectBehavior
{
    function let(VoterInterface $wrapped, Court $court)
    {
        $this->beConstructedWith($wrapped, $court);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PedroTroller\DreddReport\Security\Voter\JurorVoter');
    }

    function it_is_a_voter()
    {
        $this->shouldHaveType('Symfony\Component\Security\Core\Authorization\Voter\VoterInterface');
    }

    function it_supports_wrapped_supported_attribute($wrapped)
    {
        $wrapped
            ->supportsAttribute('ATTR')
            ->willReturn(true)
            ->shouldBeCalled()
        ;
        $wrapped
            ->supportsAttribute('OTHER')
            ->willReturn(false)
            ->shouldBeCalled()
        ;

        $this
            ->supportsAttribute('ATTR')
            ->shouldReturn(true)
        ;
        $this
            ->supportsAttribute('OTHER')
            ->shouldReturn(false)
        ;
    }

    function it_supports_wrapped_supported_class($wrapped)
    {
        $wrapped
            ->supportsClass('Symfony\Component\Security\Core\Authorization\Voter\VoterInterface')
            ->willReturn(true)
            ->shouldBeCalled()
        ;
        $wrapped
            ->supportsClass(null)
            ->willReturn(false)
            ->shouldBeCalled()
        ;

        $this
            ->supportsClass('Symfony\Component\Security\Core\Authorization\Voter\VoterInterface')
            ->shouldReturn(true)
        ;
        $this
            ->supportsClass(null)
            ->shouldReturn(false)
        ;
    }

    function it_returns_wrapped_vote($wrapped, $object, TokenInterface $token)
    {
        $wrapped
            ->vote($token, $object, ['attr1', 'atr2'])
            ->willReturn(VoterInterface::ACCESS_GRANTED)
            ->shouldBeCalled()
        ;

        $this
            ->vote($token, $object, ['attr1', 'atr2'])
            ->shouldReturn(VoterInterface::ACCESS_GRANTED)
        ;
    }

    function it_notifies_the_court_about_the_vote($wrapped, $object, TokenInterface $token, $court)
    {
        $wrapped
            ->vote($token, $object, ['attr1', 'atr2'])
            ->willReturn(VoterInterface::ACCESS_GRANTED)
        ;

        $court
            ->recieveVote($this, VoterInterface::ACCESS_GRANTED)
            ->shouldBeCalled()
        ;

        $this
            ->vote($token, $object, ['attr1', 'atr2'])
        ;
    }
}

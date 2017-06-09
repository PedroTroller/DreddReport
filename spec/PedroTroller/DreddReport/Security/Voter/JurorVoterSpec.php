<?php

namespace spec\PedroTroller\DreddReport\Security\Voter;

use PedroTroller\DreddReport\Court;
use PhpSpec\ObjectBehavior;
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

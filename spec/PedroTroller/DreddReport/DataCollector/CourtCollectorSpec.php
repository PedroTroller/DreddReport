<?php

namespace spec\PedroTroller\DreddReport\DataCollector;

use PedroTroller\DreddReport\Security\Voter\JurorVoter;
use PhpSpec\ObjectBehavior;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class CourtCollectorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('PedroTroller\DreddReport\DataCollector\CourtCollector');
    }

    function it_is_a_court()
    {
        $this->shouldHaveType('PedroTroller\DreddReport\Court');
    }

    function it_returns_the_ballots(TokenInterface $token, JurorVoter $voter1, JurorVoter $voter2, $object)
    {
        $this->newPoll($token, ['AUTHENTICATED_FULLY'], null);

        $this->recieveVote($voter1, VoterInterface::ACCESS_GRANTED);
        $this->recieveVote($voter2, VoterInterface::ACCESS_ABSTAIN);

        $this->newPoll($token, ['EDIT', 'REMOVE'], $object);

        $this->recieveVote($voter1, VoterInterface::ACCESS_DENIED);
    }
}

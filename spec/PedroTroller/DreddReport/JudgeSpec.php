<?php

namespace spec\PedroTroller\DreddReport;

use PedroTroller\DreddReport\Court;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class JudgeSpec extends ObjectBehavior
{
    function let(Court $court, AccessDecisionManagerInterface $wrapped)
    {
        $this->beConstructedWith($court, $wrapped);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('PedroTroller\DreddReport\Judge');
    }
}

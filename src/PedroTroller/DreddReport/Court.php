<?php

namespace PedroTroller\DreddReport;

use PedroTroller\DreddReport\Security\Voter\JurorVoter;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

interface Court
{
    public function addJuror(JurorVoter $joror);

    public function newPoll(TokenInterface $token, array $arguments, $object = null);

    public function recieveVote(JurorVoter $voter, $result);

    public function setSentence($result);
}

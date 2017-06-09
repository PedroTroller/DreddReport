<?php

namespace PedroTroller\DreddReport\Security\Voter;

use PedroTroller\DreddReport\Court;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\VoterInterface;

class JurorVoter implements VoterInterface
{
    /** @var VoterInterface */
    private $wrapped;

    /** @var Court */
    private $court;

    /**
     * @param VoterInterface $wrapped
     * @param Court          $court
     */
    public function __construct(VoterInterface $wrapped, Court $court)
    {
        $this->wrapped = $wrapped;
        $this->court   = $court;

        $court->addJuror($this);
    }

    /**
     * @return VoterInterface
     */
    public function getJuror()
    {
        return $this->wrapped;
    }

    /**
     * {@inheritdoc}
     */
    public function vote(TokenInterface $token, $object, array $attributes)
    {
        $result = $this
            ->wrapped
            ->vote($token, $object, $attributes)
        ;

        $this
            ->court
            ->recieveVote($this, $result)
        ;

        return $result;
    }
}

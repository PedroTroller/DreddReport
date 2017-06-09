<?php

namespace PedroTroller\DreddReport;

use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class Judge implements AccessDecisionManagerInterface
{
    /** @var Court */
    private $court;

    /** @var AccessDecisionManagerInterface */
    private $wrapped;

    /**
     * @param AccessDecisionManagerInterface $wrapped
     */
    public function __construct(Court $court, AccessDecisionManagerInterface $wrapped)
    {
        $this->court   = $court;
        $this->wrapped = $wrapped;
    }

    /**
     * {@inheritdoc}
     */
    public function decide(TokenInterface $token, array $attributes, $object = null)
    {
        $this
            ->court
            ->newPoll($token, $attributes, $object)
        ;

        $result = $this
            ->wrapped
            ->decide($token, $attributes, $object)
        ;

        $this
            ->court
            ->setSentence($result)
        ;

        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsAttribute($attribute)
    {
        return $this
            ->wrapped
            ->supportsAttribute($attribute)
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsClass($class)
    {
        return $this
            ->wrapped
            ->supportsClass($class)
        ;
    }
}

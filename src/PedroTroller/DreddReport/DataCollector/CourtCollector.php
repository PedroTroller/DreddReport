<?php

namespace PedroTroller\DreddReport\DataCollector;

use PedroTroller\DreddReport\Court;
use PedroTroller\DreddReport\Security\Voter\JurorVoter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class CourtCollector extends DataCollector implements Court
{
    /**
     * @var string
     */
    private $case;

    /**
     * @var JurorVoter[]
     */
    private $jurors = [];

    /**
     * {@inheritdoc}
     */
    public function addJuror(JurorVoter $juror)
    {
        $this->jurors[] = $juror;
    }

    /**
     * {@inheritdoc}
     */
    public function newPoll(TokenInterface $token, array $arguments, $object = null)
    {
        $this->case = uniqid();

        $this->data['polls'][$this->case] = [
            'arguments' => $arguments,
            'object'    => $this->varToString($object),
            'token'     => $this->varToString($token),
            'sentence'  => null
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function recieveVote(JurorVoter $voter, $result)
    {
        $this->data['cases'][$this->case]['votes'][] = [
            'juror' => get_class($voter->getJuror()),
            'vote'  => $result,
        ];
    }

    public function setSentence($result)
    {
        $this->data['polls'][$this->case]['sentence'] = $result;
    }

    /**
     * {@inheritdoc}
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        if (false === array_key_exists('cases', $this->data)) {
            $this->data['cases'] = [];
        }

        if (false === array_key_exists('polls', $this->data)) {
            $this->data['polls'] = [];
        }
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'dredd_report';
    }
}

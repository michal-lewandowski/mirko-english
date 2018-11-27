<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 14.11.18
 * Time: 20:57
 */

namespace App\Words\Model;

use App\Participants\Model\Participant;

class ParticipantWord
{
    /**
     * @var Participant
     */
    private $participant;
    /**
     * @var Word
     */
    private $word;

    public function __construct(Participant $participant, Word $word)
    {
        $this->participant = $participant;
        $this->word = $word;
    }

    public function getParticipant(): Participant
    {
        return $this->participant;
    }

    public function setParticipant(Participant $participant): void
    {
        $this->participant = $participant;
    }

    public function getWord(): Word
    {
        return $this->word;
    }

    public function setWord(Word $word): void
    {
        $this->word = $word;
    }

}
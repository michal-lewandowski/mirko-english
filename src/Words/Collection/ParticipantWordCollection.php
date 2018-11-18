<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 14.11.18
 * Time: 21:01
 */

namespace App\Words\Collection;

use App\Core\Collection\ObjectCollection;
use App\Participants\Collection\ParticipantsCollection;
use App\Words\Model\ParticipantWord;
use App\Words\Model\Word;

class ParticipantWordCollection extends ObjectCollection
{
    public function __construct(array $elements = [])
    {
        parent::__construct(ParticipantWord::class, $elements);
    }

    public static function createFromWordsAndParticipants(
        WordsCollection $wordsCollection,
        ParticipantsCollection $participantsCollection
    ): self
    {
        $participantWordCollection = new self();
        foreach ($participantsCollection as $participant) {
            $participantWord = new ParticipantWord($participant, self::getRandomWord($wordsCollection));
            $participantWordCollection->add($participantWord);
        }

        return $participantWordCollection;
    }

    private static function getRandomWord(WordsCollection $collection): Word
    {
        return $collection->toArray()[rand(0, $collection->count()-1)];
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 14.11.18
 * Time: 21:04
 */

namespace App\Words\Factory;


use App\Participants\Collection\ParticipantsCollection;
use App\Words\Collection\ParticipantWordCollection;
use App\Words\Collection\WordsCollection;
use App\Words\Model\ParticipantWord;
use App\Words\Model\Word;

class ParticipantWordCollectionFactory
{
    public static function create(WordsCollection $wordsCollection, ParticipantsCollection $participantsCollection): ParticipantWordCollection
    {
        $participantWordCollection = new ParticipantWordCollection();
        foreach ($participantsCollection as $participant) {
            $participantWord = new ParticipantWord($participant, self::getRandomWord($wordsCollection));
            $participantWordCollection->add($participantWord);
        }

        return $participantWordCollection;
    }

}
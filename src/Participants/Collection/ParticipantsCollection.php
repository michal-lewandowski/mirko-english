<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 14.11.18
 * Time: 19:42
 */

namespace App\Participants\Collection;

use App\Participants\Model\Participant;
use App\Core\Collection\ObjectCollection;

class ParticipantsCollection extends ObjectCollection
{
    public function __construct(array $elements = [])
    {
        parent::__construct(Participant::class, $elements);
    }

    public static function createFromApiResponse(array $participants)
    {
        $participantsCollection = new self();
        foreach ($participants as $participant) {
            $participant = new Participant($participant['author']['login']);
            $participantsCollection->add($participant);
        }

        return $participantsCollection;
    }
}

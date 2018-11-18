<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 14.11.18
 * Time: 21:25
 */

namespace App\Posts\Model;

use App\Words\Collection\ParticipantWordCollection;
use App\Words\Model\ParticipantWord;

class Comment
{
    const MAX_USER_CALLS = 49;

    /**
     * @var ParticipantWordCollection
     */
    private $participantWordsCollection;

    public function __construct(ParticipantWordCollection $participantWordsCollection)
    {
        if (count($participantWordsCollection) > self::MAX_USER_CALLS) {
            throw new \InvalidArgumentException(sprintf(
                'You can call only %d users in one comment',
                self::MAX_USER_CALLS
            ));
        }
        $this->participantWordsCollection = $participantWordsCollection;
    }

    public function __toString()
    {
        $result = '';
        /** @var ParticipantWord $participantWord */
        foreach ($this->participantWordsCollection as $participantWord) {
            $word = $participantWord->getWord();
            $result .= sprintf(
                '@%s %s-%s'.PHP_EOL,
                $participantWord->getParticipant()->getUsername(),
                $word->getWord(),
                $word->getTranslation()
            );
        }

        return $result;
    }
}
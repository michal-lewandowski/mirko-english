<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 17.11.18
 * Time: 13:55
 */

namespace App\Posts\Collection;

use App\Core\Collection\ObjectCollection;
use App\Posts\Model\Comment;
use App\Words\Collection\ParticipantWordCollection;

class CommentsCollection extends ObjectCollection
{
    public function __construct(array $elements = [])
    {
        parent::__construct(Comment::class, $elements);
    }

    public static function createFromParticipantsWords(ParticipantWordCollection $participantWordCollection): self
    {
        $commentsCollection = new self();
        $participantsWordsChunks = array_chunk($participantWordCollection->toArray(),Comment::MAX_USER_CALLS);

        foreach ($participantsWordsChunks as $participantsWordsChunk) {
            $chunkCollection = new ParticipantWordCollection($participantsWordsChunk);
            $commentsCollection->add(new Comment($chunkCollection));
        }

        return $commentsCollection;
    }
}
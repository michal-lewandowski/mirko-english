<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 27.11.18
 * Time: 19:35
 */

namespace App;

use App\Core\WykopApiClient;
use App\Posts\Collection\CommentsCollection;
use App\Posts\Model\Comment;
use App\Posts\Model\Entry;
use App\Posts\Model\EntryTemplate;

class WordsPoster
{
    const POST_ENTRY = 'Entries/Add';
    const POST_COMMENT = 'Entries/CommentAdd';
    /**
     * @var WykopApiClient
     */
    private $client;

    public function __construct(WykopApiClient $client) {
        $this->client = $client;
    }

    public function postEntry(EntryTemplate $template): Entry
    {
        $newEntryResponse = $this->client->post(self::POST_ENTRY, [
            'body' => (string) $template
        ]);
        return new Entry((int) $newEntryResponse['data']['id'], $template);
    }

    public function postComments(
        Entry $entry,
        CommentsCollection $commentsCollection
    ): void
    {
        /** @var Comment $comment */
        foreach ($commentsCollection as $comment) {
            $this->postComment($entry, $comment);
        }
    }

    public function postComment(Entry $entry, Comment $comment): void
    {
        $commentPosted = false;
        $commentUri = sprintf('%d/%d',self::POST_COMMENT,$entry->getId());
        while (false === $commentPosted) {
            $response = $this->client->post($commentUri, ['body' => $comment->__toString()]);
            // Wait 60sec in case when wykop antispam blocks sending comments
            if (isset($response['error']['code'])) {
                sleep(60);
            } else {
                $commentPosted = true;
                sleep(5);
            }
        }
    }
}
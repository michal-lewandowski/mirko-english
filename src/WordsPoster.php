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
    /**
     * @var WykopApiClient
     */
    private $client;


    public function __construct(WykopApiClient $client) {
        $this->client = $client;
    }

    public function postEntry(EntryTemplate $template): Entry
    {
        $newEntryResponse = $this->client->post('Entries/Add', [
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

    private function postComment(Entry $entry, Comment $comment): void
    {
        $commentPosted = false;
        while (false === $commentPosted) {
            $response = $this->client->post('/Entries/CommentAdd/'.$entry->getId(), ['body' => $comment->__toString()]);
            // In case when wykop antispam blocks sending comments
            if (isset($response['error']['code'])) {
                sleep(60);
            } else {
                $commentPosted = true;
                sleep(5);
            }
        }
    }
}
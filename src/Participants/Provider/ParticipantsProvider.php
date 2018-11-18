<?php
/**
 * Created by PhpStorm.
 * User: michal
 * Date: 14.11.18
 * Time: 19:51
 */

namespace App\Participants\Provider;

use App\Core\WykopClient;
use App\Participants\Collection\ParticipantsCollection;

class ParticipantsProvider
{
    private $client;

    public function __construct(WykopClient $client)
    {
        $this->client = $client;
    }

    public function getParticipantsByPostUpvotes(int $postId): ParticipantsCollection
    {
        $upvoters = $this->client->get(sprintf('Entries/Upvoters/%d', $postId));
        return ParticipantsCollection::createFromApiResponse($upvoters['data']);
    }
}
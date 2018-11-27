<?php

use App\Core\StoreManager;
use App\Core\WykopApiClient;
use App\Posts\Model\EntryTemplate;
use App\Words\Collection\ParticipantWordCollection;
use App\Words\Collection\WordsCollection;
use App\Participants\Provider\ParticipantsProvider;
use App\Posts\Collection\CommentsCollection;
use App\WordsPoster;

require_once __DIR__ . '/vendor/autoload.php';

$config = include('config.php');

$client = WykopApiClient::createFromConfig($config);
$storeManager = new StoreManager($config['postIdStorePath']);

$provider = new ParticipantsProvider($client);
$participantsCollection = $provider->getParticipantsByPostUpvotes($storeManager->getPostId());

$wordsCollection = WordsCollection::createFromCSV($config['wordsPath']);
$participantsWordsCollection = ParticipantWordCollection::createFromWordsAndParticipants($wordsCollection,$participantsCollection);
$commentsCollection = CommentsCollection::createFromParticipantsWords($participantsWordsCollection);

$wordsPoster = new WordsPoster($client);
$postTemplate = new EntryTemplate($config['template']);

$newEntry = $wordsPoster->postEntry($postTemplate);
$wordsPoster->postComments($newEntry, $commentsCollection);

$storeManager->setPostId($newEntry->getId());

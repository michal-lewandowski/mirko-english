<?php

use App\Core\WykopClient;
use App\Words\Collection\ParticipantWordCollection;
use App\Words\Collection\WordsCollection;
use App\Participants\Provider\ParticipantsProvider;
use App\Posts\Collection\CommentsCollection;

require_once __DIR__ . '/vendor/autoload.php';

// Change values of this variables
$previousPostId = (int) file_get_contents('data.txt');

$config = include('config.php');
$client = new WykopClient($config['wykopApi']['appkey'], $config['wykopApi']['secret']);
$client->logIn($config['wykopApi']['username'], $config['wykopApi']['accountkey']);

$provider = new ParticipantsProvider($client);
$participantsCollection = $provider->getParticipantsByPostUpvotes($previousPostId);

$wordsCollection = WordsCollection::createFromCSV($config['wordsFilePath']);
$participantsWordsCollection = ParticipantWordCollection::createFromWordsAndParticipants($wordsCollection,$participantsCollection);
$commentsCollection = CommentsCollection::createFromParticipantsWords($participantsWordsCollection);


$postTemplate = "
Zapraszam do kolejnego dnia zabawy #mirkoangielski  \n \n
**Każdy kto zaplusuje ten wpis dostanie następnego dnia nowe słówko do nauki. Osoby które nie chcą być jutro wołane , niech nie plusują tego wpisu.** \n \n
Jeżeli ktoś zauważył błędne tłumaczenie lub zbyt proste słowo, proszę o zgłoszenie tego w komentarzu. \n
Miłego dnia!( ͡° ͜ʖ ͡°) \n
#glupiewykopowezabawy #naukaangielskiego
";

$newEntryResponse = $client->post('Entries/Add', [
    'body' => $postTemplate
]);
$currentPostId = (int) $newEntryResponse['data']['id'];
file_put_contents('data.txt', $currentPostId);

echo sprintf('Created new post, id: %d', $currentPostId);

$commentsAmount = count($commentsCollection);
$commentsCounter = 0;
/** @var \App\Posts\Model\Comment $comment */
foreach ($commentsCollection as $comment) {
    $commentPosted = false;
    $attemptsCounter = 0;
    while (false === $commentPosted) {
        $attemptsCounter++;
        echo sprintf('POST attempt: %d', $attemptsCounter).PHP_EOL;
        echo $comment;
        $response = $client->post('/Entries/CommentAdd/'.$currentPostId, ['body' => $comment->__toString()]);

        if (isset($response['error']['code'])) {
            echo 'Error, next attempt in 60sec...'.PHP_EOL;
            sleep(60);
        } else {
            $commentsCounter++;
            $commentPosted = true;

            echo sprintf('Added comment %d/%d', $commentsCounter,$commentsAmount).PHP_EOL;
            sleep(5);
        }
    }
}

//echo PHP_EOL;

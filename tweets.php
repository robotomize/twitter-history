<?php

use alxmsl\Cli\CommandPosix;
use alxmsl\Cli\Option;
use cli\Colors;
use FoulTweets\TweetClient;
use FoulTweets\TweetModel;
use FoulTweets\UserModel;

include __DIR__ . '/src/autoload.php';
include __DIR__ . '/vendor/autoload.php';


// Just create command line option instances
$optionHelp = new Option('help', 'h', 'show help screen option');

// Create command instance
$command = new CommandPosix();

// Append created option for help to command
//$command->appendHelpParameter('show help screen option');

$name = new Option('user', 'u', 'set user name', Option::TYPE_STRING);
$since = new Option('since', 's', 'set start date', Option::TYPE_STRING);
$until = new Option('until', 'l', 'set until date', Option::TYPE_STRING);
$count = new Option('count', 'c', 'Set max count tweets', Option::TYPE_STRING);
$query = new Option('query', 'q', 'Set query', Option::TYPE_STRING);

$user = new UserModel();

$command->appendParameter($name, function($name, $value) use (&$user) {
    $user->setName($value);
});

$command->appendParameter($since, function($name, $value) use (&$user) {
    $user->setSince($value);
});
$command->appendParameter($until, function($name, $value) use (&$user) {
    $user->setUntil($value);
});
$command->appendParameter($count, function($name, $value) use (&$user) {
    $user->setCount($value);
});
$command->appendParameter($query, function($name, $value) use (&$user) {
    $user->setQuery($value);
});

// ...just parse the command
$command->parse();

$client = new TweetClient($user);
$client->run();

foreach ($client->getTweets() as $k => $tweet) {
    /** @var $tweet TweetModel */
    if (++$k <= $user->getCount()) {
        print sprintf('#%s, %s, %s', $k, $tweet->getText(), $tweet->getLink()) . PHP_EOL;
    }
}


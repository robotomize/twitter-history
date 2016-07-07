<?php

namespace FoulTweets;

use DateTime;
use GuzzleHttp\Client;
use PhpCollection\Sequence;
use Symfony\Component\DomCrawler\Crawler as DomCrawler;
use Carbon\Carbon;
use FoulTweets\UserValidator as Validator;

/**
 * Class Client
 * @package robotomize
 * @author robotomize@gmail.com
 */
class TweetClient
{

    const TWITTER_REQ = 'https://twitter.com/i/search/timeline?f=realtime&q=%s&src=typd&max_position=%s';

    const TWITTER_URI = 'https://twitter.com';

    /**
     * @var Client
     */
    private $http;

    /**
     * @var Sequence
     */
    private $tweets;

    /**
     * @var UserModel
     */
    private $user;

    /**
     * TweetClient constructor.
     * @param UserModel $user
     */
    public function __construct(UserModel $user)
    {

        Validator::validate($user);

        $this->http = new Client();
        $this->user = $user;
        $this->tweets = new Sequence();
    }

    /**
     *
     */
    public function run()
    {
        $pointer = null;

        while ($this->tweets->count() < $this->user->getCount()) {
            $request = $this->request($pointer);
            $response = $this->response($request);

            $pointer = $response['min_position'];

            $parse = new DomCrawler($response['items_html']);
            $crawler = $parse->filter('div.js-stream-tweet');

            if ($crawler->count() === 0) {
                break;
            }

            $this->crawl($crawler);
        }
    }

    /**
     * @param DomCrawler $crawler
     */
    private function crawl(DomCrawler $crawler)
    {
        $crawler->each(function ($tweetHtml) {

            /** @var $tweetHtml DomCrawler */
            $name = $tweetHtml->filter('span.username.js-action-profile-name b')->first()->text();

            $text = str_replace('[^\\u0000-\\uFFFF]', '', $tweetHtml->filter('p.js-tweet-text')->first()->text());

            $reTweets = intval(
                str_replace(
                    ',',
                    '',
                    $tweetHtml->filter('span.ProfileTweet-action--retweet span.ProfileTweet-actionCount')->first()
                        ->attr('data-tweet-stat-count')
                )
            );

            $favorites = intval(
                str_replace(
                    ',',
                    '',
                    $tweetHtml->filter('span.ProfileTweet-action--favorite span.ProfileTweet-actionCount')
                        ->first()->attr('data-tweet-stat-count')
                )
            );

            $date = new DateTime('@' . intdiv(intval($tweetHtml->filter('small.time span.js-short-timestamp')
                    ->first()->attr('data-time-ms')), 1000));

            $id = $tweetHtml->first()->attr('data-tweet-id');

            $link = $tweetHtml->first()->attr('data-permalink-path');

            preg_match("(@\\w*)", $text, $mentions);
            preg_match("(#\\w*)", $text, $hashTags);

            $geo = '';

            $geoElement = $tweetHtml->filter('span.Tweet-geo')->first();

            if ($geoElement->count() > 0) {
                $geo = $geoElement->attr('title');
            }

            $tweet = new TweetModel();

            $tweet->setId($id);
            $tweet->setLink(TweetClient::TWITTER_URI . $link);
            $tweet->setName($name);
            $tweet->setText($text);
            $tweet->setDate($date);
            $tweet->setReTweets($reTweets);
            $tweet->setFavorites($favorites);
            $tweet->setMentions($mentions);
            $tweet->setHashTag($hashTags);
            $tweet->setGeoLabel($geo);

            $this->tweets->add($tweet);
        });
    }

    /**
     * @param $pointer
     * @return string
     */
    private function request($pointer): string
    {

        $urlAppend = "";

        $urlAppend .= 'from:' . $this->user->getName();

        if ($this->user->getSince() !== null) {
            $urlAppend .= ' since:' . $this->user->getSince();
        }

        if ($this->user->getUntil() !== null) {
            $urlAppend .= ' until:' . $this->user->getUntil();
        }

        if ($this->user->getQuery() !== null) {
            $urlAppend .= ' ' . $this->user->getQuery();
        }

        return sprintf(TweetClient::TWITTER_REQ, urlencode(utf8_encode($urlAppend)), $pointer);
    }

    /**
     * @param string $req
     * @return string
     */
    private function response(string $req)
    {
        $request = $this->http->createRequest('GET', $req);
        $request->setHeader(
            'User-Agent', 'Mozilla/5.0 (Macintosh; U; Intel Mac OS X 10.4; en-US; rv:1.9.2.2) 
            Gecko/20100316 Firefox/3.6.2'
        );
        $response = $this->http->send($request);
        return $response->json();
    }

    /**
     * @return Sequence
     */
    public function getTweets(): Sequence
    {
        return $this->tweets;
    }
}

<?php
declare(strict_types = 1);

namespace FoulTweets;
use DateTime;

/**
 * Class TweetModel
 * @package robotomize
 * @author robotomize@gmail.com
 */
class TweetModel implements InterfaceModel
{
    /**
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $link;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $text;

    /**
     * @var DateTime
     */
    protected $date;

    /**
     * @var int
     */
    protected $reTweets;

    /**
     * @var int
     */
    protected $favorites;

    /**
     * @var array
     */
    protected $mentions;

    /**
     * @var array
     */
    protected $hashTag;

    /**
     * @var string
     */
    protected $geoLabel;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link)
    {
        $this->link = $link;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text)
    {
        $this->text = $text;
    }

    /**
     * @return string
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(DateTime $date)
    {
        $this->date = $date;
    }

    /**
     * @return int
     */
    public function getReTweets(): int
    {
        return $this->reTweets;
    }

    /**
     * @param int $reTweets
     */
    public function setReTweets(int $reTweets)
    {
        $this->reTweets = $reTweets;
    }

    /**
     * @return int
     */
    public function getFavorites(): int
    {
        return $this->favorites;
    }

    /**
     * @param int $favorites
     */
    public function setFavorites(int $favorites)
    {
        $this->favorites = $favorites;
    }

    /**
     * @return array
     */
    public function getMentions(): array
    {
        return $this->mentions;
    }

    /**
     * @param array $mentions
     */
    public function setMentions(array $mentions)
    {
        $this->mentions = $mentions;
    }

    /**
     * @return array
     */
    public function getHashTag(): array
    {
        return $this->hashTag;
    }

    /**
     * @param array $hashTag
     */
    public function setHashTag(array $hashTag)
    {
        $this->hashTag = $hashTag;
    }

    /**
     * @return string
     */
    public function getGeoLabel(): string
    {
        return $this->geoLabel;
    }

    /**
     * @param string $geoLabel
     */
    public function setGeoLabel(string $geoLabel)
    {
        $this->geoLabel = $geoLabel;
    }
}


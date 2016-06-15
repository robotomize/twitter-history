<?php
declare(strict_types = 1);

namespace FoulTweets;

/**
 * Class UserModel
 * @package robotomize
 * @author robotomize@gmail.com
 */
class UserModel implements InterfaceModel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $since = '';

    /**
     * @var string
     */
    protected $until = '';

    /**
     * @var string
     */
    protected $query = '';

    /**
     * @var int
     */
    protected $count = 1;

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
    public function getSince(): string
    {
        return $this->since;
    }

    /**
     * @param string $since
     */
    public function setSince(string $since)
    {
        $this->since = $since;
    }

    /**
     * @return string
     */
    public function getUntil(): string
    {
        return $this->until;
    }

    /**
     * @param string $until
     */
    public function setUntil(string $until)
    {
        $this->until = $until;
    }

    /**
     * @return string
     */
    public function getQuery(): string
    {
        return $this->query;
    }

    /**
     * @param string $query
     */
    public function setQuery(string $query)
    {
        $this->query = $query;
    }

    /**
     * @return int
     */
    public function getCount(): int
    {
        return $this->count;
    }

    /**
     * @param int $count
     */
    public function setCount(int $count)
    {
        $this->count = $count;
    }
}

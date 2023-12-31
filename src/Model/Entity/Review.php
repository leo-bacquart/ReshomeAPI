<?php

namespace Hetic\ReshomeApi\Model\Entity;
use Hetic\ReshomeApi\Model\Bases\BaseClass;

class Review extends BaseClass implements \JsonSerializable
{
    private $review_id;
    private $announce_id;
    private $user_id;
    private $rate;
    private $comment;
    private $date;


    public function getAnnounceId()
    {
        return $this->announce_id;
    }

    public function setAnnounceId($announce_id)
    {
        $this->announce_id = $announce_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getRate()
    {
        return $this->rate;
    }

    public function setRate($rate)
    {
        $this->rate = $rate;
    }

    public function getComment()
    {
        return $this->comment;
    }

    public function setComment($comment)
    {
        $this->comment = $comment;
    }

    public function getReviewId()
    {
        return $this->review_id;
    }

    public function setReviewId($review_id)
    {
        $this->review_id = $review_id;
    }

    /**
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param mixed $date
     */
    public function setDate($date): void
    {
        $this->date = $date;
    }

    public function jsonSerialize(): mixed
    {
        return (object) get_object_vars($this);
    }
}

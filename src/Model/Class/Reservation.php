<?php

namespace Hetic\ReshomeH\Model\Class;
use Hetic\ReshomeH\model\Bases\BaseClass;

class Reservation extends BaseClass
{
    private $user_id;
    private $announce_id;
    private $begin_date;
    private $end_date;
    private $cost;
    private $status;
    private $reservation_request;
    private $reservation_id;

    public function getUserId()
    {
        return $this->user_id;
    }

    public function setUserId($user_id)
    {
        $this->user_id = $user_id;
    }

    public function getAnnounceId()
    {
        return $this->announce_id;
    }

    public function setAnnounceId($announce_id)
    {
        $this->announce_id = $announce_id;
    }

    public function getBeginDate()
    {
        return $this->begin_date;
    }

    public function setBeginDate($begin_date)
    {
        $this->begin_date = $begin_date;
    }

    public function getEndDate()
    {
        return $this->end_date;
    }

    public function setEndDate($end_date)
    {
        $this->end_date = $end_date;
    }

    public function getCost()
    {
        return $this->cost;
    }

    public function setCost($cost)
    {
        $this->cost = $cost;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getReservationRequest()
    {
        return $this->reservation_request;
    }

    public function setReservationRequest($reservation_request)
    {
        $this->reservation_request = $reservation_request;
    }

    public function getReservationId()
    {
        return $this->reservation_id;
    }

    public function setReservationId($reservation_id)
    {
        $this->reservation_id = $reservation_id;
    }
}

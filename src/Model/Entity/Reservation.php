<?php

namespace Hetic\ReshomeApi\Model\Entity;

class Reservation
{
    private int $user_id;
    private int $announce_id;
    private string $begin_date;
    private string $end_date;
    private int $cost;
    private string $reservation_request;
    private int $reservation_id;
    private int $status;

    public function getUserId() : int
    {
        return $this->user_id;
    }

    public function setUserId($user_id) : void
    {
        $this->user_id = $user_id;
    }

    public function getAnnounceId() : int
    {
        return $this->announce_id;
    }

    public function setAnnounceId($announce_id) : void
    {
        $this->announce_id = $announce_id;
    }

    public function getBeginDate() : string
    {
        return $this->begin_date;
    }

    public function setBeginDate($begin_date) : void
    {
        $this->begin_date = $begin_date;
    }

    public function getEndDate() : string
    {
        return $this->end_date;
    }

    public function setEndDate($end_date) : void
    {
        $this->end_date = $end_date;
    }

    public function getCost() : int
    {
        return $this->cost;
    }

    public function setCost($cost) : void
    {
        $this->cost = $cost;
    }

    public function getReservationRequest() : string
    {
        return $this->reservation_request;
    }

    public function setReservationRequest($reservation_request) : void
    {
        $this->reservation_request = $reservation_request;
    }

    public function getReservationId() : int
    {
        return $this->reservation_id;
    }

    public function setReservationId($reservation_id) : void
    {
        $this->reservation_id = $reservation_id;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }
}

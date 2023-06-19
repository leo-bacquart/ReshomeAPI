<?php

namespace Hetic\ReshomeApi\Model\Entity;

class ReservationChat
{
    private $reservation_id;
    private $chat_id;

    public function getReservationId()
    {
        return $this->reservation_id;
    }

    public function setReservationId($reservation_id)
    {
        $this->reservation_id = $reservation_id;
    }

    public function getChatId()
    {
        return $this->chat_id;
    }

    public function setChatId($chat_id)
    {
        $this->chat_id = $chat_id;
    }
}

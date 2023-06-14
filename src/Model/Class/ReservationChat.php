<?php

namespace Hetic\ReshomeH\Model\Class;
use Hetic\ReshomeH\model\Bases\BaseClass;

class ReservationChat extends BaseClass
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

    public static function create($data)
    {
        // Code pour créer une nouvelle réservation de chat
    }

    public static function find($reservation_id, $chat_id)
    {
        // Code pour trouver une réservation de chat par son ID de réservation et ID de chat
    }

    public function update()
    {
        // Code pour mettre à jour cette réservation de chat
    }

    public function delete()
    {
        // Code pour supprimer cette réservation de chat
    }
}

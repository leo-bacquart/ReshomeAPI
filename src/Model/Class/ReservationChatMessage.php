<?php

namespace Hetic\ReshomeH\Model\Class;
use Hetic\ReshomeH\model\Bases\BaseClass;

class ReservationChatMessage extends BaseClass
{
    private $chat_id;
    private $content;
    private $message_id;

    public function getChatId()
    {
        return $this->chat_id;
    }

    public function setChatId($chat_id)
    {
        $this->chat_id = $chat_id;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content)
    {
        $this->content = $content;
    }

    public function getMessageId()
    {
        return $this->message_id;
    }

    public function setMessageId($message_id)
    {
        $this->message_id = $message_id;
    }

    public static function create($data)
    {
        // Code pour créer un nouveau message de chat de réservation
    }

    public static function find($chat_id, $message_id)
    {
        // Code pour trouver un message de chat de réservation par son ID de chat et ID de message
    }

    public function update()
    {
        // Code pour mettre à jour ce message de chat de réservation
    }

    public function delete()
    {
        // Code pour supprimer ce message de chat de réservation
    }
}

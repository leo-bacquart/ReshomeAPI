<?php

namespace Hetic\ReshomeApi\Model\Entity;

class ReservationChatMessage
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
}

<?php

namespace Hetic\ReshomeApi\Model\Manager;

use Hetic\ReshomeApi\Model\Entity\ReservationChat;

class ReservationChatManager extends BaseManager
{
    public function createChat(ReservationChat $chat)
    {
        $stmt = $this->db->prepare('INSERT INTO reservation_chat (reservation_id) VALUES (:reservation_id)');
        $stmt->bindValue('reservation_id', $chat->getReservationId());
        $stmt->execute();

        $chat->setChatId($this->db->lastInsertId());
    }

    public function findChat($chat_id)
    {
        $stmt = $this->db->prepare('SELECT * FROM reservation_chat WHERE id = :id');
        $stmt->bindValue('id', $chat_id);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            $chat = new ReservationChat();
            $chat->setReservationId($data['reservation_id']);
            $chat->setChatId($data['id']);
            return $chat;
        }

        return null;
    }

    public function updateChat(ReservationChat $chat)
    {
        $stmt = $this->db->prepare('UPDATE reservation_chat SET reservation_id = :reservation_id WHERE id = :id');
        $stmt->bindValue('reservation_id', $chat->getReservationId());
        $stmt->bindValue('id', $chat->getChatId());
        $stmt->execute();
    }

    public function deleteChat(ReservationChat $chat)
    {
        $stmt = $this->db->prepare('DELETE FROM reservation_chat WHERE id = :id');
        $stmt->bindValue('id', $chat->getChatId());
        $stmt->execute();
    }
}

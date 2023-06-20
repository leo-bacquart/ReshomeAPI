




































































<?php

namespace Hetic\ReshomeApi\Model\Manager;

use Hetic\ReshomeApi\Model\Entity\Reservation;

class ReservationManager extends BaseManager
{
    public function addReservation(Reservation $reservation)
    {
        $stmt = $this->db->prepare('INSERT INTO reservation (user_id, announce_id, begin_date, end_date, cost, reservation_request) VALUES (:user_id, :announce_id, :begin_date, :end_date, :cost, :reservation_request)');
        $stmt->bindValue('user_id', $reservation->getUserId());
        $stmt->bindValue('announce_id', $reservation->getAnnounceId());
        $stmt->bindValue('begin_date', $reservation->getBeginDate());
        $stmt->bindValue('end_date', $reservation->getEndDate());
        $stmt->bindValue('cost', $reservation->getCost());
        $stmt->bindValue('reservation_request', $reservation->getReservationRequest());
        $stmt->execute();

        $reservation->setReservationId($this->db->lastInsertId());
    }

    public function getReservationById($reservation_id)
    {
        $stmt = $this->db->prepare('SELECT * FROM reservation WHERE id = :id');
        $stmt->bindValue('id', $reservation_id);
        $stmt->execute();
        $data = $stmt->fetch();

        if ($data) {
            $reservation = new Reservation();
            $reservation->setUserId($data['user_id']);
            $reservation->setAnnounceId($data['announce_id']);
            $reservation->setBeginDate($data['begin_date']);
            $reservation->setEndDate($data['end_date']);
            $reservation->setCost($data['cost']);
            $reservation->setReservationRequest($data['reservation_request']);
            $reservation->setReservationId($data['id']);
            return $reservation;
        }

        return null;
    }

    public function updateReservation(Reservation $reservation)
    {
        $stmt = $this->db->prepare('UPDATE reservation SET user_id = :user_id, announce_id = :announce_id, begin_date = :begin_date, end_date = :end_date, cost = :cost, reservation_request = :reservation_request WHERE id = :id');
        $stmt->bindValue('user_id', $reservation->getUserId());
        $stmt->bindValue('announce_id', $reservation->getAnnounceId());
        $stmt->bindValue('begin_date', $reservation->getBeginDate());
        $stmt->bindValue('end_date', $reservation->getEndDate());
        $stmt->bindValue('cost', $reservation->getCost());
        $stmt->bindValue('reservation_request', $reservation->getReservationRequest());
        $stmt->bindValue('id', $reservation->getReservationId());
        $stmt->execute();
    }

    public function deleteReservation(Reservation $reservation)
    {
        $stmt = $this->db->prepare('DELETE FROM reservation WHERE id = :id');
        $stmt->bindValue('id', $reservation->getReservationId());
        $stmt->execute();
    }
}

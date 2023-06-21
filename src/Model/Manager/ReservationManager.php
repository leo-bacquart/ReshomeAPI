<?php

namespace Hetic\ReshomeApi\Model\Manager;

use Hetic\ReshomeApi\Model\Bases\BaseManager;
use Hetic\ReshomeApi\Model\Entity\Reservation;

class ReservationManager extends BaseManager
{
    public function addReservation(array $reservationData) : array
    {
        $query = 'INSERT INTO Reservation (user_id, announce_id, begin_date, end_date, cost, reservation_request) VALUES (:user_id, :announce_id, :begin_date, :end_date, :cost, :reservation_request)';
        $stmt = $this->db->prepare($query);
        $stmt->bindValue('user_id', $reservationData['user_id']);
        $stmt->bindValue('announce_id',$reservationData['announce_id']);
        $stmt->bindValue('begin_date',$reservationData['begin_date']);
        $stmt->bindValue('end_date',$reservationData['end_date']);
        $stmt->bindValue('cost',$reservationData['cost']);
        $stmt->bindValue('reservation_request',$reservationData['reservation_request']);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return ['message' => 'Reservation successfully created'];
        } else {
            return ['message' => 'Error while creating reservation']; // No rows were inserted
        }
    }

    public function getReservationsByUserId(int $userId) : array
    {
        $query = $this->db->prepare("SELECT * FROM Reservation where user_id = :userId");
        $query->bindValue(":userId", $userId);
        $query->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Reservation::class);

        $query->execute();
        return $query->fetchAll();
    }

    public function getReservationsByAnnounceId(int $announceId) : array
    {
        $query = $this->db->prepare("SELECT * FROM Reservation where announce_id = :announceId");
        $query->bindValue(":announceId", $announceId);
        $query->setFetchMode(\PDO::FETCH_CLASS|\PDO::FETCH_PROPS_LATE, Reservation::class);

        $query->execute();
        return $query->fetchAll();
    }

    public function updateReservation(Reservation $reservation) : void
    {
        $stmt = $this->db->prepare('UPDATE Reservation SET user_id = :user_id, announce_id = :announce_id, begin_date = :begin_date, end_date = :end_date, cost = :cost, reservation_request = :reservation_request WHERE reservation_id = :id');
        $stmt->bindValue('user_id', $reservation->getUserId());
        $stmt->bindValue('announce_id', $reservation->getAnnounceId());
        $stmt->bindValue('begin_date', $reservation->getBeginDate());
        $stmt->bindValue('end_date', $reservation->getEndDate());
        $stmt->bindValue('cost', $reservation->getCost());
        $stmt->bindValue('reservation_request', $reservation->getReservationRequest());
        $stmt->bindValue('id', $reservation->getReservationId());
        $stmt->execute();
    }

    public function deleteReservation(Reservation $reservation) : void
    {
        $stmt = $this->db->prepare('DELETE FROM Reservation WHERE reservation_id = :id');
        $stmt->bindValue('id', $reservation->getReservationId());
        $stmt->execute();
    }
}

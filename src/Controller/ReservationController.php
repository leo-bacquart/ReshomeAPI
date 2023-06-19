<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model;
use Hetic\ReshomeApi\Utils\Utils;
use Hetic\ReshomeApi\Model\Entity\Reservation;

class ReservationController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function createReservation() : void
    {
        $auth = new AuthController();
        if ($auth->verifyJwt() && ($auth->verifyJwt()->getIsAdmin() || $auth->verifyJwt()->getIsStaff()))
        {
            $fields = ['user_id', 'announce_id', 'begin_date', 'end_date', 'cost', 'reservation_request'];
            $data = array_map('htmlspecialchars', $_POST);
            $data = array_intersect_key($data, array_flip($fields));

            $reservationManager = new Model\Manager\ReservationManager();
            $reservationId = $reservationManager->addReservation(new Reservation($data));

            header('Content-Type: application/json');
            if ($reservationId) {
                echo json_encode(['message' => 'Reservation successfully created']);
            } else {
                echo json_encode(['message' => 'Error while creating Reservation']);
            }
        } else {
            echo json_encode(['message' => 'Error : User is not admin']);
        }
    }

    public function getReservation($reservation_id) : void
    {
        $reservationManager = new Model\Manager\ReservationManager();
        $reservation = $reservationManager->getReservationById($reservation_id);
        header('Content-Type: application/json');
        if ($reservation) {
            echo json_encode($reservation->jsonSerialize());
        } else {
            echo json_encode(['message' => 'Error : No reservation found with this ID']);
        }
    }

    public function updateReservation() : void
    {
        $auth = new AuthController();
        if ($auth->verifyJwt() && ($auth->verifyJwt()->getIsAdmin() || $auth->verifyJwt()->getIsStaff()))
        {
            $fields = ['reservation_id', 'user_id', 'announce_id', 'begin_date', 'end_date', 'cost', 'reservation_request'];
            $data = array_map('htmlspecialchars', $_POST);
            $data = array_intersect_key($data, array_flip($fields));

            $reservationManager = new Model\Manager\ReservationManager();
            $reservation = $reservationManager->getReservationById($data['reservation_id']);
            if($reservation){
                $reservation->set($data);
                $reservationManager->updateReservation($reservation);
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Reservation successfully updated']);
            } else {
                echo json_encode(['message' => 'Error : No reservation found with this ID']);
            }
        } else {
            echo json_encode(['message' => 'Error : User is not admin']);
        }
    }

    public function deleteReservation($reservation_id) : void
    {
        $auth = new AuthController();
        if ($auth->verifyJwt() && ($auth->verifyJwt()->getIsAdmin() || $auth->verifyJwt()->getIsStaff()))
        {
            $reservationManager = new Model\Manager\ReservationManager();
            $reservation = $reservationManager->getReservationById($reservation_id);
            if($reservation){
                $reservationManager->deleteReservation($reservation);
                header('Content-Type: application/json');
                echo json_encode(['message' => 'Reservation successfully deleted']);
            } else {
                echo json_encode(['message' => 'Error : No reservation found with this ID']);
            }
        } else {
            echo json_encode(['message' => 'Error : User is not admin']);
        }
    }
}

<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model\Manager;
use Hetic\ReshomeApi\Utils\Helper;
use Hetic\ReshomeApi\Utils\ReservationHelper;

class ReservationController extends BaseController
{
    public function createReservation(): void
    {

        $auth = new AuthController();
        $user = $auth->verifyJwt();

        if(!$user){
            echo json_encode(['message' => 'User not logged in']);
            return;
        }


        $announceId = $_POST['announce_id'];
        $begin_date = $_POST['begin_date'];
        $end_date = $_POST['end_date'];
        $reservation_request = $_POST['reservation_request'];

        if (!ReservationHelper::isAvailable($announceId, $begin_date, $end_date)) {
            echo json_encode(['message' => 'These dates are not available']);
            return;
        }

        $startTimestamp = strtotime($begin_date);
        $endTimestamp = strtotime($end_date);

        if ($endTimestamp <= $startTimestamp) {
            echo json_encode(['message' => 'You cannot book for 0 nights or negative time']);
            return;
        }

        $currentDate = strtotime(date('Y-m-d'));

        if ($startTimestamp < $currentDate) {
            echo json_encode(['message' => 'You cannot book in past dates']);
            return;
        }

        $announceManager = new Manager\AnnounceManager();
        $announce = $announceManager->getAnnounceById($announceId);

        $cost = ReservationHelper::getReservationCost($begin_date, $end_date, $announce->getPrice());

        $reservationData = [
            'user_id' => $user->getUserId(),
            'announce_id' => $announceId,
            'begin_date' => $begin_date,
            'end_date' => $end_date,
            'cost' => $cost,
            'reservation_request' => $reservation_request
        ];

        $reservationManager = new Manager\ReservationManager();

        $response = $reservationManager->addReservation($reservationData);

        echo json_encode($response);
    }

    public function getReservationsByAnnounceId() : void
    {
        $announceId = intval(htmlspecialchars($_GET['id']));
        $auth = new AuthController();
        $user = $auth->verifyJwt();

        if (!$user || (!$user->getIsAdmin() && !$user->getIsStaff())){
            echo json_encode(['message' => 'Error : You cannot access this data']);
            return;
        }

        $manager = new Manager\ReservationManager();
        $reservations = $manager->getReservationsByAnnounceId($announceId);

        $data =[];

        foreach ($reservations as $reservation) {
            $data[] = $reservation->jsonSerialize();
        }

        echo json_encode($data);
    }

    public function getSelfReservations(): void
    {
        $auth = new AuthController();
        $user = $auth->verifyJwt();

        if(!$user){
            echo json_encode(['message' => 'user not logged']);
            return;
        }

        $manager = new Manager\ReservationManager();
        $reservations = $manager->getReservationsByUserId($user->getUserId());

        $data =[];

        foreach ($reservations as $reservation) {
            $data[] = $reservation->jsonSerialize();
        }

        if (!$data) {
            echo json_encode(['message' => 'You have no reservations']);
        }
        echo json_encode($data);
    }

    public function getReservationDetail() : void
    {
        $id = intval(htmlspecialchars($_GET['id']));
        $auth = new AuthController();
        $user = $auth->verifyJwt();
        $userId = $user->getUserId();


        if (!$user) {
            echo json_encode(['message' => 'User not logged']);
            return;
        }

        $manager = new Manager\ReservationManager();

        $reservation = $manager->getReservationById($id);
        if (!$reservation) {
            echo json_encode(['message' => 'Reservation not found']);
            return;
        }

        $reservationUserId = $reservation->getUserId();

        if ($reservationUserId != $userId && !$user->getIsAdmin() && !$user->getIsStaff()) {
            echo json_encode(['message' => 'You have no rights to access this data']);
            return;
        }

        echo json_encode($reservation->jsonSerialize());
    }
}

<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model\Manager;
use Hetic\ReshomeApi\Utils\Helper;
use Hetic\ReshomeApi\Utils\ReservationHelper;

// Contrôleur pour la gestion des réservations
class ReservationController extends BaseController
{
    // Méthode pour créer une réservation
    public function createReservation(): void
    {
        // Vérifie si l'utilisateur est authentifié
        $auth = new AuthController();
        $user = $auth->verifyJwt();

        // Si l'utilisateur n'est pas authentifié, renvoie un message d'erreur
        if(!$user){
            echo json_encode(['message' => 'User not logged in']);
            return;
        }

        // Récupère les informations de la réservation
        $announceId = $_POST['announce_id'];
        $begin_date = $_POST['begin_date'];
        $end_date = $_POST['end_date'];
        $reservation_request = $_POST['reservation_request'];

        // Vérifie si les dates sont disponibles
        if (!ReservationHelper::isAvailable($announceId, $begin_date, $end_date)) {
            echo json_encode(['message' => 'These dates are not available']);
            return;
        }

        // Vérifie que la date de fin est après la date de début
        $startTimestamp = strtotime($begin_date);
        $endTimestamp = strtotime($end_date);

        if ($endTimestamp <= $startTimestamp) {
            echo json_encode(['message' => 'You cannot book for 0 nights or negative time']);
            return;
        }

        // Vérifie que la date de début est après la date courante
        $currentDate = strtotime(date('Y-m-d'));

        if ($startTimestamp < $currentDate) {
            echo json_encode(['message' => 'You cannot book in past dates']);
            return;
        }

        // Récupère l'annonce associée à la réservation
        $announceManager = new Manager\AnnounceManager();
        $announce = $announceManager->getAnnounceById($announceId);

        // Calcule le coût de la réservation
        $cost = ReservationHelper::getReservationCost($begin_date, $end_date, $announce->getPrice());

        // Prépare les données pour la création de la réservation
        $reservationData = [
            'user_id' => $user->getUserId(),
            'announce_id' => $announceId,
            'begin_date' => $begin_date,
            'end_date' => $end_date,
            'cost' => $cost,
            'reservation_request' => $reservation_request
        ];

        // Crée la réservation
        $reservationManager = new Manager\ReservationManager();

        $response = $reservationManager->addReservation($reservationData);

        // Renvoie la réponse
        echo json_encode($response);
    }

    // Méthode pour obtenir les réservations associées à une annonce
    public function getReservationsByAnnounceId() : void
    {
        // Récupère l'ID de l'annonce
        $announceId = intval(htmlspecialchars($_GET['id']));

        // Vérifie si l'utilisateur est authentifié et s'il a les droits nécessaires
        $auth = new AuthController();
        $user = $auth->verifyJwt();

        if (!$user || (!$user->getIsAdmin() && !$user->getIsStaff())){
            echo json_encode(['message' => 'Error : You cannot access this data']);
            return;
        }

        // Récupère les réservations associées à l'annonce
        $manager = new Manager\ReservationManager();
        $reservations = $manager->getReservationsByAnnounceId($announceId);

        // Prépare les données pour la réponse
        $data =[];

        foreach ($reservations as $reservation) {
            $data[] = $reservation->jsonSerialize();
        }

        // Renvoie la réponse
        echo json_encode($data);
    }

    // Méthode pour obtenir les réservations de l'utilisateur courant
    public function getSelfReservations(): void
    {
        // Vérifie si l'utilisateur est authentifié
        $auth = new AuthController();
        $user = $auth->verifyJwt();

        if(!$user){
            echo json_encode(['message' => 'user not logged']);
            return;
        }

        // Récupère les réservations de l'utilisateur
        $manager = new Manager\ReservationManager();
        $reservations = $manager->getReservationsByUserId($user->getUserId());

        // Prépare les données pour la réponse
        $data =[];

        foreach ($reservations as $reservation) {
            $data[] = $reservation->jsonSerialize();
        }

        // Renvoie la réponse
        if (!$data) {
            echo json_encode(['message' => 'You have no reservations']);
        }
        echo json_encode($data);
    }

    // Méthode pour obtenir le détail d'une réservation
    public function getReservationDetail() : void
    {
        // Récupère l'ID de la réservation
        $id = intval(htmlspecialchars($_GET['id']));

        // Vérifie si l'utilisateur est authentifié
        $auth = new AuthController();
        $user = $auth->verifyJwt();
        $userId = $user->getUserId();


        if (!$user) {
            echo json_encode(['message' => 'User not logged']);
            return;
        }

        // Récupère la réservation
        $manager = new Manager\ReservationManager();

        $reservation = $manager->getReservationById($id);
        if (!$reservation) {
            echo json_encode(['message' => 'Reservation not found']);
            return;
        }

        // Vérifie si l'utilisateur a le droit de voir cette réservation
        $reservationUserId = $reservation->getUserId();

        if ($reservationUserId != $userId && !$user->getIsAdmin() && !$user->getIsStaff()) {
            echo json_encode(['message' => 'You have no rights to access this data']);
            return;
        }

        // Renvoie la réservation
        echo json_encode($reservation->jsonSerialize());
    }
}

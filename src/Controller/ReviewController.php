<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model\Manager;
use Hetic\ReshomeApi\Utils\ReservationHelper;
use Hetic\ReshomeApi\Utils\ReviewHelper;

class ReviewController extends BaseController
{
    public function createReview() : void
    {
        // Déclaration des managers nécessaires
        $reservationManager = new Manager\ReservationManager();
        $announceManager = new Manager\AnnounceManager();
        $reviewManager = new Manager\ReviewManager();

        // Récupération des POST
        $reservationId = intval($_POST['reservation']);
        $rate = intval($_POST['rate']);
        $comment = htmlspecialchars($_POST['comment']);

        // Verification de la recevabilité des données nécessaires
        if (!$reservationId) {
            echo json_encode(['message' => 'You must give a reservation to add a review']);
            return;
        }

        if ($rate < 1 || $rate > 5) {
            echo json_encode(['message' => 'Rate should be between 1 and 5']);
            return;
        }

        // Récupération de l'user connecté
        $auth = new AuthController();
        $user = $auth->verifyJwt();
        if(!$user){
            echo json_encode(['message' => 'You need to be logged in to add a review ']);
            return;
        }

        // Récupération de la Réservation et de l'Annonce associée a la review
        $reservation = $reservationManager->getReservationById($reservationId);
        $announce = $announceManager->getAnnounceById($reservation->getAnnounceId());

        // Vérification que l'user qui envoie la requete est bien celui qui a réservé
        if ($user->getUserId() != $reservation->getUserId()) {
            echo json_encode(['message' => 'You need to be the one who booked to give a review']);
            return;
        }

        // Vérification que l'user qui envoie la requete l'envoie bien après sa réservation
        if (!ReservationHelper::isPassed($reservation)) {
            echo json_encode(['message' => 'You can give a review only after your trip']);
            return;
        }

        // Vérification que l'user n'a pas déjà donné une review
        if (ReservationHelper::hasBookedThisAnnounce($user, $announce) <= ReviewHelper::hasReviewedThisAnnounce($user, $announce)) {
            echo json_encode(['message' => 'You cannot review multiple times.']);
            return;
        }

        // Encodage
        $reviewData = [
            'user_id' => $user->getUserId(),
            'announce_id' => $announce->getAnnounceId(),
            'rate' => $rate,
            'comment' => $comment,
        ];

        // Ajout dans la BDD
        $newReview = $reviewManager->addReview($reviewData);

        if(!$newReview){
            echo json_encode(['message' => 'Error while creating review']);
            return;
        }

        echo json_encode(['message' => 'Review successfully added']);
    }

    public function getReviewByAnnounceId(): void
    {
        //Recupération des paramètres
        $announceId = intval($_GET['id']);

        // Récupération des avis liés
        $manager = new Manager\ReviewManager();
        $reviews = $manager->getAnnounceReviews($announceId);

        $data =[];

        // Encodage dans un Array
        foreach ($reviews as $review) {
            $data[] = $review->jsonSerialize();
        }

        echo json_encode($data);
    }

    public function deleteReview() : void
    {
        // Récupération des paramètres
        $reviewId = intval($_GET['id']);

        // Récupération de l'user
        $auth = new AuthController();
        $user = $auth->verifyJwt();

        if(!$user){
            echo json_encode(['error' => 'User not logged']);
            return;
        }


        $reviewManager = new Manager\ReviewManager();
        $review = $reviewManager->getReviewById($reviewId);

        if (!$review) {
            echo json_encode(['error' => 'Review not found']);
            return;
        }

        if(!$user->getIsAdmin() && !$user->getIsStaff() && $user->getUserId() !== $review->getUserId()){
            echo json_encode(['error' => 'You are not authorized to delete this review']);
            return;
        }

        $delete = $reviewManager->deleteReview($review);

        if ($delete) {
            echo json_encode(['message' => 'Review deleted successfully']);
        } else {
            echo json_encode(['error' => 'Failed to delete the review']);
        }

    }
}
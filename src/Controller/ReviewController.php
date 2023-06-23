<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model\Manager;
use Hetic\ReshomeApi\Utils\ReservationHelper;
use Hetic\ReshomeApi\Utils\ReviewHelper;

// Contrôleur pour la gestion des avis
class ReviewController extends BaseController
{
    // Méthode pour créer un avis
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

        // Vérification de la validité des données nécessaires
        if (!$reservationId) {
            echo json_encode(['message' => 'Vous devez spécifier une réservation pour ajouter un avis']);
            return;
        }

        if ($rate < 1 || $rate > 5) {
            echo json_encode(['message' => 'La note doit être entre 1 et 5']);
            return;
        }

        // Récupération de l'utilisateur connecté
        $auth = new AuthController();
        $user = $auth->verifyJwt();
        if(!$user){
            echo json_encode(['message' => 'Vous devez être connecté pour ajouter un avis']);
            return;
        }

        // Récupération de la réservation et de l'annonce associée à l'avis
        $reservation = $reservationManager->getReservationById($reservationId);
        $announce = $announceManager->getAnnounceById($reservation->getAnnounceId());

        // Vérification que l'utilisateur qui envoie la requête est bien celui qui a effectué la réservation
        if ($user->getUserId() != $reservation->getUserId()) {
            echo json_encode(['message' => "Vous devez être l'auteur de la réservation pour donner un avis"]);
            return;
        }

        // Vérification que l'utilisateur qui envoie la requête le fait bien après sa réservation
        if (!ReservationHelper::isPassed($reservation)) {
            echo json_encode(['message' => 'Vous pouvez donner un avis uniquement après votre séjour']);
            return;
        }

        // Vérification que l'utilisateur n'a pas déjà donné un avis
        if (ReservationHelper::hasBookedThisAnnounce($user, $announce) <= ReviewHelper::hasReviewedThisAnnounce($user, $announce)) {
            echo json_encode(['message' => 'Vous ne pouvez pas donner plusieurs avis.']);
            return;
        }

        // Préparation des données
        $reviewData = [
            'user_id' => $user->getUserId(),
            'announce_id' => $announce->getAnnounceId(),
            'rate' => $rate,
            'comment' => $comment,
        ];

        // Ajout dans la BDD
        $newReview = $reviewManager->addReview($reviewData);

        if(!$newReview){
            echo json_encode(['message' => 'Erreur lors de la création de l\'avis']);
            return;
        }

        echo json_encode(['message' => 'Avis ajouté avec succès']);
    }

    // Méthode pour obtenir les avis par ID d'annonce
    public function getReviewByAnnounceId(): void
    {
        // Récupération des paramètres
        $announceId = intval($_GET['id']);

        // Récupération des avis liés
        $manager = new Manager\ReviewManager();
        $reviews = $manager->getAnnounceReviews($announceId);

        $data =[];

        // Encodage dans un tableau
        foreach ($reviews as $review) {
            $data[] = $review->jsonSerialize();
        }

        echo json_encode($data);
    }

    // Méthode pour supprimer un avis
    public function deleteReview() : void
    {
        // Récupération des paramètres
        $reviewId = intval($_GET['id']);

        // Récupération de l'utilisateur
        $auth = new AuthController();
        $user = $auth->verifyJwt();

        if(!$user){
            echo json_encode(['error' => 'Utilisateur non connecté']);
            return;
        }

        $reviewManager = new Manager\ReviewManager();
        $review = $reviewManager->getReviewById($reviewId);

        if (!$review) {
            echo json_encode(['error' => 'Avis non trouvé']);
            return;
        }

        // Seul l'utilisateur qui a écrit l'avis, l'administrateur ou le staff peuvent le supprimer
        if(!$user->getIsAdmin() && !$user->getIsStaff() && $user->getUserId() !== $review->getUserId()){
            echo json_encode(['error' => 'Vous n\'êtes pas autorisé à supprimer cet avis']);
            return;
        }

        // Suppression de l'avis
        $delete = $reviewManager->deleteReview($review);

        if ($delete) {
            echo json_encode(['message' => 'Avis supprimé avec succès']);
        } else {
            echo json_encode(['error' => 'Echec de la suppression de l\'avis']);
        }
    }
}

<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model;
use Hetic\ReshomeApi\Utils\Helper;

class AnnounceController extends BaseController
{

    public function __construct()
    {
        parent::__construct();  // Appel du constructeur parent
    }

    public function createAnnounce() : void
    {
        // Crée une instance du contrôleur d'authentification
        $auth = new AuthController();

        // Vérifie si l'utilisateur est un administrateur ou un membre du personnel
        if ($auth->verifyJwt()->getIsAdmin() || $auth->verifyJwt()->getIsStaff())
        {
            // Définis les champs que nous voulons garder
            $fields = ['title', 'description', 'neighborhood', 'arrondissement', 'bedroom_number', 'capacity', 'type', 'area', 'price'];
            $data = array_map('htmlspecialchars', $_POST); // Nettoie les valeurs de $_POST
            $data = array_intersect_key($data, array_flip($fields)); // Garde seulement les valeurs qui correspondent aux champs définis

            // Crée un nouveau manager d'annonces
            $announceManager = new Model\Manager\AnnounceManager();
            $announceId = $announceManager->addAnnounce($data); // Ajoute une annonce avec les données

            // Définit le type de contenu de la réponse
            header('Content-Type: application/json');
            if ($announceId) {
                // Si l'annonce a bien été créée
                $pictureManager = new Model\Manager\PictureManager();
                if (isset($_FILES['images'])) {
                    // Si des images ont été envoyées
                    $pictures = Helper::moveImages($_FILES['images']); // Déplace les images
                    foreach ($pictures as $picture) {
                        // Pour chaque image
                        $pictureManager->addPicture($announceId, $picture); // Ajoute l'image à l'annonce
                    }
                }

                echo json_encode(['message' => 'Annonce créée avec succès']);
            } else {
                echo json_encode(['message' => 'Erreur lors de la création de l\'annonce']);
            }
        } else {
            echo json_encode(['message' => 'Erreur : l\'utilisateur n\'est pas un administrateur']);
        }
    }

    public function getAnnounces($number) : void
    {
        // Crée un nouveau manager d'annonces
        $manager = new Model\Manager\AnnounceManager();
        // Obtient les annonces pour une certaine page
        $announces = $manager->getAnnouncePage($number);
        foreach ($announces as $announce) {
            // Convertit chaque annonce en tableau associatif
            $data[] = $announce->jsonSerialize();
        }

        header('Content-Type: application/json');
        if ($data) {
            // Si les données existent, les renvoie en JSON
            echo json_encode($data);
        } else {
            echo json_encode(['message' => 'Erreur : pas de valeurs sur cette page']);
        }
    }

    public function getDetail($id) : void
    {
        $manager = new Model\Manager\AnnounceManager();

        // Obtient les détails d'une annonce par son identifiant
        $data = $manager->getAnnounceById(intval(htmlspecialchars($id)))->jsonSerialize();

        header('Content-Type: application/json');
        // Renvoie les données en JSON
        echo json_encode($data);
    }

    public function getSearch($query)
    {
        $manager = new Model\Manager\AnnounceManager();
        // Effectue une recherche d'annonces avec une requête
        $announces = $manager->getAnnounceBySearch(htmlspecialchars($query));
        $data = [];
        foreach ($announces as $announce) {
            // Convertit chaque annonce en tableau associatif
            $data[] = $announce->jsonSerialize();
        }

        header('Content-Type: application/json');
        if ($data) {
            // Si les données existent, les renvoient en JSON
            echo json_encode($data);
        } else {
            echo json_encode(['message' => 'erreur']);
        }

    }

}

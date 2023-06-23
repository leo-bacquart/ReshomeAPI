<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model\Manager\PictureManager;

// Contrôleur dédié à la gestion des images
class PictureController extends BaseController
{
    // Méthode pour obtenir les chemins des images liées à une annonce
    public function getPicturesPath(string $announceId) : void
    {
        // Configurer le type de contenu en JSON
        header('Content-Type: application/json');

        // Si aucun identifiant d'annonce n'est fourni, retourner une erreur
        if (!$announceId) {
            echo json_encode(['message' => 'Error : no announce id selected']);
            return;
        }

        // Créer un gestionnaire d'images
        $manager = new PictureManager();

        // Obtenir les images liées à l'annonce
        $pictures = $manager->getPicturesByAnnounceId($announceId);

        // Préparer un tableau pour stocker les chemins des images
        $picturePaths = [];

        // Pour chaque image, ajouter son chemin dans le tableau
        foreach ($pictures as $picture) {
            $picturePaths[] = $picture->getPicturePath();
        }

        // Si des images ont été trouvées, retourner leurs chemins
        if ($pictures) {
            echo json_encode($picturePaths);
        }
        // Sinon, retourner une erreur
        else {
            echo json_encode(['message' => 'Impossible to get pictures']);
        }
    }

}

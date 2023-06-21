<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model\Manager\PictureManager;

class PictureController extends BaseController
{
    public function getPicturesPath(string $announceId) : void
    {
        header('Content-Type: application/json');
        if (!$announceId) {
            echo json_encode(['message' => 'Error : no announce id selected']);
            return;
        }

        $manager = new PictureManager();
        $pictures = $manager->getPicturesByAnnounceId($announceId);
        $picturePaths = [];
        foreach ($pictures as $picture) {
            $picturePaths[] = $picture->getPicturePath();
        }
        if ($pictures) {
            echo json_encode($picturePaths);
        } else {
            echo json_encode(['message' => 'Impossible to get pictures']);
        }
    }

}
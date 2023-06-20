<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model;
use Hetic\ReshomeApi\Utils\Helper;

class AnnounceController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function createAnnounce() : void
    {
        $auth = new AuthController();
        if ($auth->verifyJwt()->getIsAdmin() || $auth->verifyJwt()->getIsStaff())
        {
            $fields = ['title', 'description', 'neighborhood', 'arrondissement', 'bedroom_number', 'capacity', 'type', 'area', 'price'];
            $data = array_map('htmlspecialchars', $_POST);
            $data = array_intersect_key($data, array_flip($fields));

            $announceManager = new Model\Manager\AnnounceManager();
            $announceId = $announceManager->addAnnounce($data);

            header('Content-Type: application/json');
            if ($announceId) {
                $pictureManager = new Model\Manager\PictureManager();
                if (isset($_FILES['images'])) {
                    $pictures = Helper::moveImages($_FILES['images']);
                    foreach ($pictures as $picture) {
                        $pictureManager->addPicture($announceId, $picture);
                    }
                }

                echo json_encode(['message' => 'Announce successfully created']);
            } else {
                echo json_encode(['message' => 'Error while creating Announce']);
            }
        } else {
            echo json_encode(['message' => 'Error : User is not admin']);
        }

    }

    public function getAnnounces($number) : void
    {
        $manager = new Model\Manager\AnnounceManager();
        $announces = $manager->getAnnouncePage($number);
        $title = 'Home';
        foreach ($announces as $announce) {
            $data[] = $announce->jsonSerialize();
        }

        header('Content-Type: application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(['message' => 'Error : no values in this page']);
        }
    }

    public function getDetail($id) : void
    {
        $manager = new Model\Manager\AnnounceManager();

        $data = $manager->getAnnounceById($id)->jsonSerialize();

        header('Content-Type: application/json');
        echo json_encode($data);
    }





}
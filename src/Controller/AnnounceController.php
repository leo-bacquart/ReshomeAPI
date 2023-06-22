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
        if (!$auth->verifyJwt()) {
            echo json_encode(['message' => 'You are not logged in']);
            return;
        }
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
                } else {
                    echo json_encode(['message' => 'No images found']);
                    return;
                }

                echo json_encode(['message' => 'Announce successfully created']);
            } else {
                echo json_encode(['message' => 'Error while creating Announce']);
            }
        } else {
            echo json_encode(['message' => 'Error : User is not admin']);
        }
    }

    public function getAnnounces() : void
    {
        if (!isset($_GET['page'])) {
            $number = 1;
        } else {
            $number = $_GET['page'];
        }

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

    public function getDetail() : void
    {
        $id = $_GET['id'];
        if (!$id) {
            echo json_encode(['message' => 'No id selected']);
            return;
        }

        $manager = new Model\Manager\AnnounceManager();

        $data = $manager->getAnnounceById(intval(htmlspecialchars($id)))->jsonSerialize();

        header('Content-Type: application/json');
        echo json_encode($data);
    }

    public function getSearch() : void
    {
        $query = $_GET['q'];
        if (!$query) {
            echo json_encode(['message' => 'No query sent']);
            return;
        }

        $manager = new Model\Manager\AnnounceManager();
        $announces = $manager->getAnnounceBySearch(htmlspecialchars($query));
        $data = [];
        foreach ($announces as $announce) {
            $data[] = $announce->jsonSerialize();
        }

        header('Content-Type: application/json');
        if ($data) {
            echo json_encode($data);
        } else {
            echo json_encode(['message' => 'error']);
        }

    }





}
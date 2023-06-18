<?php

namespace Hetic\ReshomeApi\Controller;

use Hetic\ReshomeApi\Model;
use Hetic\ReshomeApi\Utils\Utils;

class FrontController extends BaseController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getAnnounces($number) : void
    {
        $manager = new Model\Manager\AnnounceManager();
        $announces = $manager->getAnnouncePage($number);
        $title = 'Home';
        foreach ($announces as $announce) {
            $data[] = $announce->jsonSerialize();
        }
        echo json_encode($data);
    }

    public function getDetail($id) : void
    {
        $manager = new Model\Manager\AnnounceManager();

        $data = $manager->getAnnounceById($id)->jsonSerialize();

        header('Content-Type: application/json');
        echo json_encode($data);
    }



}
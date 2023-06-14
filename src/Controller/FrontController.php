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

    public function executeIndex() : mixed
    {
        $manager = new Model\Manager\AnnounceManager();
        $announces = $manager->getAllAnnounces();
        $title = 'Home';

        foreach ($announces as $announce) {
            $pictureArray = $manager->getAnnouncePictures($announce->getAnnounceId());
            $announce->setPictures($pictureArray);
        }

        $template = $this->templateDir . 'skeleton.php';
        $view = $this->viewDir . 'announceBox.php';

        ob_start();
        require $view;
        $content = ob_get_clean();
        return require $template;
    }

    public function executeDetail($id) : mixed
    {
        $manager = new Model\Manager\AnnounceManager();
        $announce = $manager->getAnnounceById($id);
        $reviews = $manager->getAnnounceReviews($id);
        $rateAvg = Utils::getAverageFromObject($reviews, 'rate');
        $pictureArray = $manager->getAnnouncePictures($announce->getAnnounceId());
        $announce->setPictures($pictureArray);




        $template = $this->templateDir . 'skeleton.php';
        $view = $this->viewDir . 'announceDetails.php';

        ob_start();
        require $view;
        $content = ob_get_clean();
        return require $template;
    }



}
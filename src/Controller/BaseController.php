<?php

namespace Hetic\ReshomeApi\Controller;

use http\Exception\RuntimeException;

abstract class BaseController
{
    protected array $params;
    protected string $viewDir;
    protected string $templateDir;
    protected string $imagesDir;


    public function __construct()
    {
        $this->viewDir = dirname(__DIR__, 1) . '/View/';
        $this->templateDir = $this->viewDir . '/Template/';
        $this->imagesDir = dirname(__DIR__, 2) . '/public/images/';
    }

    protected function getConnection(int $user_id, string $given_password)
    {

    }
}
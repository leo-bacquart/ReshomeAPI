<?php

namespace Hetic\ReshomeApi\Controller;

class ErrorController extends BaseController
{
    public function __construct(int $status, string $errorMsg)
    {
        parent::__construct();
        $this->error($status, $errorMsg);
    }

    public function error(int $status, string $message)
    {
        $title = 'Error';
        $template = $this->templateDir . 'skeleton.php';
        $view = $this->viewDir . 'error.php';

        ob_start();
        require $view;
        $content = ob_get_clean();
        return require $template;
    }
}
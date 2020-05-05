<?php


namespace App\Controller;

/**
 * Class UserRoutesController
 * @package App\Controller
 */
class UserRoutesController extends AbstractController
{
    public function index()
    {
        $template_name = $this->getRoute()->get("template_name");
        $params = $this->getRoute()->get("params");

        return $this->render($template_name, $params);
    }
}
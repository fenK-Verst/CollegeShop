<?php


namespace App\Controller;

use App\Http\Response;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class UserRoutesController
 *
 * @package App\Controller
 */
class UserRoutesController extends AbstractController
{
    /**
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function index()
    {
        $template_name = $this->getParam("template_name");
        $params = $this->getParam("params");

        return $this->render($template_name, $params);
    }

    public function method_404()
    {
        return $this->render("HttpErrors/error.html.twig", [
            "code" => 404,
            "name" => 'Page not found'
        ],404);
    }

    public function method_500()
    {
        return $this->render("HttpErrors/error.html.twig", [
            "code" => 500,
            "name" => 'Internal Error'
        ],500);
    }

    public function method_405()
    {
        return $this->render("HttpErrors/error.html.twig", [
            "code" => 405,
            "name" => 'Method not allowed'
        ],405);

    }


}
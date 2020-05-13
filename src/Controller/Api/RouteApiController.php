<?php


namespace App\Controller\Api;


use App\Controller\AbstractController;
use App\Http\Request;
use App\Repository\ProductRepository;
use App\Repository\TemplateRepository;
use App\Service\CartService;

/**
 * Class RouteApiController
 *
 * @Route("/api")
 * @package App\Controller\Api
 */
class RouteApiController extends AbstractController
{
    /**
     * @Route("/templates/get")
     */
    public function getTemplates(TemplateRepository $template_repository)
    {
        $templates = $template_repository->findAll();
        $data = [];
        foreach ($templates as $template){
            $data[] = [
                "name"=>$template->getName(),
                "id"=>$template->getId(),
                "vars"=>$template->getVars()
            ];
        }
        $response = [
            "error"=>false,
            "status"=>"OK",
            "error_msg"=>'',
            "data"=>$data
        ];
        return $this->json($response);

    }
}
<?php


namespace App\Controller\Api;


use App\Controller\AbstractController;
use App\Http\Request;
use App\Repository\CustomRouteRepository;
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
    public function getTemplates(Request $request,TemplateRepository $template_repository, CustomRouteRepository $route_repository)
    {


        $templates = $template_repository->findAll();
        $data = [
            "templates"=>null,
            "route"=>null
        ];
        foreach ($templates as $template){
            $data["templates"][] = [
                "name"=>$template->getName(),
                "id"=>$template->getId(),
                "vars"=>$template->getVars()
            ];
        }
        $parent_route_id = (int)$request->get("parent_id") ?? null;
        if (!is_null($parent_route_id) && $parent_route_id){
            $route = $route_repository->find($parent_route_id);
            if ($route){
                $data["route"] = [
                    "id"=>$route->getId(),
                    "name"=>$route->getName(),
                    "short_url"=>$route->getShortUrl(),
                    "real_url"=>$route->getRealUrl()
                ];
            }
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
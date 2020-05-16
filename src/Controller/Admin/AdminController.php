<?php


namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Db\ObjectManager;
use App\Http\Request;
use App\Repository\VendorRepository;
use App\Routing\CustomRouter;
use App\Service\SiteParamsService;

/**
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(Request $request,SiteParamsService $site_params_service, ObjectManager $object_manager, CustomRouter $custom_router)
    {

        $site_params = $site_params_service->getSiteParams();

        $route = $request->post("route");
        if ($route){
            $site_params->setParams(json_encode($route["params"]));
            $object_manager->save($site_params);
            $site_params = $site_params_service->getSiteParams();
        }
        $vars = $site_params->getVars();
        $params = $site_params->getParams();
        $vars = json_decode($vars, true);
        $params = json_decode($params, true);

        $params = $custom_router->normalizeParams($params, $vars);
        return $this->render("/admin/index.html.twig", [
            "vars"=>$vars,
            "params"=>$params
        ]);
    }




}
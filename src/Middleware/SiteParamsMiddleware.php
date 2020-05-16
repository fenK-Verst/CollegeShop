<?php


namespace App\Middleware;


use App\Routing\CustomRouter;
use App\Routing\Route;
use App\Service\SiteParamsService;
use App\Service\UserService;

class SiteParamsMiddleware implements MiddlewareInterface
{
    /**
     * @var SiteParamsService
     */
    private SiteParamsService $service;
    /**
     * @var CustomRouter
     */
    private CustomRouter $custom_router;

    public function __construct(SiteParamsService $service, CustomRouter $custom_router)
    {
        $this->service = $service;
        $this->custom_router = $custom_router;
    }

    public function run(Route $route)
    {
        $controller = $route->getController();
        $site_params = $this->service->getSiteParams();
        $vars = $site_params->getVars();
        $params = $site_params->getParams();
        $vars = json_decode($vars, true);
        $params = json_decode($params, true);
        $params = $this->custom_router->normalizeParams($params, $vars);
        $controller->addSharedData("site", $params);
    }
}
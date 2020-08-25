<?php


namespace App\Middleware;


use App\Db\Interfaces\ObjectManagerInterface;
use App\Db\ObjectManager;
use App\Entity\SiteParams;
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
    /**
     * @var ObjectManagerInterface
     */
    private ObjectManagerInterface $objectManager;

    public function __construct(
        SiteParamsService $service,
        CustomRouter $custom_router,
        ObjectManagerInterface $objectManager
    ) {
        $this->service = $service;
        $this->custom_router = $custom_router;
        $this->objectManager = $objectManager;
    }

    public function run(Route $route)
    {
        $controller = $route->getController();
        $site_params = $this->service->getSiteParams();
        if (!$site_params) {
            $site_params = new SiteParams();
            $site_params->setParams('{}');
            $site_params->setVars('{}');
            $site_params = $this->objectManager->save($site_params);
        }
        $vars = $site_params->getVars();
        $params = $site_params->getParams();
        $vars = json_decode($vars, true);
        $params = json_decode($params, true);
        $params = $this->custom_router->normalizeParams($params, $vars);

        $controller->addSharedData("site", $params);
    }
}
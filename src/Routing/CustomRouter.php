<?php

namespace App\Routing;

use App\Controller\UserRoutesController;
use App\Di\Container;
use App\Entity\CustomRoute;
use App\Repository\CustomRouteRepository;
use App\Repository\ImageRepository;
use App\Repository\MenuRepository;
use Exception;

/**
 * Class CustomRouter
 * @package App\Routing
 */
class CustomRouter
{
    /**
     * @var Container
     */
    private Container $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    public function getRouteData(string $url): ?array
    {
        $route_data = null;
        $route_repository = $this->container->get(CustomRouteRepository::class);
        $routes = $route_repository->findBy([
            "real_url" => $url
        ], [], [1]);
        if (!empty($routes)) {
            /**
             * @var CustomRoute $route
             */
            $route = $routes[0];
            $route_params = json_decode($route->getParams(), true);
            $template = $route->getTemplate();
            $vars = json_decode($template->getParams(), true);
            $params = $this->normalizeParams($route_params, $vars);

            $route_data = [
                UserRoutesController::class,
                "index",
                [
                    "template_name" => $route->getTemplate()->getPath(),
                    "params" => $params
                ]
            ];
        }

        return $route_data;
    }

    public function normalizeParams(array &$route_params, array $vars)
    {
        $params = [];
        foreach ($route_params as $key => &$route_param) {
            $var = $vars[$key];
            $type = $var["type"];
//            if (!$var["type"]) {
//                throw new Exception('Ошибка типизации. Обратитесь к разработчику');
//            }
            switch ($type) {
                case "html":
                case "text":
                    $params[$key] = $route_param;
                    break;
                case "image":
                    $is_multiply = $var["multiply"] ?? false;
                    $image_repository = $this->container->get(ImageRepository::class);
                    if (!$is_multiply) {
                        $image = $image_repository->find($route_param);
                        if (!$image) {
                            $route_params[$key] = null;
                        }
                        $params[$key] = $image;
                    } else {
                        $images = $image_repository->findBy([
                            "id" => $route_param
                        ]);
                        $params[$key] = $images;
                    }
                    break;
                case "menu":
                    $menu_repository = $this->container->get(MenuRepository::class);
                    $menu = $menu_repository->find($route_param);
                    if (!$menu) {
                        $route_param = null;
                    }
                    $params[$key] = $menu;
                    break;
            }
        }
        return $params;
    }

}
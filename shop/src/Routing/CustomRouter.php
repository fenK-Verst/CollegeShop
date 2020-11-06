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
 *
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

    public function getRoutesByUrl(string $url): array
    {
        $route_data = [];
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
            $params = [
                    "template_name" => $route->getTemplate()->getPath(),
                    "params" => $params
                ];
            $route_data[] = new Route($url, $params, UserRoutesController::class, 'index' );
        }

        return $route_data;
    }

    /**
     * @param array $route_params
     * @param array $vars
     *
     * @return array
     */
    public function normalizeParams(array &$route_params, array $vars): array
    {
        $params = [];
        foreach ($route_params as $key => &$route_param) {
            $var = $vars[$key];
            $type = $var["type"];
            switch ($type) {
                case "html":
                case "text":
                    $params[$key] = $route_param;
                    break;
                case "image":
                    $params[$key] = $this->normalizeImage($route_params, $vars, $key);
                    break;
                case "menu":
                    $params[$key] = $this->normalizeMenu($route_params, $vars, $key);
                    break;
                default:
                    $params[$key] = null;
            }
        }
        return $params;
    }

    private function normalizeImage(&$route_params, $vars, $key)
    {
        $var = $vars[$key];
        $route_param = $route_params[$key];

        $is_multiply = $var["multiply"] ?? false;
        $image_repository = $this->container->get(ImageRepository::class);

        if (!$is_multiply) {
            $image = $image_repository->find($route_param);
            if (!$image) {
                $route_params[$key] = null;
            }
            return $image;
        } else {
            $images = $image_repository->findBy([
                "id" => $route_param
            ]);
            return $images;
        }
    }

    private function normalizeMenu(&$route_params, $vars, $key)
    {
        $route_param = $route_params[$key];
        $menu_repository = $this->container->get(MenuRepository::class);
        $menu = $menu_repository->find($route_param);
        if (!$menu) {
            $route_params[$key] = null;
        }
        return $menu;
    }

}
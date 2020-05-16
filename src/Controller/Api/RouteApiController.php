<?php


namespace App\Controller\Api;


use App\Controller\AbstractController;
use App\Db\ArrayDataManager;
use App\Db\ObjectManager;
use App\Entity\CustomRoute;
use App\Http\Request;
use App\Repository\CustomRouteRepository;
use App\Repository\MenuRepository;
use App\Repository\TemplateRepository;
use App\Routing\CustomRouter;
use App\Twig;
use Exception;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Class RouteApiController
 *
 * @Route("/api")
 * @package App\Controller\Api
 */
class RouteApiController extends AbstractController
{
    /**
     * @Route("/template/get")
     */
    public function getTemplates(TemplateRepository $template_repository)
    {
        $templates = $template_repository->findAll();
        $data = [
            "templates" => null,
            "route" => null
        ];
        foreach ($templates as $template) {
            $data["templates"][] = [
                "name" => $template->getName(),
                "id" => $template->getId(),
            ];
        }
        $response = [
            "error" => false,
            "status" => "OK",
            "error_msg" => '',
            "data" => $data
        ];
        return $this->json($response);

    }

    /**
     * @Route("/template/{id}/get/form")
     */
    public function getTemplateForm(
        Request $request,
        CustomRouteRepository $route_repository,
        TemplateRepository $template_repository,
        CustomRouter $custom_router,
        Twig $twig
    ) {
        $template_id = (int)$this->getRoute()->get("id") ?? null;
        $template = $template_repository->find($template_id);
        if (!$template) {
            return $this->json([
                "error" => true,
                "status" => "KO",
                "error_msg" => 'Шаблон не найден',
            ]);
        }

        $parent_route_id = $request->get("parent_id") ?? null;
        $parent_route = $route_repository->find($parent_route_id);

        $route_id = $request->get("route_id");
        $route = $route_repository->find($route_id);

        if ($route && !$parent_route) {
            $parent_route = $route_repository->getParent($route);
        }
        $vars = json_decode($template->getParams(), true);
        $params = [];
        if ($route) {
            $route_params = json_decode($route->getParams(), true);
            try {
                $params = $custom_router->normalizeParams($route_params, $vars);
            } catch (Exception $e) {
                return $this->error($e->getMessage());
            }
//             foreach ($route_params as $key => &$route_param) {
//                if (is_null($route_param) || empty($route_param)) {
//                    continue;
//                }
//                $var = $vars[$key];
//                if (!$var["type"]) {
//                    return $this->error('Ошибка типизации. Обратитесь к разработчику');
//                }
//                switch ($var["type"]) {
//                    case "html":
//                    case "text":
//                        $params[$key] = $route_param;
//                        break;
//                    case "image":
//                        $is_multiply = $var["multiply"] ?? false;
//                        if (!$is_multiply) {
//                            $image = $image_repository->find($route_param);
//                            if (!$image) {
//                                $route_param = null;
//                            }
//                            $params[$key] = $image;
//                        } else {
//                            $images = $image_repository->findBy([
//                                "id"=>$route_param]);
//                            $params[$key] = $images;
//                        }
//                        break;
//                    case "menu":
//                        $menu = $menu_repository->find($route_param);
//                        if (!$menu) {
//                            $route_param = null;
//                        }
//                        $params[$key] = $menu;
//                        break;
//
//                }
//            }
        }
        try {
            $rendered_form = $twig->render('custom_templates/base.form.html.twig', [
                "parent_route" => $parent_route,
                "route" => $route,
                "host" => $_SERVER["HTTP_HOST"],
                "vars" => $vars,
                "params" => $params,
                "template"=>$template
            ]);
        } catch (LoaderError $e) {
            return $this->error('Не удалось загрузить шаблон');
        } catch (RuntimeError $e) {
            return $this->error('Превышено время ожидания');
        } catch (SyntaxError $e) {
            return $this->error('Синаксическая ошибка. Обратитесь к разработчику');
        }

        return $this->json([
            "error" => false,
            "status" => "OK",
            "error_msg" => '',
            "data" => [
                "form" => $rendered_form
            ]
        ]);
    }

    /**
     * @Route("/route/{id}/edit")
     */
    public function editRoute(
        Request $request,
        TemplateRepository $template_repository,
        ObjectManager $object_manager,
        CustomRouteRepository $route_repository
    ) {
        $route_id = $this->getRoute()->get("id");
        $route = $route_repository->find($route_id);
        $request_route = $request->get("route") ?? null;
        if (!($request_route && $request_route["short_url"] && $request_route["name"] && $request_route["params"])) {
            return $this->error("Не указаны все данные");
        }
        $template_id = $request_route["template_id"] ?? null;
        $template = $template_repository->find($template_id);
        if (!$template) {
            return $this->error("Не указан шаблон");
        }
        $parent_route_id = $request_route["parent_id"] ?? null;
        $parent_route = $route_repository->find($parent_route_id);
        $old_real_url = $route->getRealUrl();

        if ($parent_route) {
            $real_url = $parent_route->getRealUrl();
            $short_url = $request_route["short_url"];
            $url = $real_url . "/" . $short_url;
            $url = preg_replace("/\s+/", "", $url);
            $route->setShortUrl($short_url);
            $route->setRealUrl($url);
        } else {
            $short_url = $request_route["short_url"];
            $short_url = preg_replace("/\s+/", "", $short_url);
            $route->setShortUrl($short_url);
            $route->setRealUrl("/" . $short_url);
        }

        $route_childs = $route_repository->getChilds($route);
        foreach ($route_childs as $key => $route_child) {
            /**
             * @var CustomRoute $route_child
             */
            $real_url = $route_child->getRealUrl();
            $real_url = substr($real_url, strlen($old_real_url));
            $real_url = $route->getRealUrl() . $real_url;
            $route_child->setRealUrl($real_url);
            $object_manager->save($route_child);
        }

        $route->setName($request_route["name"]);
        $route->setParams(json_encode($request_route["params"]));
        $object_manager->save($route);
        return $this->json([
            "error" => false,
            "status" => "OK",
            "error_msg" => '',
        ]);
    }

    /**
     * @Route("/route/create")
     */
    public function createRoute(
        Request $request,
        TemplateRepository $template_repository,
        ObjectManager $object_manager,
        CustomRouteRepository $route_repository,
        MenuRepository $menu_repository,
        ArrayDataManager $adm
    ) {
        $route = $request->get("route") ?? null;
        if (!($route && $route["short_url"] && $route["name"] && $route["params"])) {
            return $this->error("Не указаны все данные");
        }

        $template_id = $route["template_id"] ?? null;
        $template = $template_repository->find($template_id);
        if (!$template) {
            return $this->error("Не указан шаблон");
        }
        $menu_id = $route["menu_id"] ?? null;
        $menu = $menu_repository->find($menu_id);
        if (!$menu) {
            return $this->error("Не указано меню");
        }
        $parent_route_id = $route["parent_id"] ?? null;
        $parent_route = $route_repository->find($parent_route_id);


        $custom_route = new CustomRoute();

        $custom_route->setName($route["name"]);
        $custom_route->setIsHidden(false);
        $custom_route->setTemplate($template);
        $custom_route->setMenu($menu);

        if ($parent_route) {
            $real_url = $parent_route->getRealUrl();
            $short_url = $route["short_url"];

            $url = $real_url."/".$short_url;
            $url = preg_replace("/\s+/", "", $url);
            $custom_route->setShortUrl($short_url);
            $custom_route->setRealUrl($url);

            $finded_route = $route_repository->findBy([
                "real_url"=>$url
            ]);
            if (!empty($finded_route)){
                return $this->error("Страница с таким адресом уже существует");
            }
            $left = (int)$parent_route->getLeft() + 1;
            $right = $left + 1;
            $lvl = (int)$parent_route->getLvl() + 1;

            $custom_route->setLeft($left);
            $custom_route->setRight($right);
            $custom_route->setLvl($lvl);

            $query = "UPDATE route SET _right = _right + 2 WHERE _right >= $left;";
            $adm->query($query);
            $query = "UPDATE route SET _left = _left + 2 WHERE _left >= $left;";
            $adm->query($query);


        } else {
            $short_url = $route["short_url"];
            $short_url = preg_replace("/\s+/", "", $short_url);
            $custom_route->setShortUrl($short_url);
            $custom_route->setRealUrl("/".$short_url);

            $finded_route = $route_repository->findBy([
                "real_url"=>"/".$short_url
            ]);
            if (!empty($finded_route)){
                return $this->error("Страница с таким адресом уже существует");
            }

            $last_right = $route_repository->findBy([], [
                "_right" => "DESC"
            ], [1]);
            $last_right = $last_right[0] ?? null;
            if (!is_null($last_right)) {
                $left = $last_right->getRight() + 1;
            } else {
                $left = 0;
            }
            $right = $left + 1;

            $custom_route->setLeft($left);
            $custom_route->setRight($right);
            $custom_route->setLvl(1);


        }
        $custom_route->setParams(json_encode($route["params"]));
        $object_manager->save($custom_route);
        return $this->json([
            "error" => false,
            "status" => "OK",
            "error_msg" => '',
        ]);
    }

    private function error(string $error_msg)
    {
        return $this->json([
            "error" => true,
            "status" => "KO",
            "error_msg" => $error_msg
        ]);
    }
}
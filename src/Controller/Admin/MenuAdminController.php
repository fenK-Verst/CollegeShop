<?php


namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Db\ArrayDataManager;
use App\Db\ObjectManager;
use App\Entity\Menu;
use App\Entity\Vendor;
use App\Http\Request;
use App\Repository\CustomRouteRepository;
use App\Repository\FolderRepository;
use App\Repository\MenuRepository;

/**
 * Class MenuController
 *
 * @Route("/admin")
 * @package App\Controller
 */
class MenuAdminController extends AbstractController
{
    /**
     * @Route("/routes")
     */
    public function index(MenuRepository $menu_repository)
    {
        $menus = $menu_repository->findAll();
        return $this->render("admin/menu/index.html.twig", [
            "menus" => $menus
        ]);
    }

    /**
     * @Route("/menu/create")
     */
    public function create(Request $request, ObjectManager $object_manager)
    {
        $menu = $request->post("menu");
        $error = '';
        if ($menu) {
            $name = $menu["name"];
            if (!$name) {
                $error .= "Не указано имя";
            }

            if (!$error) {
                $menu = new Menu();
                $menu->setName($name);
                $object_manager->save($menu);
                return $this->redirect("/admin/routes");
            }
        }


        return $this->render("/admin/menu/form.html.twig", [
            "menu" => $menu,
            "error" => $error
        ]);
    }
    /**
     * @Route("/route/delete")
     */
    public function delete(
        Request $request,
        ObjectManager $object_manager,
        CustomRouteRepository $route_repository,
        MenuRepository $menu_repository,
        ArrayDataManager $adm
    ) {
        $route_id = $request->post("route_id");
        $route = $route_repository->find($route_id);
        $error = false;

        if ($route) {
            if ($route->getRight() - $route->getLeft() > 1) {
                $error = "У страницы есть подстраницы";
            }
        }else{
            $error = "Не найдена страницы";
        }
        if (!$error) {
            $left = $route->getLeft();

            $object_manager->remove($route);
            $query = "UPDATE route SET _right = _right - 2 WHERE _right >= $left;";
            $adm->query($query);
            $query = "UPDATE route SET _left = _left - 2 WHERE _left >= $left;";
            $adm->query($query);

            return $this->redirect("/admin/routes");
        }

        $menus = $menu_repository->findAll();
        return $this->render("admin/menu/index.html.twig", [
            "menus" => $menus,
            "error" => $error
        ]);
    }
}
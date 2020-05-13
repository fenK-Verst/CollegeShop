<?php


namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Db\ObjectManager;
use App\Entity\Menu;
use App\Entity\Vendor;
use App\Http\Request;
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
}
<?php


namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Db\ObjectManager;
use App\Entity\ProductParam;
use App\Http\Request;
use App\Repository\ProductParamRepository;

/**
 * Class ProductParamAdminController
 *
 * @Route("/admin/param")
 * @package App\Controller
 */
class ProductParamAdminController extends AbstractController
{
    /**
     * @Route("/{id}")
     */
    public function param(ProductParamRepository $param_repository)
    {
        $id = $this->getRoute()->get("id");
        $param = $param_repository->find($id);
        return $this->render("/admin/product_param/list.html.twig", [
            "param" => $param
        ]);
    }

    /**
     * @Route("/create")
     */
    public function create(Request $request, ObjectManager $object_manager)
    {
        $param = $request->post("param");
        $error = '';
        if ($param) {
            $name = $param["name"];
            if (!$name) {
                $error .= "Не указано имя";
            }

            if (!$error) {
                $param = new ProductParam();
                $param->setName($name);
                $object_manager->save($param);
                return $this->redirect("/admin/param/");
            }
        }


        return $this->render("/admin/product_param/form.html.twig", [
            "param" => $param,
            "error" => $error
        ]);
    }

    /**
     * @Route("/delete")
     */
    public function delete(Request $request, ProductParamRepository $param_repository, ObjectManager $object_manager)
    {
        $param_id = $request->post("param_id");
        $param = $param_repository->find($param_id);
        if ($param) {
            $object_manager->remove($param);
        }

        return $this->redirect("/admin/param");
    }

    /**
     * @Route("/{id}/edit")
     */
    public function edit(Request $request, ProductParamRepository $param_repository, ObjectManager $object_manager)
    {
        $param_id = $this->getRoute()->get("id");
        $param = $param_repository->find($param_id);
        $error = '';
        $param_post = $request->post("param");
        if ($param_post) {
            $name = $param_post["name"];
            if (!$name) {
                $error .= "Не указано имя";
            }
            if (!$error) {
                $param->setName($name);
                $object_manager->save($param);
                return $this->redirect("/admin/param/");
            }
        }
        return $this->render("/admin/product_param/form.html.twig", [
            "param" => $param,
            "error" => $error
        ]);
    }

    /**
     * @Route("/")
     */
    public function list(ProductParamRepository $param_repository)
    {
        $params = $param_repository->findAll();
        return $this->render("/admin/product_param/list.html.twig", [
            "params" => $params
        ]);
    }
}
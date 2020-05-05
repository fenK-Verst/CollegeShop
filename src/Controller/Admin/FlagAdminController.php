<?php


namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Db\ObjectManager;
use App\Entity\Flag;
use App\Http\Request;
use App\Repository\FlagRepository;

/**
 * Class FlagAdminController
 *
 * @Route("/admin/flag")
 * @package App\Controller
 */
class FlagAdminController extends AbstractController
{
    /**
     * @Route("/create")
     */
    public function create(Request $request, ObjectManager $object_manager)
    {
        $flag = $request->post("flag");
        $error = '';
        if ($flag) {
            $name = $flag["name"];
            if (!$name) {
                $error .= "Не указано имя";
            }

            if (!$error) {
                $flag = new Flag();
                $flag->setName($name);
                $object_manager->save($flag);
                return $this->redirect("/admin/flag/");
            }
        }


        return $this->render("/admin/flag/form.html.twig", [
            "flag" => $flag,
            "error" => $error
        ]);
    }

    /**
     * @Route("/delete")
     */
    public function delete(Request $request, FlagRepository $flag_repository, ObjectManager $object_manager)
    {
        $flag_id = $request->post("flag_id");
        $flag = $flag_repository->find($flag_id);
        if ($flag) {
            $object_manager->remove($flag);
        }

        return $this->redirect("/admin/flag");
    }

    /**
     * @Route("/{id}/edit")
     */
    public function edit(Request $request, FlagRepository $flag_repository, ObjectManager $object_manager)
    {
        $flag_id = $this->getRoute()->get("id");
        $flag = $flag_repository->find($flag_id);
        $error = '';
        $flag_post = $request->post("flag");
        if ($flag_post) {
            $name = $flag_post["name"];
            if (!$name) {
                $error .= "Не указано имя";
            }
            if (!$error) {
                $flag->setName($name);
                $object_manager->save($flag);
                return $this->redirect("/admin/flag/");
            }
        }
        return $this->render("/admin/flag/form.html.twig", [
            "flag" => $flag,
            "error" => $error
        ]);
    }

    /**
     * @Route("/")
     */
    public function list(FlagRepository $flag_repository)
    {
        $flags = $flag_repository->findAll();
        return $this->render("/admin/flag/list.html.twig", [
            "flags" => $flags
        ]);
    }
}
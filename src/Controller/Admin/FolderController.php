<?php


namespace App\Controller\Admin;


use App\Controller\AbstractController;
use App\Db\ArrayDataManager;
use App\Db\Exceptions\MysqliException;
use App\Db\ObjectManager;
use App\Entity\Folder;
use App\Http\Request;
use App\Repository\FolderRepository;

/**
 * Class FolderController
 *
 * @Route("/admin/folder")
 * @package App\Controller
 */
class FolderController extends AbstractController
{
    /**
     * @Route("/", name="folder.list")
     */
    public function index(FolderRepository $folder_repository)
    {
        $folders = $folder_repository->findBy([], [
            "_left" => "ASC"
        ]);
        return $this->render("/admin/folder/list.html.twig", [
            "folders" => $folders
        ]);
    }

    /**
     * @Route("/create", name="folder.create")
     */
    public function create(Request $request, FolderRepository $folder_repository, ObjectManager $object_manager)
    {
        $folder = $request->post("folder");

        $name = $folder["name"] ?? null;
        if ($folder && $name) {

            $folder = new Folder();
            $folder->setName($name);

            $last_right = $folder_repository->findBy([], [
                "_right" => "DESC"
            ], [1]);
            $last_right = $last_right[0] ?? null;
            if (!is_null($last_right)) {
                $left = $last_right->getRight() + 1;
            } else {
                $left = 0;
            }
            $right = $left + 1;

            $folder->setLeft($left);
            $folder->setRight($right);
            $folder->setLvl(1);
            $object_manager->save($folder);
        }

        return $this->render("admin/folder/form.html.twig", [
            "folder" => $folder,
        ]);
    }

    /**
     * @Route("/{id}/edit")
     */
    public function edit(Request $request, ObjectManager $object_manager, FolderRepository $folder_repository)
    {
        $id = $this->getRoute()->get("id");
        $folder = $folder_repository->find($id);
        $error = '';
        $folder_request = $request->post("folder");
        if ($folder_request){
            $name = $folder_request["name"];

            if (!$name) {
                $error.="Не указано имя категории";
            }else{
                $folder->setName($name);
                $object_manager->save($folder);
                return $this->redirect("/admin/folder");
            }

        }
        return $this->render("admin/folder/form.html.twig", [
            "folder" => $folder,
            "error"=>$error
        ]);

    }

    /**
     * @Route("/{id}/add", name="folder.addNode")
     * @throws MysqliException
     */
    public function add(
        Request $request,
        FolderRepository $folder_repository,
        ObjectManager $object_manager,
        ArrayDataManager $adm
    ) {
        $parent_id = $this->getRoute()->get("id");
        $parent = $folder_repository->find($parent_id);
        $folder = $request->post("folder");
        $name = $folder["name"] ?? null;
        if (!($parent && $name)) {
            return $this->redirect("/admin/folders");
        }

        $folder = new Folder();
        $folder->setName($name);

        $left = (int)$parent->getLeft() + 1;
        $right = $left + 1;
        $lvl = (int)$parent->getLvl() + 1;

        $folder->setLeft($left);
        $folder->setRight($right);
        $folder->setLvl($lvl);

        $query = "UPDATE folder SET _right = _right + 2 WHERE _right >= $left;";
        $adm->query($query);
        $query = "UPDATE folder SET _left = _left + 2 WHERE _left >= $left;";
        $adm->query($query);

        $object_manager->save($folder);


        return $this->redirect("/admin/folder");
    }

    /**
     * @Route("/delete")
     */
    public function delete(
        Request $request,
        ObjectManager $object_manager,
        FolderRepository $folder_repository,
        ArrayDataManager $adm
    ) {
        $folder_id = $request->post("folder_id");
        $folder = $folder_repository->find($folder_id);
        $error = false;

        if ($folder) {
            if ($folder->getRight() - $folder->getLeft() > 1) {
                $error = "У категории есть подкатегории";
            }
            if (count($folder->getProducts()) > 0) {
                $error .= "У категории есть товары";
            }
        }else{
            $error = "Не найдена категория";
        }
        if (!$error) {
            $left = $folder->getLeft();

            $object_manager->remove($folder);
            $query = "UPDATE folder SET _right = _right - 2 WHERE _right >= $left;";
            $adm->query($query);
            $query = "UPDATE folder SET _left = _left - 2 WHERE _left >= $left;";
            $adm->query($query);

            return $this->redirect("/admin/folder/");
        }

        $folders = $folder_repository->findBy([], [
            "_left" => "ASC"
        ]);
        return $this->render("/admin/folder/list.html.twig", [
            "folders" => $folders,
            "error" => $error
        ]);
    }
}
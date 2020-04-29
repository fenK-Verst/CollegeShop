<?php


namespace App\Controller\Admin;

use App\Config;
use App\Controller\AbstractController;
use App\Db\ObjectManager;
use App\Entity\Image;
use App\Http\Request;
use App\Repository\ImageRepository;

/**
 * Class ImageAdminController
 *
 * @Route("/admin/image")
 * @package App\Controller\Admin
 */
class ImageAdminController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(ImageRepository $image_repository, Request $request)
    {
        $images = $image_repository->findAll();
        return $this->render("admin/image/list.html.twig", [
            "images" => $images
        ]);
    }

    /**
     * @Route("/create")
     */
    public function create(Request $request, ObjectManager $object_manager, Config $config)
    {

        $error = '';
        $save_dir = $config->get("config")["images_directory"];
        if (!$save_dir || !is_dir($_SERVER["DOCUMENT_ROOT"] . $save_dir)) {
            $error .= "Не найдена директория для сохранения. Обратитесь к разработчику";
        }
        $request_image = $request->post("image");
        $file = $_FILES["image"];

        if ($file && $request_image) {
            $uploadfile = $save_dir . basename($file['name']["path"]);
            $is_file_exsits = file_exists($_SERVER["DOCUMENT_ROOT"] . $uploadfile);
            if ($is_file_exsits) {
                $error .= "Файл уже существует";
            } elseif (move_uploaded_file($file['tmp_name']["path"], $_SERVER["DOCUMENT_ROOT"] . $uploadfile)) {
                $image = new Image();
                $image->setAlias($request_image["alias"]);
                $image->setPath($uploadfile);
                $object_manager->save($image);
                return $this->redirect("/admin/image");
            } else {
                $error .= "Что то пошло не так\n";
            }
        }

        return $this->render("admin/image/form.html.twig", [
            "image" => $request_image,
            "error" => $error
        ]);
    }
}
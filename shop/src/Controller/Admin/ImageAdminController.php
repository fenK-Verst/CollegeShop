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
        $images = $image_repository->findBy([
            "type"=>image::$PRODUCT_TYPE
        ]);
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
        if (!$save_dir) {
            $error .= "Не найдена директория для сохранения. Обратитесь к разработчику";
        }elseif (!is_dir($_SERVER["DOCUMENT_ROOT"] . $save_dir)){
            $is_dir_make = mkdir($_SERVER["DOCUMENT_ROOT"] . $save_dir, 755, true);
            if (!$is_dir_make){
                $error .= "Не найдена директория для сохранения. Обратитесь к разработчику";
            }
        }
        $request_image = $request->post("image");
        $file = $_FILES["image"] ?? null;
        if ($file && $request_image && !$error) {
            $uploadfile = $save_dir . basename($file['name']["path"]);
            $is_file_exsits = file_exists($_SERVER["DOCUMENT_ROOT"] . $uploadfile);

            $types = [
                "image/gif",
                "image/png",
                "image/svg",
                "image/jpg",
                "image/jpeg",
                "image/svg"
            ];

            if (!in_array($file['type']["path"],$types)) {
                $error .= "Файл должен быть изображением\n";
            } elseif ($is_file_exsits) {
                $error .= "Файл уже существует";
            } elseif (move_uploaded_file($file['tmp_name']["path"], $_SERVER["DOCUMENT_ROOT"] . $uploadfile)) {
                $image = new Image();
                $image->setAlias($request_image["alias"]);
                $image->setPath($uploadfile);
                $image->setType(image::$PRODUCT_TYPE);
                $object_manager->save($image);
                return $this->redirect("/admin/image");
            } elseif (!is_writable($_SERVER["DOCUMENT_ROOT"] . $uploadfile)) {
                $error .= "Не могу записать файл\n".$_SERVER["DOCUMENT_ROOT"] . $uploadfile;
            } else {
                $error .= "Что то пошло не так\n";
            }
        }

        return $this->render("admin/image/form.html.twig", [
            "image" => $request_image,
            "error" => $error
        ]);
    }
    /**
     * @Route("/{id}")
     */
    public function item(ImageRepository $image_repository)
    {
        $image_id = $this->getParam("id");
        $image = $image_repository->find($image_id);

        return $this->render("/admin/image/item.html.twig",[
            "image"=>$image
        ]);
    }
    /**
     * @Route("/delete")
     */
    public function delete(ObjectManager $object_manager, Request $request, ImageRepository $image_repository)
    {
        $image_id = $request->post("image_id");
        $image = $image_repository->find($image_id);
        if ($image){
            $path = $image->getPath();
            if ($object_manager->remove($image)){
                unlink($_SERVER["DOCUMENT_ROOT"].$path);
            }
        }
        return $this->redirect("/admin/image");
    }
}
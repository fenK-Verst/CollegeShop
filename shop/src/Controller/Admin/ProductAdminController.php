<?php


namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Db\ObjectManager;
use App\Entity\Product;
use App\Entity\ProductParam;
use App\Entity\ProductParamValue;
use App\Http\Request;
use App\Repository\FlagRepository;
use App\Repository\FolderRepository;
use App\Repository\ImageRepository;
use App\Repository\ProductParamRepository;
use App\Repository\ProductRepository;
use App\Repository\VendorRepository;

/**
 * Class ProductAdminController
 *
 * @Route("/admin/product")
 * @package App\Controller\Admin
 */
class ProductAdminController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function list(ProductRepository $product_repository)
    {
        $products = $product_repository->findAll();

        return $this->render("/admin/product/list.html.twig", [
            "products" => $products
        ]);
    }

    /**
     * @Route("/create")
     */
    public function create(
        Request $request,
        VendorRepository $vendor_repository,
        FolderRepository $folder_repository,
        ImageRepository $image_repository,
        ProductParamRepository $param_repository,
        FlagRepository $flag_repository,
        ObjectManager $object_manager
    ) {
        $error = '';
        $request_product = $request->post("product");
        if ($request_product) {
            $name = $request_product["name"];
            $description = $request_product["description"] ?? '';
            $price = (float)$request_product["price"];
            $article = $request_product["article"] ?? '';
            $count = (int)$request_product["count"] ?? 0;
            $folder_ids = $request_product["folder_id"];
            $flag_ids = $request_product["flag_id"];

            $vendor_id = (int)$request_product["vendor_id"];
            $vendor = $vendor_repository->find($vendor_id);

            $image_id = (int)$request_product["image_id"] ?? null;
            $image = $image_repository->find($image_id);

            $request_params = (array)$request_product["param"] ?? [];

            $needed_folders = [];
            foreach ($folder_ids as $id) {
                $needed_folders[$id] = $folder_repository->find($id);
            }
            $needed_folders = array_filter($needed_folders);

            $needed_flags = [];
            foreach ($flag_ids as $id) {
                $needed_flags[$id] = $flag_repository->find($id);
            }
            $needed_flags = array_filter($needed_flags);

            if (!$name) {
                $error .= "Не указано название товара";
            }
            if (!$price) {
                $error .= "Не указана цена товара";
            }
            if (!$article) {
                $error .= "Не указан артикул товара";
            }
            if (empty($needed_folders)) {
                $error .= "Не указаны категории товара";
            }
            if (!$vendor) {
                $error .= "Не указан производитель товара";
            }

            if (!$error){
                $product = new Product();
                $product->setName($name);
                $product->setPrice($price);
                $product->setArticle($article);
                $product->setCount($count);
                foreach ($needed_folders as $needed_folder){
                    $product->addFolder($needed_folder);
                }
                foreach ($needed_flags as $needed_flag){
                    $product->addFlag($needed_flag);
                }
                $product->setVendor($vendor);
                $product->setDescription($description);
                
                $product->setImage($image);
                $product = $object_manager->save($product);
                foreach ($request_params as $param) {
                    $new_value = new ProductParamValue();
                    $param_id = $param["id"];
                    $param_type = $param_repository->find($param_id);
                    $param_value = $param["value"];
                    if ($param_type && $param_value){
                        $new_value->setProductParam($param_type);
                        $new_value->setValue($param_value);
                        $new_value->setProduct($product);
                        $new_value = $object_manager->save($new_value);
                    }
                }

                return $this->redirect("/admin/product");
            }
        }


        $folders = $folder_repository->findAll();
        $vendors = $vendor_repository->findAll();
        $params = $param_repository->findAll();
        $flags = $flag_repository->findAll();
        return $this->render("/admin/product/form.html.twig", [
            "product" => $request_product,
            "folders" => $folders,
            "vendors" => $vendors,
            "flags" => $flags,
            "params"=>$params,
            "error" => $error
        ]);
    }

    /**
     * @Route("/{id}/edit")
     */
    public function edit(
        Request $request,
        ProductRepository $product_repository,
        VendorRepository $vendor_repository,
        FolderRepository $folder_repository,
        ImageRepository $image_repository,
        ProductParamRepository $param_repository,
        FlagRepository $flag_repository,
        ObjectManager $object_manager
    ) {
        $error = '';
        $product_id = $this->getParam("id");
        $product = $product_repository->find($product_id);
        $request_product = $request->post("product");
        if ($request_product){
            $name = $request_product["name"];
            $description = $request_product["description"] ?? '';
            $price = (float)$request_product["price"];
            $article = $request_product["article"] ?? '';
            $count = (int)$request_product["count"] ?? 0;
            $folder_ids = $request_product["folder_id"] ?? [];
            $flag_ids = $request_product["flag_id"] ?? [];
            $vendor_id = $request_product["vendor_id"];
            $vendor = $vendor_repository->find($vendor_id);
            $image_id = (int)$request_product["image_id"] ?? null;
            $image = $image_repository->find($image_id);
            $request_params = (array)$request_product["param"] ?? [];
            $needed_folders = [];
            foreach ( $folder_ids as $id){
                $needed_folders[$id] = $folder_repository->find($id);
            }
            $needed_folders = array_filter($needed_folders);

            $needed_flags = [];
            foreach ( $flag_ids as $id){
                $needed_flags[$id] = $flag_repository->find($id);
            }
            $needed_flags = array_filter($needed_flags);
            if (!$name) $error.="Не указано название товара";
            if (!$price) $error.="Не указана цена товара";
            if (!$article) $error.="Не указан артикул товара";
            if (empty($needed_folders)) $error.="Не указаны категории товара";
            if (!$vendor) $error.="Не указан производитель товара";

            if (!$error){
                $product->setName($name);
                $product->setPrice($price);
                $product->setArticle($article);
                $product->setCount($count);
                $product->setImage($image);
                $product_folders = $product->getFolders();
                foreach ( $product_folders as $product_folder){
                    $product->deleteFolder($product_folder);
                }
                foreach ($needed_folders as $needed_folder){
                    $product->addFolder($needed_folder);
                }

                $product_flags = $product->getFlags();
                foreach ( $product_flags as $product_flag){
                    $product->deleteFlag($product_flag);
                }
                foreach ($needed_flags as $needed_flag){
                    $product->addFlag($needed_flag);
                }


                $product->setVendor($vendor);
                $product->setDescription($description);

                $product = $object_manager->save($product);
                $product_values = $product->getParamValues();
                foreach ( $product_values as $product_value){
                    $object_manager->remove($product_value);
                }
                foreach ($request_params as $param) {
                    $new_value = new ProductParamValue();
                    $param_id = $param["id"];
                    $param_type = $param_repository->find($param_id);
                    $param_value = $param["value"];
                    if ($param_type && $param_value){
                        $new_value->setProductParam($param_type);
                        $new_value->setValue($param_value);
                        $new_value->setProduct($product);
                        $object_manager->save($new_value);
                    }
                }


                $this->redirect("/admin/product");
            }
        }


        $folders = $folder_repository->findAll();
        $vendors = $vendor_repository->findAll();
        $params = $param_repository->findAll();
        $flags = $flag_repository->findAll();
        return $this->render("/admin/product/form.html.twig", [
            "product" => $product,
            "folders" => $folders,
            "vendors" => $vendors,
            "flags" => $flags,
            "error" => $error,
            "params"=>$params
        ]);
    }
    /**
     * @Route("/delete")
     */
    public function delete(ObjectManager $object_manager, Request $request, ProductRepository $product_repository)
    {
        $product_id = $request->post("product_id");
        $product = $product_repository->find($product_id);
        if ($product){
            $values = $product->getParamValues();
            foreach ($values as $value){
                $object_manager->remove($value);
            }
            $comments = $product->getComments();
            foreach ($comments as $comment){
                $object_manager->remove($comment);
            }
            $object_manager->remove($product);
        }
        return $this->redirect("/admin/product");
    }
    /**
     * @Route("/{id}")
     */
    public function item(ProductRepository $product_repository)
    {
        $product_id = $this->getParam("id");
        $product = $product_repository->find($product_id);

        return $this->render("/admin/product/item.html.twig",[
            "product"=>$product
        ]);
    }
}
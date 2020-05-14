<?php


namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Db\ObjectManager;
use App\Entity\Vendor;
use App\Http\Request;
use App\Repository\VendorRepository;

/**
 * Class VendorAdminController
 *
 * @Route("/admin/vendor")
 * @package App\Controller
 */
class VendorAdminController extends AbstractController
{


    /**
     * @Route("/create")
     */
    public function create(Request $request, ObjectManager $object_manager)
    {
        $vendor = $request->post("vendor");
        $error = '';
        if ($vendor) {
            $name = $vendor["name"];
            if (!$name) {
                $error .= "Не указано имя";
            }

            if (!$error) {
                $vendor = new Vendor();
                $vendor->setName($name);
                $object_manager->save($vendor);
                return $this->redirect("/admin/vendor/");
            }
        }


        return $this->render("/admin/vendor/form.html.twig", [
            "vendor" => $vendor,
            "error" => $error
        ]);
    }

    /**
     * @Route("/delete")
     */
    public function delete(Request $request, VendorRepository $vendor_repository, ObjectManager $object_manager)
    {
        $vendor_id = $request->post("vendor_id");
        $vendor = $vendor_repository->find($vendor_id);
        if ($vendor) {
            $object_manager->remove($vendor);
        }

        return $this->redirect("/admin/vendor");
    }

    /**
     * @Route("/{id}/edit")
     */
    public function edit(Request $request, VendorRepository $vendor_repository, ObjectManager $object_manager)
    {
        $vendor_id = $this->getRoute()->get("id");
        $vendor = $vendor_repository->find($vendor_id);
        $error = '';
        $vendor_post = $request->post("vendor");
        if ($vendor_post) {
            $name = $vendor_post["name"];
            if (!$name) {
                $error .= "Не указано имя";
            }
            if (!$error) {
                $vendor->setName($name);
                $object_manager->save($vendor);
                return $this->redirect("/admin/vendor/");
            }
        }
        return $this->render("/admin/vendor/form.html.twig", [
            "vendor" => $vendor,
            "error" => $error
        ]);
    }

    /**
     * @Route("/")
     */
    public function list(VendorRepository $vendor_repository)
    {
        $vendors = $vendor_repository->findAll();
        return $this->render("/admin/vendor/list.html.twig", [
            "vendors" => $vendors
        ]);
    }
}
<?php


namespace App\Controller\Admin;

use App\Controller\AbstractController;
use App\Db\ObjectManager;
use App\Entity\Vendor;
use App\Http\Request;
use App\Http\Response;
use App\Repository\VendorRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

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
     * @param Request       $request
     * @param ObjectManager $object_manager
     *
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
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
     * @param Request          $request
     * @param VendorRepository $vendor_repository
     * @param ObjectManager    $object_manager
     *
     * @return Response
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
     * @param Request          $request
     * @param VendorRepository $vendor_repository
     * @param ObjectManager    $object_manager
     *
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function edit(Request $request, VendorRepository $vendor_repository, ObjectManager $object_manager)
    {
        $vendor_id = $this->getParam("id");
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
     * @param VendorRepository $vendor_repository
     *
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function list(VendorRepository $vendor_repository)
    {
        $vendors = $vendor_repository->findAll();
        return $this->render("/admin/vendor/list.html.twig", [
            "vendors" => $vendors
        ]);
    }
}
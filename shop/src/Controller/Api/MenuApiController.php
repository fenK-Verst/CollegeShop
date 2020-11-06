<?php


namespace App\Controller\Api;


use App\Controller\AbstractController;
use App\Entity\Menu;
use App\Http\Response;
use App\Repository\MenuRepository;

/**
 * Class MenuApiController
 *
 * @Route("/api/menu")
 * @package App\Controller\Api
 */
class MenuApiController extends AbstractController
{
    /**
     * @Route("/")
     * @param MenuRepository $menu_repository
     *
     * @return Response
     */
    public function getAll(MenuRepository $menu_repository)
    {
        $menus = $menu_repository->findAll();
        $data = [];
        foreach ( $menus as $menu){
            $id = $menu->getId();
            $data[$id] = [
                "id"=>$id,
                "name"=>$menu->getName(),
            ];
        }
        $response = [
            "error"=>false,
            "status"=>"OK",
            "error_msg"=>'',
            "data"=>$data
        ];
        return $this->json($response);
    }
}
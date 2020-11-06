<?php


namespace App\Controller\Api;


use App\Controller\AbstractController;
use App\Entity\Image;
use App\Http\Response;
use App\Repository\ImageRepository;

/**
 * Class ImageApiController
 *
 * @Route("/api/image")
 * @package App\Controller\Api
 */
class ImageApiController extends AbstractController
{
    /**
     * @Route("/")
     * @param ImageRepository $image_repository
     *
     * @return Response
     */
    public function getAll(ImageRepository $image_repository)
    {
        $images = $image_repository->findBy([
            "type"=>Image::$PRODUCT_TYPE
        ]);
        $data = [];
        foreach ( $images as $image){
            $id = $image->getId();
            $data[$id] = [
                "id"=>$id,
                "alias"=>$image->getAlias(),
                "path"=>$image->getPath()
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
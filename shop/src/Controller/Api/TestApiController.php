<?php


namespace App\Controller\Api;

/**
 * Class TestApiController
 *
 * @Route("/api/test")
 * @package App\Controller\Api
 */
class TestApiController extends AbstractApiController
{
    /**
     * @Route("/", methods=["GET", "POST"], name="some_name")
     */
    public function index()
    {
        return $this->json('123');
    }

}
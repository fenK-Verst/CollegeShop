<?php


namespace App\Controller\Api;


use App\Controller\AbstractController;
use App\Http\Response;

/**
 * Class AbstractApiController
 *
 * @package App\Controller\Api
 */
abstract class AbstractApiController extends AbstractController
{
    /**
     * @param string $message
     *
     * @return Response
     */
    protected function error(string $message)
    {
        return $this->json([
            'status' => 'KO',
            'error_msg' => $message,
            'data' => []
        ]);
    }

    /**
     * @param $data
     *
     * @return Response
     */
    protected function success($data)
    {
        return $this->json([
            'status' => 'OK',
            'error_msg' => '',
            'data' => $data
        ]);
    }
}
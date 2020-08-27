<?php


namespace App\Controller\Api;


use App\Controller\AbstractController;
use App\Entity\Stonk;
use App\Repository\StonkRepository;

/**
 * @Route("api/stonk")
 *
 * Class StonkApiController
 * @package App\Controller\Api
 */
class StonkApiController extends AbstractController
{
    /**
     * @Route("/", methods=["post, get"])
     */
    public function index(StonkRepository $stonkRepository)
    {
        $stonks = $stonkRepository->findBy([
            'user_id' => 1
        ], [], [100]);
        $data = [];
        foreach ($stonks as $stonk) {

            /** @var Stonk $stonk */
            $id = $stonk->getId();
            $title = $stonk->getTitle();
            $description = $stonk->getDescription();
            $summ = $stonk->getSumm();
            $created_at = $stonk->getCreatedAt();
            $data[$id] = [
                'id' => $id,
                'title' => $title,
                'description' => $description,
                'summ' => $summ,
                'created_at' => $created_at,
            ];
        }
        return $this->success($data);
    }

    private function error(string $message)
    {
        return $this->json([
            'status' => 'KO',
            'error_msg' => $message,
            'data' => []
        ]);
    }

    private function success($data)
    {
        return $this->json([
            'status' => 'KO',
            'error_msg' => '',
            'data' => $data
        ]);
    }
}
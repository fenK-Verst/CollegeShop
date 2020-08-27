<?php


namespace App\Controller\Api;


use App\Controller\AbstractController;
use App\Db\ObjectManager;
use App\Entity\Stonk;
use App\Http\Request;
use App\Repository\StonkRepository;
use App\Repository\UserRepository;

/**
 * @Route("api/stonk")
 *
 * Class StonkApiController
 * @package App\Controller\Api
 */
class StonkApiController extends AbstractController
{

    /**
     * @Route("/", methods=["get"])
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

    /**
     * @Route("/", methods=["post"])
     */
    public function add(ObjectManager $objectManager, Request $request, UserRepository $userRepository)
    {
        $data = $request->post('stonk');

        $title = $data['title'];
        $description = $data['description'];
        $summ = (float)$data['summ'];

        if (!$title) {
            return $this->error('Не указан заголовок');
        }
        if (!$summ && $summ !== 0) {
            return $this->error('Не указана сумма');
        }

        $stonk = new Stonk();
        $stonk->setTitle($title);
        $stonk->setDescription($description);
        $stonk->setSumm($summ);
        $stonk->setUser($userRepository->find(1));
        $now = new \DateTime();
        $stonk->setCreatedAt($now->format('Y-m-d H:i:s'));
        $objectManager->save($stonk);

        return $this->success([]);
    }

    /**
     * @Route("/{id}", methods=["put"])
     */
    public function edit(ObjectManager $objectManager, Request $request, StonkRepository $stonkRepository)
    {
        $putfp = fopen('php://input', 'r');
        $putdata = '';
        while ($data = fread($putfp, 1024)) {
            $putdata .= $data;
        }
        fclose($putfp);
        parse_str($putdata, $putdata);

        $stonkData = $putdata['stonk'] ?? [];
        $id = $this->getRoute()->get('id');
        $stonk = $stonkRepository->find($id);
        if (!$stonk) {
            return $this->error('Stonk не найден =(');
        }
        $title = $stonkData['title'];
        $description = $stonkData['description'];
        $summ = (float)$stonkData['summ'];

        if (!$title) {
            return $this->error('Не указан заголовок');
        }
        if (!$summ && $summ !== 0) {
            return $this->error('Не указана сумма');
        }

        $stonk->setTitle($title);
        $stonk->setDescription($description);
        $stonk->setSumm($summ);
        $objectManager->save($stonk);

        return $this->success([]);
    }

    /**
     * @Route("/{id}", methods=["delete"])
     */
    public function delete(ObjectManager $objectManager, StonkRepository $stonkRepository)
    {

        $id = $this->getRoute()->get('id');
        $stonk = $stonkRepository->find($id);
        if (!$stonk) {
            return $this->error('Stonk не найден =(');
        }

        $objectManager->remove($stonk);

        return $this->success([]);
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
            'status' => 'OK',
            'error_msg' => '',
            'data' => $data
        ]);
    }
}
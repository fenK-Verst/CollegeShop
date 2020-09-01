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
        $user = $this->getUserService()->getCurrentUser();
        if (!$user) {
            return $this->userError();
        }
        $stonks = $stonkRepository->findBy([
            'user_id' => $user->getId()
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
        $user = $this->getUserService()->getCurrentUser();
        if (!$user) {
            return $this->userError();
        }
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
        $stonk->setUser($user);
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
        $user = $this->getUserService()->getCurrentUser();
        if (!$user) {
            return $this->userError();
        }
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
        if ($user->getId() != $stonk->getUser()->getId()){
            return $this->error('Вы не можете изменить stonk данного пользователя');
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
        $user = $this->getUserService()->getCurrentUser();
        if (!$user) {
            return $this->userError();
        }
        $id = $this->getRoute()->get('id');
        $stonk = $stonkRepository->find($id);
        if (!$stonk) {
            return $this->error('Stonk не найден =(');
        }
        if ($user->getId() != $stonk->getUser()->getId()){
            return $this->error('Вы не можете удалить stonk данного пользователя');
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

    private function userError()
    {
        return $this->error('user error');
    }
}
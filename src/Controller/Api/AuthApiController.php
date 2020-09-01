<?php


namespace App\Controller\Api;


use App\Http\Request;
use App\Repository\UserRepository;
use App\Service\UserService;

/**
 * Class AuthApiController
 * @package App\Controller\Api
 *
 * @Route("/api/auth")
 */
class AuthApiController extends AbstractApiController
{
    /**
     * @Route("/base")
     */
    public function index(UserService $service, UserRepository $userRepository)
    {
        $userRaw = $service->getCurrentUser();
        $user = $userRaw ?
            [
                'id' => $userRaw->getId(),
                'firstname' => $userRaw->getFirstname()
            ]
            : null;
        return $this->success([
            'user' => $user
        ]);
    }

    /**
     * @Route("/login")
     */
    public function login(UserService $service, Request $request, UserRepository $userRepository)
    {
        $request_user = $request->post('user') ?? [];
        $email = $request_user["email"] ?? null;
        $password = $request_user["password"] ?? null;

        if (!($email && $password)) {
            return $this->error("Не указаны все данные");
        }
        $password = $service->generatePassword($password);
        $user = $userRepository->findOneBy([
            "email" => $email,
            "password" => $password,
        ]);

        if (!$user) {
            return $this->error("Неверная почта/пароль");
        }
        $service->login($user);
        return $this->success([]);


    }
    /**
     * @Route("/hlogin")
     */
    public function hlogin(UserRepository $userRepository, UserService  $userService)
    {
        $user = $userRepository->find(1);
        $userService->loginByCookie($user);
        return $this->success([]);
    }

    /**
     * @Route("/logout")
     */
    public function logout(UserService $service)
    {
        $service->logout();
        return $this->json([
            'status' => 'OK'
        ]);
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
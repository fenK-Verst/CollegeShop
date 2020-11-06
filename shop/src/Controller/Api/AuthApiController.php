<?php


namespace App\Controller\Api;


use App\Http\Request;
use App\Http\Response;
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
     * @param UserService $service
     *
     * @return Response
     */
    public function index(UserService $service)
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
     * @param UserService    $service
     * @param Request        $request
     * @param UserRepository $userRepository
     *
     * @return Response
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
        $token = $service->loginByToken($user);

        return $this->success([
            "token"=>$token
        ]);


    }

    /**
     * @Route("/hlogin")
     * @param UserRepository $userRepository
     * @param UserService    $userService
     *
     * @return Response
     */
    public function hlogin(UserRepository $userRepository, UserService  $userService)
    {
        $user = $userRepository->find(1);
        $userService->loginByCookie($user);
        return $this->success([]);
    }

    /**
     * @Route("/logout")
     * @param UserService $service
     *
     * @return Response
     */
    public function logout(UserService $service)
    {
        $service->logout();
        return $this->json([
            'status' => 'OK'
        ]);
    }

}
<?php


namespace App\Service;


use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    private const SALT = "heretoPreservedbe";
    private const AUTH_COOKIE = 'X-AUTH-COOKIE';
    private UserRepository $userRepository;

    public function __construct(UserRepository $user_repository)
    {
        $this->userRepository = $user_repository;
    }

    public function generatePassword(string $password):string
    {
        $password = md5($password);
        $password = md5($password . self::SALT);

        return $password;
    }
    public function getCurrentUser()
    {

        $user_id = $_SESSION['user_id'] ?? base64_decode($_COOKIE[self::AUTH_COOKIE]) ?? null;
        if ($user_id) {
            $user = $this->userRepository->find($user_id);
            if (is_null($user)) {
                $this->logout();
            }
            return $user;
        }

        return null;

    }

    public function login(User $user)
    {
        $_SESSION['user_id'] = $user->getId();
    }

    public function loginByCookie(User $user)
    {
        setcookie (self::AUTH_COOKIE, base64_encode($user->getId()), time() + (10 * 365 * 24 * 60 * 60));
    }

    public function logout()
    {
        if (isset($_SESSION["user_id"])) unset($_SESSION["user_id"]);
        if (isset($_COOKIE[self::AUTH_COOKIE])) setcookie(self::AUTH_COOKIE, null, -1);
    }

    private function generateRandomString(int $length = 10): string {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
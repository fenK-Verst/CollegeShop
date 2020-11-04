<?php


namespace App\Service;


use App\Db\ObjectManager;
use App\Entity\User;
use App\Repository\UserRepository;

/**
 * Class UserService
 *
 * @package App\Service
 */
class UserService
{
    private const SALT = "heretoPreservedbe";
    private const AUTH_COOKIE = 'X-AUTH-COOKIE';
    private UserRepository $userRepository;
    private ObjectManager  $objectManager;

    public function __construct(UserRepository $user_repository, ObjectManager $objectManager)
    {
        $this->userRepository = $user_repository;
        $this->objectManager = $objectManager;
    }

    public function generatePassword(string $password): string
    {
        $password = md5($password);
        $password = md5($password . self::SALT);

        return $password;
    }

    private function getUserByToken(): ?User
    {
        $headers = getallheaders();
        $token = $headers['x-auth-token'] ?? $headers['X-Auth-Token'] ?? null;

        if ($token) {
            $token = $this->decodeToken($token);
            $user = $this->userRepository->findOneBy([
                'token' => $token
            ]);
            if (is_null($user)) {
                $this->logout();
            }
            return $user;
        }
        return null;
    }

    private function getUserBySession(): ?User
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if ($user_id) {
            $user = $this->userRepository->find($user_id);
            if (is_null($user)) {
                $this->logout();
            }
            return $user;
        }
        return null;
    }

    private function getUserByCookie(): ?User
    {
        $raw = $_COOKIE[self::AUTH_COOKIE] ?? null;
        $user_id = $raw ? $this->decodeToken($raw) : null;
        if ($user_id) {
            $user = $this->userRepository->find($user_id);
            if (is_null($user)) {
                $this->logout();
            }
            return $user;
        }
        return null;
    }

    public function getCurrentUser(): ?User
    {
        return $this->getUserBySession() ?? $this->getUserByCookie() ?? $this->getUserByToken();
    }

    public function login(User $user)
    {
        $_SESSION['user_id'] = $user->getId();
    }

    public function loginByCookie(User $user)
    {
        $token = $this->encodeToken($user->getId());
        setcookie(self::AUTH_COOKIE, $token, time() + (10 * 365 * 24 * 60 * 60));
    }

    public function loginByToken(User $user): string
    {
        $token = $this->generateRandomString(12);
        $user->setToken($token);
        $this->objectManager->save($user);
        return $this->encodeToken($token);
    }

    private function decodeToken(string $token): string
    {
        return mb_convert_encoding(base64_decode($token), 'UTF-8');
    }

    private function encodeToken(string $token): string
    {
        return mb_convert_encoding(base64_encode($token), 'UTF-8');
    }

    public function logout()
    {
        if (isset($_SESSION["user_id"])) {
            unset($_SESSION["user_id"]);
        }
        if (isset($_COOKIE[self::AUTH_COOKIE])) {
            setcookie(self::AUTH_COOKIE, null, -1);
        }
        $user = $this->getCurrentUser();
        if ($user) {
            $user->setToken(null);
            $this->objectManager->save($user);
        }
    }

    private function generateRandomString(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
}
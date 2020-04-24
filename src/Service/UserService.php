<?php


namespace App\Service;


use App\Entity\EntityInterface;
use App\Entity\User;
use App\Repository\UserRepository;

class UserService
{
    private static string $salt = "heretoPreservedbe";
    private UserRepository $userRepository;

    public function __construct(UserRepository $user_repository)
    {
        $this->userRepository = $user_repository;
    }

    public function generatePassword(string $password):string
    {
        $password = md5($password);
        $password = md5($password.$this::$salt);

        return $password;
    }
    public function getCurrentUser()
    {
        $user_id = $_SESSION['user_id'] ?? null;
        if ($user_id) {
            return $this->userRepository->find($user_id);
        }
        return null;

    }
    public function login(User $user)
    {
        $_SESSION['user_id'] = $user->getId();
    }
    public function logout()
    {
        if (isset($_SESSION["user_id"])) unset($_SESSION["user_id"]);
    }
}
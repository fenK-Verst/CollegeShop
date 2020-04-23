<?php


namespace App\Controller;


class UserController extends AbstractController
{
    /**
     * @Route("/login", name="user.login")
     */
    public function login()
    {
        return $this->render("user/login.html.twig");
    }
}
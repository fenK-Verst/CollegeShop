<?php


namespace App\Controller;


use App\Db\ObjectManager;
use App\Entity\User;
use App\Http\Request;
use App\Repository\UserRepository;
use App\Service\UserService;

class UserController extends AbstractController
{
    /**
     * @Route("/login", name="user.login")
     */
    public function login(Request $request, UserService $user_service, UserRepository $user_repository)
    {
        $error = '';
        $request_user = $request->post("user");
        if ($request_user) {
            $users = $user_repository->findBy([
                "email" => $request_user["email"],
                "password" => $user_service->generatePassword($request_user["password"]),
            ]);
            if (!count($users)) {
                $error = "Неверная почта/пароль";
            } else {
                $user = array_values($users)[0];
                $user_service->login($user);
                return $this->redirect("/cabinet");
            }
        }
        return $this->render("user/login.html.twig", [
            "error" => $error
        ]);
    }

    /**
     * @Route("/register", name="user.login")
     */
    public function register(
        Request $request,
        UserService $user_service,
        ObjectManager $object_manager,
        UserRepository $user_repository
    ) {
        $request_user = $request->post("user");
        $error = '';
        if (!empty($request_user)) {
            $user = new User();
            $email = $request_user["email"];
            $firstname = $request_user["firstname"];
            $lastname = $request_user["lastname"];
            $phone = $request_user["phone"];
            $password = $request_user["password"];
            $password_a = $request_user["password_a"];

            if (!$firstname) {
                $error .= "Не указано имя\n";
            }
            if (!$phone) {
                $error .= "Не указан телефон\n";
            }
            if (!$email) {
                $error .= "Не указана почта\n";
            }
            if ($password !== $password_a) {
                $error .= "Пароли не совпадают\n";
            }

            if (
                strlen($firstname) > 255 ||
                strlen($lastname) > 255 ||
                strlen($email) > 255 ||
                strlen($phone) > 255 ||
                strlen($password) > 255
            ) {
                $error .= "Слишком длинные значения\n";
            }
            if (!$error) {
                $user->setEmail($email);
                $user->setFirstname($firstname);
                $user->setLastname($lastname);
                $user->setPhone($phone);
                $unique = $user_repository->getNonUnique($user);
                if ($unique == 0) {
                    $password = $user_service->generatePassword($password);
                    $user->setPassword($password);

                    $user = $object_manager->save($user);
                    $user_service->login($user);
                    return $this->redirect("/cabinet");
                } else {
                    $error .= "Человек с таким телефоном/почтой уже зарегистрирован\n";
                }
            }
        }

        return $this->render("user/register.html.twig", [
            "user" => $request_user,
            "error" => $error
        ]);
    }

    /**
     * @Route("/cabinet")
     */
    public function cabinet(UserService $user_service)
    {
        $user = $user_service->getCurrentUser();
        if (!$user) {
            return $this->redirect("/login");
        }
        return $this->render("user/cabinet.html.twig");
    }

    /**
     * @Route("/logout")
     */
    public function logout(UserService $user_service)
    {
        $user_service->logout();
        return $this->redirect("/");
    }
}
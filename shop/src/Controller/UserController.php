<?php


namespace App\Controller;


use App\Config;
use App\Db\ObjectManager;
use App\Entity\Image;
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
        UserRepository $user_repository,
        Config $config
    ) {
        $request_user = $request->post("user");
        $error = '';
        $save_dir = $config->get("config")["avatar_directory"];
        if (!$save_dir) {
            $error .= "Не найдена директория для сохранения. Обратитесь к разработчику";
        } elseif (!is_dir($_SERVER["DOCUMENT_ROOT"] . $save_dir)) {
            mkdir($_SERVER["DOCUMENT_ROOT"] . $save_dir);
        }


        if (!empty($request_user)) {
            $user = new User();
            $email = $request_user["email"];
            $firstname = $request_user["firstname"];
            $lastname = $request_user["lastname"];
            $phone = $request_user["phone"];
            $password = $request_user["password"];
            $password_a = $request_user["password_a"];
            $image = null;
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

            $file = $_FILES["user"];

            if (!$error) {
                $user->setEmail($email);
                $user->setFirstname($firstname);
                $user->setLastname($lastname);
                $user->setPhone($phone);
                $user->setImage($image);
                $unique = $user_repository->getNonUnique($user);
                if ($unique == 0) {
                    if ($file["name"]["avatar"] && !$error) {
                        $uploadfile = $save_dir . basename($file['name']["avatar"]);
                        $is_file_exsits = file_exists($_SERVER["DOCUMENT_ROOT"] . $uploadfile);

                        $types = [
                            "image/gif",
                            "image/png",
                            "image/svg",
                            "image/jpg",
                            "image/jpeg",
                            "image/svg"
                        ];
                        if (!in_array($file['type']["avatar"], $types)) {
                            $error .= "Файл должен быть изображением\n";
                        } elseif ($is_file_exsits) {
                            $error .= "Файл уже существует. Попробуйте изменить название файла";
                        } elseif (move_uploaded_file($file['tmp_name']["avatar"],
                            $_SERVER["DOCUMENT_ROOT"] . $uploadfile)) {
                            $image = new Image();
                            $image->setAlias($file['name']["avatar"]);
                            $image->setPath($uploadfile);
                            $image->setType(image::$AVATAR_TYPE);
                            $image = $object_manager->save($image);
                        } elseif (!is_writable($_SERVER["DOCUMENT_ROOT"] . $uploadfile)) {
                            $error .= "Не могу записать файл\n";
                        } else {
                            $error .= "Что то пошло не так\n";
                        }
                    }
                    if (!$error) {
                        $password = $user_service->generatePassword($password);
                        $user->setPassword($password);
                        $user->setImage($image);
                        $user = $object_manager->save($user);
                        $user_service->login($user);
                        return $this->redirect("/cabinet");
                    }


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
    public
    function cabinet(
        UserService $user_service
    ) {
        $user = $user_service->getCurrentUser();
        if (!$user) {
            return $this->redirect("/login");
        }
        return $this->render("user/cabinet.html.twig", [
            "user"=>$user
        ]);
    }

    /**
     * @Route("/logout")
     */
    public
    function logout(
        UserService $user_service
    ) {
        $user_service->logout();
        return $this->redirect("/");
    }
}
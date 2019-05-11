<?php
declare(strict_types=1);

namespace Controllers;

use Core\Validator;
use Core\View;
use Entity\Users;
use Form\UsersForm;
use Repository\UsersRepository;


class UsersController
{
    private $user;
    private $userRepository;

    public function __construct(Users $user, UsersRepository $usersRepository)
    {
        $this->user = $user;
        $this->userRepository = $usersRepository;
    }

    public function defaultAction(): void
    {
        echo "users default";
    }

    public function addAction(): void
    {
        $user = new Users();
        $form = $user->getRegisterForm();

        $v = new View("addUser", "front");
        $v->assign("form", $form);
    }

    public function saveAction(): void
    {
        $user = new Users();
        $form = $user->getRegisterForm();
        $method = strtoupper($form["config"]["method"]);
        $data = $GLOBALS["_" . $method];


        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form["errors"] = $validator->errors;

            if (empty($errors)) {
                $user->setFirstname($data["firstname"]);
                $user->setLastname($data["lastname"]);
                $user->setEmail($data["email"]);
                $user->setPwd($data["pwd"]);
                $user->save();
            }
        }

        $v = new View("addUser", "front");
        $v->assign("form", $form);
    }


    public function loginAction(): void
    {
        $userRep = new UsersForm();
        $form = $userRep->getLoginForm();

        $method = strtoupper($form['config']['method']);
        $data = $GLOBALS['_' . $method];
        if ($_SERVER['REQUEST_METHOD'] == $method && !empty($data)) {
            $validator = new Validator($form, $data);
            $form['errors'] = $validator->errors;

            if (empty($errors)) {
                $uniq = substr(uniqid() . time(), 4, 10);
                $token = md5($uniq . 'mxu(4il');
                // TODO: connexion
                $login = $_POST['email'];
                $password = $_POST['pwd'];
                if ($login != null && $password != null) {
                    $user = $this->userRepository->getUserLogin($login);
                    if ($user) {
                        if (password_verify($password, $user['pwd'])) {
                            session_start();
                            $_SESSION['email'] = $user['email'];
                            $_SESSION['id'] = $user['id'];
                            $view = new View('homepage', 'back');
                            $view->assign('pseudo', 'prof');
                        }
                    }
                }
            }
        }
        $view = new View('loginUser', 'front');
        $view->assign('form', $form);
    }


    public function forgetPasswordAction(): void
    {
        $v = new View("forgetPasswordUser", "front");
    }
}

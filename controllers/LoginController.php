<?php

declare(strict_types=1);

class LoginController extends Controller
{

    public function __construct()
    {
        Auth::check();
        $this->loadModels(['user']);
    }

    public function index()
    {
        if ($this->submitForm()) {

            $email = $_POST['email'];
            $password = $_POST['password'];

            $this->model('user')->setEmail($email);
            $this->model('user')->setPassword($password);

            $login = $this->model('user')->login();
            $this->setResponseMessage($login['message']);
        }

        Head::title('Iniciar sesión');
        include View::render('user', 'login');
    }
}

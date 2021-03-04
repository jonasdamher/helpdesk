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

            $form = $this->model('user')->isValid();

            if ($form['valid']) {
                $login = $this->model('user')->login();
                $this->notification()->setResponseMessage($login['message']);
            } else {
                $this->notification()->setResponseMessage($form['message']);
            }
        }

        Head::title('Iniciar sesión');
        Head::robots('index,follow');
        include View::render('user', 'login');
    }
}

<?php

declare(strict_types=1);

class UserController extends Controller
{

    public function __construct()
    {
        Auth::access();
        $this->loadModels(['user']);
    }

    public function index()
    {
        $table = $this->model('user')->readAll();
        $pagination = $this->model('user')->paginations();

        Head::title('Usuarios');
        include View::render('user');
    }

    public function new()
    {
        $user = [
            'name' => Utils::postCheck('name'),
            'lastname' => Utils::postCheck('lastname'),
            'email' => Utils::postCheck('email'),
            'password' => Utils::postCheck('password'),
            'password_repeat' => Utils::postCheck('password_repeat'),
            '_id_rol' => Utils::postCheck('id_rol'),
            '_id_status' => Utils::postCheck('id_status')
        ];

        $roles = $this->model('user')->getRoles()['result'];
        $status = $this->model('user')->getStatus()['result'];

        if ($this->submitForm()) {

            $this->model('user')->setName($user['name']);
            $this->model('user')->setLastname($user['lastname']);
            $this->model('user')->setEmail($user['email']);
            $this->model('user')->setPassword($user['password']);
            $this->model('user')->setIdRol($user['_id_rol']);
            $this->model('user')->setIdStatus($user['_id_status']);

            $form = $this->model('user')->isValid();

            if ($form['valid']) {
                $newUser = $this->model('user')->create();
                $this->setResponseMessage($newUser['message']);
            } else {
                $this->setResponseMessage($form['message']);
            }
        }

        $urlForm = URL_BASE . $_GET['controller'] . '/new';
        $url = 'controller';
        $nameSection = 'Nuevo usuario';
        $type = 'new';

        Head::title($nameSection);
        include View::render('user', 'contentForm');
    }

    public function update()
    {
        $this->model('user')->setId($_GET['id']);

        $user = $this->model('user')->read()['result'];
        $roles = $this->model('user')->getRoles()['result'];
        $status = $this->model('user')->getStatus()['result'];

        if ($this->submitForm()) {

            $this->model('user')->setName($user['name']);
            $this->model('user')->setLastname($user['lastname']);
            $this->model('user')->setEmail($user['email']);
            $this->model('user')->setPassword($user['password']);
            $this->model('user')->setIdRol($user['_id_rol']);
            $this->model('user')->setIdStatus($user['_id_status']);

            $form = $this->model('user')->isValid();

            if ($form['valid']) {
                $user = $this->model('user')->create();
                $this->setResponseMessage($user['message']);
            } else {
                $this->setResponseMessage($form['message']);
            }
        }

        $urlForm = URL_BASE . $_GET['controller'] . '/update/' . $_GET['id'];
        $url = 'controller';
        $nameSection = 'Ficha de usuario';
        $type = 'update';

        Head::title($nameSection);
        include View::render('user', 'contentForm');
    }

    public function account()
    {
        $this->model('user')->setId($_SESSION['user_init']);

        $user = $this->model('user')->read();
        Head::title('Perfil');
        include View::render('user', 'account');
    }

    public function logout()
    {
        $this->model('user')->logout();
    }
}

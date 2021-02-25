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
        $users = $this->model('user')->readAll();
        $pagination = $this->model('user')->paginations();

        $title = 'Usuarios';
        $buttonName = 'Añadir';
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
            '_id_rol' => Utils::postCheck('id_status')
        ];

        $roles = $this->model('user')->getRoles()['result'];
        $status = $this->model('user')->getStatus()['result'];

        $urlForm = URL_BASE . $_GET['controller'] . '/new';
        $url = 'controller';
        $nameSection = 'Nuevo usuario';
        $type = 'new';

        include View::render('user', 'form');
    }

    public function update()
    {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        if (!is_numeric($id)) {
            Utils::redirection('user/account');
        }
        $id = (int) $id;

        $this->model('user')->setId($id);
        $user = $this->model('user')->read()['result'];

        $roles = $this->model('user')->getRoles()['result'];
        $status = $this->model('user')->getStatus()['result'];

        $urlForm = URL_BASE . $_GET['controller'] . '/update/' . $_GET['id'];
        $url = 'controller';
        $nameSection = 'Ficha de usuario';
        $type = 'update';

        include View::render('user', 'form');
    }

    public function account()
    {

        $this->model('user')->setId($_SESSION['user_init']);

        $user = $this->model('user')->read();

        include View::render('user', 'account');
    }

    public function logout()
    {
        $this->model('user')->logout();
    }
}

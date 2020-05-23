<?php 

require_once 'BaseController.php';

class UserController extends BaseController {

    public function __construct() {
        parent::__construct(['user']);
    }

    public function index() {   
        $this->permission([1]);
        $users = $this->model('user')->readAll();
        $pagination = $this->model('user')->paginations();
        
        include $this->view('user/index');
    }

    public function new() {
        $this->permission([1]);
        $roles = $this->model('user')->getRoles();
        $status = $this->model('user')->getStatus();

        if($this->submitForm() ) {

            $validator = $this->model('user')->formValidate('only');

            if($validator['valid']) {

                $schema = $validator['schema'];

                if($schema['password'] === $_POST['password_repeat']) {

                    $this->model('user')->setName($schema['name']);
                    $this->model('user')->setLastname($schema['lastname']);
                    $this->model('user')->setEmail($schema['email']);
                    $this->model('user')->setPassword($schema['password']);
                    $this->model('user')->setIdRol($schema['id_rol']);
                    $this->model('user')->setIdStatus($schema['id_status']);
                    $this->model('user')->setImage('image');

                    $this->setResponseMessage($this->model('user')->create());

                }else {
                    $this->setResponseMessage('Las contraseñas no coinciden');    
                }
            }else {
                $this->setResponseMessage($validator['errors']);    
            }
            
        }
        
        include $this->view('user/new');
    }

    public function update() {
        
        $this->permission([1]);  

        $this->model('user')->setId($_GET['id']);

        $user = $this->model('user')->read();
        
        $roles = $this->model('user')->getRoles();
        $status = $this->model('user')->getStatus();

        if($this->submitForm() ) {

            $validator = $this->model('user')->formValidate('only');

            if($validator['valid']) {

                $schema = $validator['schema'];

                $this->model('user')->setName($schema['name']);
                $this->model('user')->setLastname($schema['lastname']);
                $this->model('user')->setEmail($schema['email']);
                $this->model('user')->setIdRol($schema['id_rol']);
                $this->model('user')->setIdStatus($schema['id_status']);
                $this->model('user')->setImage('image');

                $this->setResponseMessage($this->model('user')->update());

            }else {
                $this->setResponseMessage($validator['errors']);    
            }
            
        }
        
        include $this->view('user/update');
    }

    public function account() {

        $this->permission([1, 2]);

        $this->model('user')->setId($_SESSION['user_init']);

        $user = $this->model('user')->read();

        if($this->submitForm() ) {

            $validator = $this->model('user')->formValidate('only');

            if($validator['valid']) {

                $schema = $validator['schema'];
                
                if($schema['password'] === $_POST['password_repeat']) {

                    $this->model('user')->setPassword($schema['currentPassword']);
                    $checkPassword = $this->model('user')->verifyPassword();
                    
                    if($checkPassword['valid']) { 
                        $this->model('user')->setPassword($schema['password']);
                        $this->setResponseMessage($this->model('user')->updatePassword() );
                    }else {
                        $this->setResponseMessage($checkPassword['error']);    
                    }

                }else {
                    $this->setResponseMessage('Las contraseñas no coinciden');    
                }
            }else {
                $this->setResponseMessage($validator['errors']);    
            }
            
        }
        
        include $this->view('user/account');
    }

    public function logout() {
        $this->permission([1, 2]);
        $this->model('user')->logout();
    }
}

?>
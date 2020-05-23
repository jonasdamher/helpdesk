<?php 

require_once 'BaseController.php';

class LoginController extends BaseController {

    public function __construct() {
        $this->permission([0]);
        parent::__construct(['user']);
    }

    public function index() {   

        if($this->submitForm() ) {

            $recaptcha = require_once 'libs/recaptcha.php';

            if($recaptcha && isset($recaptcha->score) && $recaptcha->score >= 0.6) {

                $validator = $this->model('user')->formValidate('only');

                if($validator['valid']) {

                    $schema = $validator['schema'];

                    $this->model('user')->setEmail($schema['email']);
                    $this->model('user')->setPassword($schema['password']);

                    $this->setResponseMessage($this->model('user')->login());

                }else {
                    $this->setResponseMessage($validator['errors']);    
                }
            }else {
                $this->setResponseMessage('Hubo un error al verificar reCAPTCHA, intentalo de nuevo.');    
            }
        }

        include $this->view('user/login');
    }

}

?>
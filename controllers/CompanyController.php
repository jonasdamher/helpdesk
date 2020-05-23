<?php 

require_once 'BaseController.php';

class CompanyController extends BaseController {

    public function __construct() {
        $this->permission([1]);
        parent::__construct(['company']);
    }

    public function index() {   

        $companies = $this->model('company')->readAll();
        $pagination = $this->model('company')->paginations();

        include $this->view('company/index');
    }

    public function new() {
   
        $status = $this->model('company')->getStatus();

        if($this->submitForm() ) {

            $validator = $this->model('company')->formValidate('all');

            if($validator['valid']) {

                $schema = $validator['schema'];

                $this->model('company')->setTradename($schema['tradename']);
                $this->model('company')->setBusinessName($schema['business_name']);
                $this->model('company')->setCif($schema['cif']);
                $this->model('company')->setIdStatus($schema['id_status']);

                $this->setResponseMessage($this->model('company')->create() );

            }else {
                $this->setResponseMessage($validator['errors']);    
            }
            
        }
        
        include $this->view('company/new');
    }

    public function update() {

        $this->model('company')->setId($_GET['id']);
        
        $company = $this->model('company')->read();
        
        $status = $this->model('company')->getStatus();

        if($this->submitForm() ) {

            $validator = $this->model('company')->formValidate('all');

            if($validator['valid']) {

                $schema = $validator['schema'];

                $this->model('company')->setTradename($schema['tradename']);
                $this->model('company')->setbusinessName($schema['business_name']);
                $this->model('company')->setCif($schema['cif']);
                $this->model('company')->setIdStatus($schema['id_status']);

                $this->setResponseMessage($this->model('company')->update() );

            }else {
                $this->setResponseMessage($validator['errors']);    
            }
            
        }

        include $this->view('company/update');
    }

}

?>
<?php

declare(strict_types=1);

class CompanyController extends Controller
{

    public function __construct()
    {
        Auth::access();
        $this->loadModels(['company']);
    }

    public function index()
    {

        $companies = $this->model('company')->readAll();
        $pagination = $this->model('company')->paginations();

        include View::render('company');
    }

    public function new()
    {

        $status = $this->model('company')->getStatus();

        if ($this->submitForm()) {

            $validator = $this->model('company')->formValidate('all');

            if ($validator['valid']) {

                $schema = $validator['schema'];

                $this->model('company')->setTradename($schema['tradename']);
                $this->model('company')->setBusinessName($schema['business_name']);
                $this->model('company')->setCif($schema['cif']);
                $this->model('company')->setIdStatus($schema['id_status']);

                $this->setResponseMessage($this->model('company')->create());
            } else {
                $this->setResponseMessage($validator['errors']);
            }
        }

        include View::render('company', 'new');
    }

    public function update()
    {

        $this->model('company')->setId($_GET['id']);

        $company = $this->model('company')->read();

        $status = $this->model('company')->getStatus();

        if ($this->submitForm()) {

            $validator = $this->model('company')->formValidate('all');

            if ($validator['valid']) {

                $schema = $validator['schema'];

                $this->model('company')->setTradename($schema['tradename']);
                $this->model('company')->setbusinessName($schema['business_name']);
                $this->model('company')->setCif($schema['cif']);
                $this->model('company')->setIdStatus($schema['id_status']);

                $this->setResponseMessage($this->model('company')->update());
            } else {
                $this->setResponseMessage($validator['errors']);
            }
        }

        include View::render('company', 'update');
    }
}

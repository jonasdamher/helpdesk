<?php

require_once 'BaseController.php';

class PointOfSaleController extends BaseController {

    public function __construct() {
        $this->permission([1, 2]);
        parent::__construct(['pointOfSale', 'contactPointOfSale']);
    }

    public function index() {   

        $pointsOfSales = $this->model('pointOfSale')->readAll();
        $pagination = $this->model('pointOfSale')->paginations();

        include $this->view('pointOfSale/index');
    }

    public function details() {

        // POINT OF SALE
        $this->model('pointOfSale')->setId($_GET['id']);
        $pointOfSale = $this->model('pointOfSale')->getDetails();
        
        // CONTACTS POINT OF SALE
        $this->model('contactPointOfSale')->setIdPto($_GET['id']);
        $contacts = $this->model('contactPointOfSale')->readAll();
        $pagination = $this->model('contactPointOfSale')->paginations();

        include $this->view('pointOfSale/details');
    }

    public function new() {

        $companies = $this->model('pointOfSale')->getCompanies();
        $status = $this->model('pointOfSale')->getStatus();
        $countries = $this->model('pointOfSale')->getCountries();

        if($this->submitForm() ) {

            $validator = $this->model('pointOfSale')->formValidate('all');

            if($validator['valid']) {

                $schema = $validator['schema'];
                
                $this->model('pointOfSale')->setIdCompany($schema['id_company']);
                $this->model('pointOfSale')->setIdStatus($schema['id_status']);
                $this->model('pointOfSale')->setName($schema['name']);
                $this->model('pointOfSale')->setCompanyCode($schema['company_code']);
                $this->model('pointOfSale')->setIdCountry($schema['id_country']);
                $this->model('pointOfSale')->setProvince($schema['province']);
                $this->model('pointOfSale')->setLocality($schema['locality']);
                $this->model('pointOfSale')->setPostalCode($schema['postal_code']);
                $this->model('pointOfSale')->setAddress($schema['address']);

                $this->setResponseMessage($this->model('pointOfSale')->create() );

            }else {
                $this->setResponseMessage($validator['errors']);    
            }
            
        }
        
        include $this->view('pointOfSale/new');
    }

    public function update() {

        $this->model('pointOfSale')->setId($_GET['id']);

        $pointOfSale = $this->model('pointOfSale')->read();

        $companies = $this->model('pointOfSale')->getCompanies();
        $status = $this->model('pointOfSale')->getStatus();
        $countries = $this->model('pointOfSale')->getCountries();
        $country = Utils::nameDatalist($countries, $pointOfSale['_id_country'], 'name');

        if($this->submitForm() ) {

            $validator = $this->model('pointOfSale')->formValidate('all');

            if($validator['valid']) {

                $schema = $validator['schema'];

                $this->model('pointOfSale')->setIdCompany($schema['id_company']);
                $this->model('pointOfSale')->setIdStatus($schema['id_status']);
                $this->model('pointOfSale')->setName($schema['name']);
                $this->model('pointOfSale')->setCompanyCode($schema['company_code']);
                $this->model('pointOfSale')->setIdCountry($schema['id_country']);
                $this->model('pointOfSale')->setProvince($schema['province']);
                $this->model('pointOfSale')->setLocality($schema['locality']);
                $this->model('pointOfSale')->setPostalCode($schema['postal_code']);
                $this->model('pointOfSale')->setAddress($schema['address']);

                $this->setResponseMessage($this->model('pointOfSale')->update() );

            }else {
                $this->setResponseMessage($validator['errors']);    
            }
            
        }
        
        include $this->view('pointOfSale/update');
    }

}

?>
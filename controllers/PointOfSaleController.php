<?php

declare(strict_types=1);

class PointOfSaleController extends Controller
{

    public function __construct()
    {
        Auth::access();
        $this->loadModels(['pointOfSale', 'contactPointOfSale']);
    }

    public function index()
    {
        $table = $this->model('pointOfSale')->readAll();
        $pagination = $this->model('pointOfSale')->paginations();

        Head::title('Puntos de venta');
        include View::render('pointOfSale');
    }

    public function new()
    {
        $pointOfSale = [
            'name' => Utils::postCheck('name'),
            'company_code' => Utils::postCheck('company_code'),
            'id_company' => Utils::postCheck('id_company'),
            'id_status' => Utils::postCheck('id_status'),
            'country' => Utils::postCheck('country'),
            'address' => Utils::postCheck('address'),
            'province' => Utils::postCheck('province'),
            'locality' => Utils::postCheck('locality'),
            'postal_code' => Utils::postCheck('postal_code'),
            'id_country' => Utils::postCheck('id_country')
        ];

        $companies = $this->model('pointOfSale')->getCompanies()['result'];
        $status = $this->model('pointOfSale')->getStatus()['result'];
        $countries = $this->model('pointOfSale')->getCountries()['result'];

        if ($this->submitForm()) {
        }

        $urlForm = URL_BASE . $_GET['controller'] . '/new';
        $url = 'controller';
        $nameSection = 'Nuevo punto de venta';
        $type = 'new';
        Head::title($nameSection);

        include View::render('pointOfSale', 'contentForm');
    }

    public function details()
    {
        // POINT OF SALE
        $this->model('pointOfSale')->setId($_GET['id']);

        $pointOfSale = $this->model('pointOfSale')->getDetails()['result'];

        // CONTACTS POINT OF SALE
        $this->model('contactPointOfSale')->setIdPto($_GET['id']);

        $contacts = $this->model('contactPointOfSale')->readAll()['result'];
        $pagination = $this->model('contactPointOfSale')->paginations();

         $nameSection = 'Ficha de punto de venta';
        $section = 'views/pointOfSale/details.php';

        Head::title('Ficha ' . $pointOfSale['name']);
        Footer::js(['Request', 'Validator', 'pointOfSale/Contact', 'pointOfSale/Details']);

        include View::render('pointOfSale', 'contentTab');
    }

    public function update()
    {
        $this->model('pointOfSale')->setId($_GET['id']);

        $pointOfSale = $this->model('pointOfSale')->read()['result'];
        $companies = $this->model('pointOfSale')->getCompanies()['result'];
        $status = $this->model('pointOfSale')->getStatus()['result'];
        $countries = $this->model('pointOfSale')->getCountries()['result'];
        $pointOfSale['country'] = Utils::nameDatalist($countries, $pointOfSale['_id_country'], 'name');

        if ($this->submitForm()) {
        }

        $urlForm = URL_BASE . $_GET['controller'] . '/update/' . $_GET['id'];
         $nameSection = 'Actualizar punto de venta';
        $type = 'update';
        $section = 'views/pointOfSale/form.php';

        Head::title('Actualizar ' . $pointOfSale['name']);
        include View::render('pointOfSale', 'contentTab');
    }
}

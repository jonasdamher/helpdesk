<?php

class PointOfSaleModel extends BaseModel implements Crud {

    private int $id;
    private int $idCompany;
    private int $idStatus;
    private string $name;
    private ?string $companyCode;
    private ?int $idCountry;
    private ?string $province;
    private ?string $locality;
    private ?int $postalCode;
    private ?string $address;

    public function __construct($conn) {
        parent::__construct();
        $this->conn = $conn;
        $this->table = 'points_of_sales';
        $this->setSchema('PointOfSaleSchema');
    }

    // GET & SET

    public function getId() {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getIdCompany() {
        return $this->idCompany;
    }

    public function setIdCompany(string $idCompany) {
        $this->idCompany = $idCompany;
    }

    public function getIdStatus() {
        return $this->idStatus;
    }

    public function setIdStatus(string $status) {
        $this->idStatus = $status;
    }

    public function getName() {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
    }
    
    public function getCompanyCode() {
        return $this->companyCode;
    }

    public function setCompanyCode(?string $companyCode) {
        $this->companyCode = $companyCode;
    }

    public function getIdCountry() {
        return $this->idCountry;
    }

    public function setIdCountry(?int $idCountry) {
        $this->idCountry = $idCountry;
    }
        
    public function getProvince() {
        return $this->province;
    }

    public function setProvince(?string $province) {
        $this->province = $province;
    }

    public function getLocality() {
        return $this->locality;
    }

    public function setLocality(?string $locality) {
        $this->locality = $locality;
    }

    public function getPostalCode() {
        return $this->postalCode;
    }

    public function setPostalCode(?int $postalCode) {
        $this->postalCode = $postalCode;
    }

    public function getAddress() {
        return $this->address;
    }   

    public function setAddress(?string $address) {
        $this->address = $address;
    }

    /**
     *  METHODS
     *  PRIVATES METHODS
    */ 

    private function queryPointOfSale() {

        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect("$this->table._id, 
        $this->table.name, 
        $this->table.created, 
        $this->table.company_code, 
        $this->table._id_status, 
        $this->table._id_company, pto_status.status, companies.business_name, companies.cif");
       
        $build->setFrom($this->table);

        $build->setInner("INNER JOIN companies ON $this->table._id_company = companies._id
        INNER JOIN pto_status ON $this->table._id_status = pto_status._id");

        $build->setSearch("$this->table.name LIKE :search OR
        $this->table.company_code LIKE :search OR
        companies.cif LIKE :search OR
        companies.business_name LIKE :search OR
        companies.tradename LIKE :search");
            
        return $build->query();
    }

    //  PUBLICS METHODS

    public function create() {
        try {
            
            $new = $this->connect()->prepare(
                "INSERT 
                INTO $this->table 
                (_id_company, 
                _id_status, 
                name, 
                company_code,
                _id_country, 
                province, 
                locality,
                postal_code,
                address) 
                VALUES (:idCompany, 
                :idStatus, 
                :name, 
                :companyCode, 
                :country, 
                :province, 
                :locality, 
                :postalCode, 
                :address)"
            );

            $new->bindValue(':idCompany', $this->getIdCompany(), PDO::PARAM_INT);
            $new->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_INT);
            $new->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $new->bindValue(':companyCode', $this->getCompanyCode(), PDO::PARAM_STR);
            $new->bindValue(':country', $this->getIdCountry(), PDO::PARAM_INT);
            $new->bindValue(':province', $this->getProvince(), PDO::PARAM_STR);
            $new->bindValue(':locality', $this->getLocality(), PDO::PARAM_STR);
            $new->bindValue(':postalCode', $this->getPostalCode(), PDO::PARAM_INT);
            $new->bindValue(':address', $this->getAddress(), PDO::PARAM_STR);

            if($new->execute() ) {
                return 'Punto de venta registrado.';
            }else {
                return 'Hubo un error al registrar, intentalo mas tarde.';
            }

        }catch(PDOexception $e) {
            return $e->getMessage();
        }
    }

    public function read() {
        return $this->getById($this->getId() );
    }

    public function readAll() {
        return $this->getAllQuery($this->queryPointOfSale() );
    }

    public function update() {
        try {

            $update = $this->connect()->prepare(
                "UPDATE 
                $this->table 
                SET 
                _id_company = :company, 
                _id_status = :status, 
                name = :name, 
                company_code = :code, 
                _id_country = :country, 
                province = :province, 
                locality = :locality,
                postal_code = :postal_code,
                address = :address
                WHERE _id = :id"
            );

            $update->bindValue(':company', $this->getIdCompany(), PDO::PARAM_INT);
            $update->bindValue(':status', $this->getIdStatus(), PDO::PARAM_INT);

            $update->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $update->bindValue(':code', $this->getCompanyCode(), PDO::PARAM_STR);

            $update->bindValue(':country', $this->getIdCountry(), PDO::PARAM_INT);
            $update->bindValue(':province', $this->getProvince(), PDO::PARAM_STR);
            $update->bindValue(':locality', $this->getLocality(), PDO::PARAM_STR);
            $update->bindValue(':postal_code', $this->getPostalCode(), PDO::PARAM_INT);
            $update->bindValue(':address', $this->getAddress(), PDO::PARAM_STR);
            
            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

            if($update->execute() ) {
                header('Location: '.url_base.$_GET['controller'].'/'.$_GET['action'].'/'.$_GET['id'].'?status=1');
            }else {
                header('Location: '.url_base.$_GET['controller'].'/'.$_GET['action'].'/'.$_GET['id'].'?status=0');
            }
        }catch(PDOexception $e) {
            return $e->getMessage();
        }
    }

    public function delete() {

    }

    public function getDetails() {
        try{

            $get = $this->connect()->prepare(
                "SELECT 
                $this->table.name,
                $this->table.company_code,
                $this->table._id_country,
                $this->table.province,
                $this->table.locality,
                $this->table.postal_code,
                $this->table.address,
                $this->table.created,
                pto_status.status,
                companies.tradename,
                companies.cif,
                companies.business_name,
                countries.name as namecountry
                FROM $this->table
                INNER JOIN
                pto_status
                ON $this->table._id_status = pto_status._id
                INNER JOIN
                companies
                ON $this->table._id_company = companies._id
                LEFT JOIN
                countries
                ON $this->table._id_country = countries._id
                WHERE $this->table._id = :id
            ");

            $get->bindValue(':id', $this->getId(), PDO::PARAM_INT);
            $get->execute();
            $result = $get->fetch(PDO::FETCH_ASSOC);
            
            $get = null;

            return $result;

        }catch(PDOexception $e) {
            return $e->getMessage();
        }
    }

    // OTHERS METHODS

    public function paginations() {
        return $this->pagination('paginations', $this->queryPointOfSale() );
    }
   
    public function getCompanies() {
        try{

            $get = $this->connect()->prepare(
                "SELECT _id, business_name
                FROM companies
                WHERE _id_status = :status"
            );

            $get->bindValue(':status', 1, PDO::PARAM_INT);

            $get->execute();
           
            $result = $get->fetchAll(PDO::FETCH_ASSOC);
            
            $get = null;

            return $result;

        }catch(PDOexception $e) {
            return $e->getMessage();
        }
    }

    public function getStatus() {
        return $this->getAllOtherTable('pto_status');
    }

    public function getCountries() {
        return $this->getAllOtherTable('countries');
    }
}

?>
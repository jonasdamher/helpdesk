<?php 


class SupplierModel extends BaseModel implements Crud {

    private int $id;
    private string $tradename;
    private string $businessName;
    private string $cif;
    private ?int $idCountry;
    private ?string $province;
    private ?string $locality;
    private ?int $postalCode;
    private ?string $address;
    private ?int $phone;
    private ?string $email;

    public function __construct($conn) {
        parent::__construct();
        $this->conn = $conn;
        $this->table = 'suppliers';
        $this->setSchema('SupplierSchema');
    }
    
    // GET & SET

    public function getId() {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getTradename() {
        return $this->tradename;
    }

    public function setTradename(string $tradename) {
        $this->tradename = $tradename;
    }

    public function getbusinessName() {
        return $this->businessName;
    }

    public function setbusinessName(string $business_name) {
        $this->businessName = $business_name;
    }

    public function getCif() {
        return $this->cif;
    }

    public function setCif(string $cif) {
        $this->cif = $cif;
        
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

    public function getPhone() {
        return $this->phone;
    }

    public function setPhone(?int $phone) {
        $this->phone = $phone;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail(?string $email) {
        $this->email = $email;
    }  
    
    /**
    *  METHODS
    *  PRIVATES METHODS
   */ 

   private function querySuppliers() {

       require_once 'libs/QueryBuild.php';
       $build = new QueryBuild();

       $build->setSelect("_id, tradename, business_name, cif, phone, email, created");
       $build->setFrom($this->table);
       $build->setSearch("$this->table.tradename LIKE :search OR $this->table.business_name LIKE :search OR $this->table.cif LIKE :search OR $this->table.email LIKE :search");
           
       return $build->query();
   }

    //  PUBLICS METHODS

    public function create() {
        try {
            
            $existCif = $this->getBy('cif', $this->getCif() );
            
            if($existCif) {
                return 'El cif "'.$this->getCif().'" ya está registrado.';
            }

            $existBusinessName = $this->getBy('business_name', $this->getbusinessName() );
        
            if($existBusinessName) {
                return 'La razón social "'.$this->getbusinessName().'" ya está registrada.';   
            }

            $new = $this->connect()->prepare(
                "INSERT 
                INTO $this->table 
                (tradename, 
                business_name, 
                cif, 
                _id_country, 
                province, 
                locality,
                postal_code,
                address,
                phone,
                email) 
                VALUES (:tradename, 
                :business, 
                :cif, 
                :country, 
                :province, 
                :locality, 
                :postalCode, 
                :address, 
                :phone, 
                :email)"
            );

            $new->bindValue(':tradename', $this->getTradename(), PDO::PARAM_STR);
            $new->bindValue(':business', $this->getbusinessName(), PDO::PARAM_STR);
            $new->bindValue(':cif', $this->getCif(), PDO::PARAM_STR);
            $new->bindValue(':country', $this->getIdCountry(), PDO::PARAM_INT);
            $new->bindValue(':province', $this->getProvince(), PDO::PARAM_STR);
            $new->bindValue(':locality', $this->getLocality(), PDO::PARAM_STR);
            $new->bindValue(':postalCode', $this->getPostalCode(), PDO::PARAM_INT);
            $new->bindValue(':address', $this->getAddress(), PDO::PARAM_STR);
            $new->bindValue(':phone', $this->getPhone(), PDO::PARAM_INT);
            $new->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);

            if($new->execute() ) {
                return 'Proveedor registrado.';
            }else {
                return 'Hubo un error al intentar registrar, intentalo mas tarde';
            }

        }catch(PDOexception $e) {
            return $e->getMessage();
        }
    }

    public function read() {
        return $this->getById($this->getId() );
    }

    public function readAll() {
        return $this->getAllQuery($this->querySuppliers() );
    }

    public function update() {
        try {
            
            $existCif = $this->getBy('cif', $this->getCif() );
            
            if($existCif && $existCif['_id'] != $this->getId() ) {
                return 'El cif "'.$this->getCif().'" ya está registrado.';
            }

            $existBusinessName = $this->getBy('business_name', $this->getbusinessName() );
        
            if($existBusinessName && $existBusinessName['_id'] != $this->getId() ) {
                return 'La razón social "'.$this->getbusinessName().'" ya está registrada.';   
            }

            $update = $this->connect()->prepare(
                "UPDATE 
                $this->table 
                SET 
                tradename = :tradename,
                business_name = :business,
                cif = :cif,
                _id_country = :country, 
                province = :province,
                locality = :locality,
                postal_code = :postalCode,
                address = :address,
                phone = :phone,
                email = :email
                WHERE _id = :id"
            );

            $update->bindValue(':tradename', $this->getTradename(), PDO::PARAM_STR);
            $update->bindValue(':business', $this->getbusinessName(), PDO::PARAM_STR);
            $update->bindValue(':cif', $this->getCif(), PDO::PARAM_STR);
            $update->bindValue(':country', $this->getIdCountry(), PDO::PARAM_INT);
            $update->bindValue(':province', $this->getProvince(), PDO::PARAM_STR);
            $update->bindValue(':locality', $this->getLocality(), PDO::PARAM_STR);
            $update->bindValue(':postalCode', $this->getPostalCode(), PDO::PARAM_INT);
            $update->bindValue(':address', $this->getAddress(), PDO::PARAM_STR);
            $update->bindValue(':phone', $this->getPhone(), PDO::PARAM_INT);
            $update->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);

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

    // OTHERS METHODS

    public function paginations() {
        return $this->pagination('paginations', $this->querySuppliers() );
    }

    public function getCountries() {
        return $this->getAllOtherTable('countries');
    }

}

?>
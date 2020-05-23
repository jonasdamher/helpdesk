<?php 


class CompanyModel extends BaseModel implements Crud {

    private int $id;
    private string $tradename;
    private string $businessName;
    private string $cif;
    private int $idStatus;

    public function __construct($conn) {
        parent::__construct();
        $this->conn = $conn;
        $this->table = 'companies';
        $this->setSchema('CompanySchema');
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
    
    public function getIdStatus() {
        return $this->idStatus;
    }

    public function setIdStatus(int $idStatus) {
        $this->idStatus = $idStatus;
    }

    /**
     *  METHODS
     *  PRIVATES METHODS
    */ 

    private function queryCompany() {

        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect("$this->table._id, $this->table.tradename, $this->table.business_name, $this->table.cif, $this->table._id_status, $this->table.created, comp_status.status");
        $build->setFrom($this->table);
        $build->setInner("INNER JOIN comp_status ON $this->table._id_status = comp_status._id");
        $build->setSearch("$this->table.tradename LIKE :search OR $this->table.business_name LIKE :search OR $this->table.cif LIKE :search");
            
        return $build->query();
    }

    //  PUBLICS METHODS
    public function read() {
        return $this->getById($this->getId() );
    }

    public function readAll() {
        return $this->getAllQuery($this->queryCompany() );
    }

    public function create() {
        try {
            
            $existCif = $this->getBy('cif', $this->getCif() );
            
            if(!($existCif) ) {

                $existBusinessName = $this->getBy('business_name', $this->getbusinessName() );
            
                if(!($existBusinessName) ) {

                    $userNew = $this->connect()->prepare(
                        "INSERT 
                        INTO $this->table 
                        (tradename, 
                        business_name, 
                        cif, 
                        _id_status) 
                        VALUES (:tradename, :business, :cif, :idStatus)"
                    );

                    $userNew->bindValue(':tradename', $this->getTradename(), PDO::PARAM_STR);
                    $userNew->bindValue(':business', $this->getbusinessName(), PDO::PARAM_STR);
                    $userNew->bindValue(':cif', $this->getCif(), PDO::PARAM_STR);
                    $userNew->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_STR);
                    
                    if($userNew->execute() ) {
                        return 'Empresa registrada.';
                    }else {
                        return 'Hubo un error al registrar la empresa, intentalo mas tarde';
                    }
                    
                }else {
                    return 'La razón social "'.$this->getbusinessName().'" ya está registrada.';   
                }

            }else {
                return 'El cif "'.$this->getCif().'" ya está registrado.';
            }

        }catch(PDOexception $e) {
            
            return $e->getMessage();

        }
    }

    public function update() {
        try {
               
            $existCif = $this->getBy('cif', $this->getCif() );

            if(!($existCif && $existCif['_id'] != $this->getId() ) ) {

                $existBusinessName = $this->getBy('business_name', $this->getbusinessName() );
                
                if(!($existBusinessName && $existBusinessName['_id'] != $this->getId() ) ) {
             
                    $update = $this->connect()->prepare(
                        "UPDATE 
                        $this->table 
                        SET 
                        tradename = :tradename, 
                        business_name = :business, 
                        cif = :cif, 
                        _id_status = :status
                        WHERE _id = :id"
                    );
                    
                    $update->bindValue(':tradename', $this->getTradename(), PDO::PARAM_STR);
                    $update->bindValue(':business', $this->getbusinessName(), PDO::PARAM_STR);
                    $update->bindValue(':cif', $this->getCif(), PDO::PARAM_STR);
                    $update->bindValue(':status', $this->getIdStatus(), PDO::PARAM_INT);
                    $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

                    if($update->execute() ) {

                        header('Location: '.url_base.$_GET['controller'].'/'.$_GET['action'].'/'.$_GET['id'].'?status=1');

                    }else {
                        header('Location: '.url_base.$_GET['controller'].'/'.$_GET['action'].'/'.$_GET['id'].'?status=0');
                    }
                }
              
            }else {
                return 'El correo "'.$this->getEmail().'" ya está registrado.';
            }
           

        }catch(PDOexception $e) {
            
            return $e->getMessage();
        }
    }

    public function delete() {

    }

    // OTHERS METHODS

    public function paginations() {
        return $this->pagination('paginations', $this->queryCompany() );
    }

    public function getStatus() {
        return $this->getAllOtherTable('comp_status');
    }
}

?>
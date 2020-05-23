<?php

class ContactPointOfSaleModel extends BaseModel {

    private int $id;
    private string $name;
    private ?int $phone;
    private ?string $email;
    private int $idPto;

    public function __construct($conn) {
        parent::__construct();
        $this->conn = $conn;
        $this->table = 'pto_contacts';
        $this->setSchema('ContactPointOfSaleSchema');
    }

    // GET & SET

    public function getId() {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName(string $name) {
        $this->name = $name;
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
 
    public function getIdPto() {
        return $this->idPto;
    }

    public function setIdPto(int $idPto) {
        $this->idPto = $idPto;
    }
    
    /**
     *  METHODS
     *  PRIVATES METHODS
    */ 

    private function queryContact() {
 
        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect('_id, name, phone, email');
        $build->setFrom('pto_contacts');
        $build->setWhere('_id_pto = :id');
        $build->setById($this->getIdPto() );

        return $build->query();
    }

    //  PUBLICS METHODS

    public function create() {
        try {

            $new = $this->connect()->prepare(
                "INSERT 
                INTO $this->table 
                    (name, 
                    phone, 
                    email,
                    _id_pto) 
                VALUES 
                    (:name, 
                    :phone, 
                    :email,
                    :idPto)"
            );

            $new->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $new->bindValue(':phone', $this->getPhone(), PDO::PARAM_INT);
            $new->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
            $new->bindValue(':idPto', $this->getIdPto(), PDO::PARAM_INT);

            return ($new->execute() ) ? ['valid' => true, 'id' => $this->connect()->lastInsertId()] : ['valid' => false];

        }catch(PDOexception $e) {
            return ['valid'=> false, 'error' => $e->getMessage()];
        }
    }

    public function read(){
        return $this->getById($this->getId() );
    }

    public function readAll() {
        return $this->getAllQuery($this->queryContact() );
    }

    public function update() {
        try {

            $update = $this->connect()->prepare(
                "UPDATE $this->table SET
                name = :name, 
                phone = :phone, 
                email = :email
                WHERE _id = :id");

            $update->bindValue(':name', $this->getName(), PDO::PARAM_STR);
            $update->bindValue(':phone', $this->getPhone(), PDO::PARAM_INT);
            $update->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

            return ($update->execute() ) ? ['valid' => true] : ['valid' => false];

        }catch(PDOexception $e) {
            return ['valid'=> false, 'error' => $e->getMessage()];
        }
    }

    public function delete() {
        return ($this->deleteById($this->getId() ) ) ? ['valid' => true] : ['valid' => false];
    }

    // OTHERS METHODS
  
    public function paginations() {
        return $this->pagination('paginations', $this->queryContact() );
    }
}

?>
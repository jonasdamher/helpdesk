<?php 

class ArticleModel extends BaseModel {

    private int $id;
    private int $idArticle;
    private int $idStatus;
    private int $idBorrowed;
    private ?string $serial;
    private ?string $code;
    private ?string $observations;

    public function __construct($conn) {
        parent::__construct();
        $this->conn = $conn;
        $this->table = 'articles_only';
        $this->setSchema('ArticleSchema');
    }

    // GET & SET

    public function getId() {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getIdStatus() {
        return $this->idStatus;
    }   

    public function setIdStatus(int $idStatus) {
        $this->idStatus = $idStatus;
    }

    public function getSerial() {
        return $this->serial;
    }   

    public function setSerial(?string $serial) {
        $this->serial = $serial;
    }

    public function getCode() {
        return $this->code;
    }   

    public function setCode(?string $code) {
        $this->code = $code;
    }
    
    public function getIdArticle() {
        return $this->idArticle;
    }   

    public function setIdArticle(int $idArticle) {
        $this->idArticle = $idArticle;
    }

    public function getIdBorrowed() {
        return $this->idBorrowed;
    }   

    public function setIdBorrowed(int $idBorrowed) {
        $this->idBorrowed = $idBorrowed;
    }   

    public function getObservations() {
        return $this->observations;
    }   

    public function setObservations(?string $observations) {
        $this->observations = $observations;
    }   

   /**
     *  METHODS
     *  PRIVATES METHODS
    */ 
        
    private function queryArticlesOnly() {
 
        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect("
        $this->table._id, $this->table.serial, $this->table.observations, $this->table.created, $this->table.code, 
        art_status.status, art_borrowed_status.status as statusBorrowed,
        points_of_sales._id as idPointOfSale, points_of_sales.name,
        incidences._id as idIncidence");
        $build->setFrom("$this->table");
        $build->setInner("
        INNER JOIN art_status ON $this->table._id_status = art_status._id
        INNER JOIN art_borrowed_status ON $this->table._id_borrowed_status = art_borrowed_status._id
        LEFT JOIN articles_borrowed_point_of_sales ON $this->table._id_borrowed_status = 2 AND $this->table._id = articles_borrowed_point_of_sales._id_article_only
        LEFT JOIN points_of_sales ON articles_borrowed_point_of_sales._id_pto = points_of_sales._id
        LEFT JOIN incidences ON articles_borrowed_point_of_sales._id_incidence = incidences._id AND incidences._id_status != 3");
        $build->setWhere("$this->table._id_article = :id ");
        $build->setById($this->getIdArticle() );

        return $build->query();
    }

    // PUBLICS METHODS

    public function create() {
        try {

            $new = $this->connect()->prepare(
                "INSERT 
                INTO $this->table 
                (
                _id_article,
                serial,
                code,
                observations,
                _id_status) 
                VALUES (
                :idArticle,
                :serial,
                :code,
                :observations,
                :idStatus        
                )"
            );

            $new->bindValue(':idArticle', $this->getIdArticle(), PDO::PARAM_INT);
            $new->bindValue(':serial', $this->getSerial(), PDO::PARAM_STR);
            $new->bindValue(':code', $this->getCode(), PDO::PARAM_STR);
            $new->bindValue(':observations', $this->getObservations(), PDO::PARAM_STR);
            $new->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_INT);

            return ($new->execute() ) ? ['valid' => true, 'id' => $this->connect()->lastInsertId()] : ['valid' => false];
            
        }catch(PDOexception $e) {
            return ['valid'=> false, 'error' => $e->getMessage()];
        }
    }

    public function read() {
        try {

            $get = $this->connect()->prepare(
                "SELECT
                $this->table._id,
                $this->table._id_article,
                $this->table.serial,
                $this->table.code,
                $this->table.observations,
                $this->table._id_status,
                $this->table.created,
                art_status.status,
                art_borrowed_status.status as statusBorrowed
                FROM
                $this->table
                INNER JOIN
                art_status
                ON $this->table._id_status = art_status._id
                INNER JOIN
                art_borrowed_status
                ON $this->table._id_borrowed_status = art_borrowed_status._id
                WHERE $this->table._id = :id");

            $get->bindValue(':id', $this->getId(), PDO::PARAM_INT);

            return ($get->execute() ) ? ['valid' => true, 'read' => $get->fetch(PDO::FETCH_ASSOC)] : ['valid' => false];
            
        }catch(PDOexception $e) {
            return ['valid'=> false, 'error' => $e->getMessage()];
        }
    }

    public function readAll() {
        return $this->getAllQuery($this->queryArticlesOnly() );
    }

    public function update() {
        try {

            $update = $this->connect()->prepare(
                "UPDATE $this->table SET
                serial = :serial, 
                code = :code, 
                observations = :observations,
                _id_status = :idStatus
                WHERE _id = :id");

            $update->bindValue(':serial', $this->getSerial(), PDO::PARAM_STR);
            $update->bindValue(':code', $this->getCode(), PDO::PARAM_STR);
            $update->bindValue(':observations', $this->getObservations(), PDO::PARAM_STR);
            $update->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_INT);

            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

            return ($update->execute() ) ? ['valid' => true] : ['valid' => false];

        }catch(PDOexception $e) {
            return ['valid'=> false, 'error' => $e->getMessage()];
        }
    }

    public function delete() {

        $article = $this->getById($this->getId() );

        if($article['_id_borrowed_status'] == 2 ) {
            return ['valid' => false, 'error' => 'El artículo está en prestamo en una incidencia.'];
        }

        return ($this->deleteById($this->getId() )) ? ['valid' => true] : ['valid' => false, 'error' => 'Hubo un error al intentar eliminar el artículo.'];
    }

    // OTHERS METHODS

    public function paginations() {
        return $this->pagination('paginations', $this->queryArticlesOnly() );
    }

    public function getStatus() {
        return $this->getAllOtherTable('art_status');
    }

    public function getNotBorrowed() {
        try {

            $get = $this->connect()->prepare(
                "SELECT
                $this->table._id,
                $this->table.serial,
                articles.name
                FROM
                $this->table
                INNER JOIN
                articles
                ON $this->table._id_article = articles._id
                WHERE $this->table._id_status = :idStatus");

            $get->bindValue(':idStatus', 1, PDO::PARAM_INT);

            $get->execute();
            $result = $get->fetchAll(PDO::FETCH_ASSOC);
            $get = null;

            return $result;
        }catch(PDOexception $e) {
            return $e->getMessage();
        }
    }

    public function updateBorrowed() {
        try {

            $update = $this->connect()->prepare(
                "UPDATE $this->table SET
                _id_borrowed_status = :idBorrowed
                WHERE $this->table._id = :id");

            $update->bindValue(':idBorrowed', $this->getIdBorrowed(), PDO::PARAM_INT);
            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);
            
            return ($update->execute() ) ? ['valid' => true] : ['valid' => false];
        }catch(PDOexception $e) {
            return ['valid' => false, 'error' =>  $e->getMessage()];
        }
    }
    public function totalBorrowed() {
        try {

            $get = $this->connect()->prepare(
                "SELECT art_borrowed_status.status, COUNT(*) as total
                FROM $this->table
                INNER JOIN art_borrowed_status
                ON $this->table._id_borrowed_status = art_borrowed_status._id 
                WHERE $this->table._id_article = :id
                GROUP BY art_borrowed_status.status");

            $get->bindValue(':id', $this->getIdArticle(), PDO::PARAM_INT);
            $get->execute();
            
            $result = $get->fetchAll(PDO::FETCH_ASSOC);
            
            $get = null;
            
            return $result;

        }catch(PDOexception $e) {
            return $e->getMessage();
        }
    }
}

?>
<?php 

declare(strict_types=1);

class IncidenceModel extends BaseModel {

    private int $id;
    private string $subject;
    private ?string $description;
    private int $idPtoOfSales;
    private ?int $idAttended = null;
    private int $idPriority;
    private int $idStatus;
    private int $idType;

    public function __construct() {
         $this->table = 'incidences';
     }

    // GET & SET

    public function getId() {
        return $this->id;
    }

    public function setId(int $id) {
        $this->id = $id;
    }

    public function getSubject() {
        return $this->subject;
    }

    public function setSubject(string $subject) {
        $this->subject = $subject;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription(?string $description) {
        $this->description = $description;
    }

    public function getIdPtoOfSales() {
        return $this->idPtoOfSales;
    }

    public function setIdPtoOfSales(int $idPtoOfSales) {
        $this->idPtoOfSales = $idPtoOfSales;
    }
    public function getIdAttended() {
        return $this->idAttended;
    }

    public function setIdAttended(?int $idAttended) {
        $this->idAttended = $idAttended;
    }

    public function getIdPriority() {
        return $this->idPriority;
    }

    public function setIdPriority(int $idPriority) {
        $this->idPriority = $idPriority;
    }

    public function getIdStatus() {
        return $this->idStatus;
    }

    public function setIdStatus(int $idStatus) {
        $this->idStatus = $idStatus;
    }

    public function getIdType() {
        return $this->idType;
    }

    public function setIdType(int $idType) {
        $this->idType = $idType;
    }

    /**
     *  METHODS
     *  PRIVATES METHODS
    */ 

    private function queryIncidence() {

        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect("
        $this->table._id, 
        $this->table.subject, 
        $this->table.description, 
        $this->table.created,
        $this->table._id_pto_of_sales,
        $this->table._id_priority,
        points_of_sales.name as point_of_sale,
        points_of_sales.company_code,
        users.name,
        users.lastname,
        inc_priorities.priority,
        inc_status.status");
        $build->setFrom($this->table);
        $build->setInner("INNER JOIN
        points_of_sales
        ON $this->table._id_pto_of_sales = points_of_sales._id 
        INNER JOIN
        users
        ON $this->table._id_attended = users._id 
        INNER JOIN
        inc_priorities
        ON $this->table._id_priority = inc_priorities._id 
        INNER JOIN
        inc_status
        ON $this->table._id_status = inc_status._id");

        if(!is_null($this->getIdAttended() ) ) {
            $build->setWhere("$this->table._id_attended = :id AND $this->table._id_status != 3");
            $build->setById($this->getIdAttended());
        }

        $build->setSearch(
            "$this->table.subject LIKE :search OR points_of_sales.name LIKE :search OR users.name 
            LIKE :search OR inc_priorities.priority LIKE :search OR inc_status.status LIKE :search");
    
        return $build->query();
    }

    //  PUBLICS METHODS

    public function create() {
        try {

            $new = Database::connect()->prepare(
                "INSERT INTO $this->table 
                (subject, description, _id_pto_of_sales, _id_user_created, _id_attended, _id_priority, _id_status, _id_type) 
                VALUES (:subject, :description, :idPto, :idUser, :idUserAttended, :idPriority, :idStatus, :idType)");

            $new->bindValue(':subject', $this->getSubject(), PDO::PARAM_STR);
            $new->bindValue(':description', $this->getDescription(), PDO::PARAM_STR);
            $new->bindValue(':idPto', $this->getIdPtoOfSales(), PDO::PARAM_INT);
            $new->bindValue(':idUser',  $_SESSION['user_init'], PDO::PARAM_INT);
            $new->bindValue(':idUserAttended', $this->getIdAttended(), PDO::PARAM_INT);
            $new->bindValue(':idPriority', $this->getIdPriority(), PDO::PARAM_INT);
            $new->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_INT);
            $new->bindValue(':idType', $this->getIdType(), PDO::PARAM_INT);
            
            if($new->execute() ) {
                return 'Incidencia registrada.';
            }else {
                return 'Hubo un error al intentar registrar, intentelo mas tarde.';
            }

        }catch(PDOexception $e) {
            return $e->getMessage();
        }
    }

    public function read() {
        return $this->getById($this->getId() );
    }
 
    public function readAll() {
        return $this->getAllQuery($this->queryIncidence() );
    }

    public function verifyArticlesBorrowed() {
        try {

            $get = Database::connect()->prepare(
                "SELECT
                articles_borrowed_point_of_sales
                FROM
                INNER JOIN
                articles_only
                ON articles_borrowed_point_of_sales._id_article_only = articles_only._id
                WHERE articles_borrowed_point_of_sales._id_incidence = :id 
                AND articles_only._id_borrowed_status = 2");

            $get->bindValue(':id', $this->getId(), PDO::PARAM_INT);

            $get->execute();

            return $get->fetchAll(PDO::FETCH_ASSOC);
            
        }catch(PDOexception $e) {
            return ['valid'=> false, 'error' => $e->getMessage()];
        }
    }

    public function update() {
        try {

            $incidence = $this->read();
            $dateSql = '';

            if($this->getIdStatus() == 3 && $incidence['_id_status'] != 3){
                $date = date("Y-m-d H:i:s");
                $dateSql = ', finish_date = :date';

                $notArticleBorrowed = $this->verifyArticlesBorrowed();

                if($notArticleBorrowed){
                    return 'No se puede finalizar hasta que todos lo artículos en préstamo sean devueltos.';
                }

            }

            $update = Database::connect()->prepare(
                "UPDATE $this->table SET 
                subject = :subject,
                description = :description, 
                _id_pto_of_sales = :idPto,  
                _id_attended = :idUserAttended, 
                _id_priority = :idPriority, 
                _id_status = :idStatus,
                _id_type = :idType
                $dateSql
                WHERE _id = :id");

            $update->bindValue(':subject', $this->getSubject(), PDO::PARAM_STR);
            $update->bindValue(':description', $this->getDescription(), PDO::PARAM_STR);
            $update->bindValue(':idPto', $this->getIdPtoOfSales(), PDO::PARAM_INT);
            $update->bindValue(':idUserAttended', $this->getIdAttended(), PDO::PARAM_INT);
            $update->bindValue(':idPriority', $this->getIdPriority(), PDO::PARAM_INT);
            $update->bindValue(':idStatus', $this->getIdStatus(), PDO::PARAM_INT);
            $update->bindValue(':idType', $this->getIdType(), PDO::PARAM_INT);
            if($this->getIdStatus() == 3 && $incidence['_id_status'] != 3){
                $update->bindValue(':date', $date, PDO::PARAM_STR);
            }
            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

            if($update->execute() ) {
                header('Location: '.URL_BASE.$_GET['controller'].'/'.$_GET['action'].'/'.$_GET['id'].'?status=1');
            }else {
                header('Location: '.URL_BASE.$_GET['controller'].'/'.$_GET['action'].'/'.$_GET['id'].'?status=0');
            }
        }catch(PDOexception $e) {
            return $e->getMessage();
        }
    }

    public function getDetails() {
        try{

            $get = Database::connect()->prepare(
                "SELECT 
                $this->table._id, 
                $this->table.subject, 
                $this->table.description, 
                $this->table.created,
                $this->table._id_pto_of_sales,
                $this->table.finish_date,
                points_of_sales.name as point_of_sale,
                points_of_sales.company_code,
                userCreated.name as name_created,
                userCreated.lastname as lastname_created,
                userAttended.name as name_attended,
                userAttended.lastname as lastname_attended,
                inc_priorities.priority,
                inc_status.status,
                inc_types_incidences.type
                FROM $this->table
                INNER JOIN points_of_sales
                ON $this->table._id_pto_of_sales = points_of_sales._id
                INNER JOIN users as userCreated
                ON $this->table._id_user_created = userCreated._id
                INNER JOIN users as userAttended
                ON $this->table._id_attended = userAttended._id
                INNER JOIN inc_priorities
                ON $this->table._id_priority = inc_priorities._id 
                INNER JOIN inc_status
                ON $this->table._id_status = inc_status._id
                INNER JOIN inc_types_incidences
                ON $this->table._id_type = inc_types_incidences._id
                WHERE $this->table._id = :id");

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
        return $this->pagination('paginations', $this->queryIncidence() );
    }

    public function getPointOfSales() {
        return $this->getAllOtherTable('points_of_sales');
    }

    public function getUsers() {
        return $this->getAllOtherTable('users');
    }

    public function getPriorities() {
        return $this->getAllOtherTable('inc_priorities');
    }

    public function getStatus() {
        $family = $this->getAllOtherTable('inc_status_family');
        $status = $this->getAllOtherTable('inc_status');
        return ['family' => $family, 'status' => $status];
    }

    public function getType() {
        return $this->getAllOtherTable('inc_types_incidences');
    }
}

?>
<?php 

require_once 'config/Database.php';
require_once 'models/interface/Crud.php';

class BaseModel {

    protected $conn;
    protected string $table;
    
    private array $schema;

    public function __construct() {}

    protected function setSchema($schema) {
        $this->schema = include 'models/schema/'.$schema.'.php';
    }

    // CONNECT DB

    protected function connect() {
        return $this->conn;
    }

    // FINAL CONNECT DB

    // METHOS PRIVATES

    private function tableTotalRows($query) {
        
        $from = $query['from'];
        $inners = $query['inners'];
        $where = $query['where'];
        
        $get = $this->connect()->prepare("SELECT COUNT(*) FROM $from $inners $where");
              
        if(array_key_exists('search', $query['exec']) && !is_null($query['exec']['search']) ) {

            $get->bindValue(':search', $query['exec']['search'], PDO::PARAM_STR);
        }
        
        if(array_key_exists('filter', $query['exec']) && !is_null($query['exec']['filter']) ) {
        
            $get->bindValue(':filter', $query['exec']['filter'], PDO::PARAM_STR);
        }

        if(array_key_exists('id', $query['exec']) && !is_null($query['exec']['id']) ) {
        
            $get->bindValue(':id', $query['exec']['id'], PDO::PARAM_INT);
        }

        $get->execute();
            
        return $get->fetchColumn();
    }

    // LIBS IN DIR libs/

    protected function pagination(string $method, array $query) {
        
        $rows = $this->tableTotalRows($query);
        require_once 'libs/Pagination.php';
        $pagination = new Pagination($rows);
        
        return $pagination->$method();
    }

    protected function Image(string $dir, $imageName, $type = 'new') {
        require_once 'libs/Image.php';
        $image = new Image($dir, $imageName, $type);
        return $image->upload();
    }

    public function formValidate(string $type = 'all') {
        require_once 'libs/Validator.php';
        $validator = new Validator($this->schema, $type);
        return $validator->schemaCheck();
    }

    // FINAL LIBS

    // METHODS CURRENT TABLE

    // GET BY SEARCH, FILTER, ORDER AND PER PAGE
    
    protected function getAllQuery(array $query) {
        try{

            $select = $query['select'];
            $from = $query['from'];
            $inners = $query['inners'];
            $where = $query['where'];
            $order = $query['order'];
            $pagination = $this->pagination('page', $query);

            $get = $this->connect()->prepare("SELECT $select FROM $from $inners $where ORDER BY $order LIMIT :offset, :limit");
            
            if(array_key_exists('search', $query['exec']) && !is_null($query['exec']['search']) ) {

                $get->bindValue(':search', $query['exec']['search'], PDO::PARAM_STR);
            }
            
            if(array_key_exists('filter', $query['exec']) && !is_null($query['exec']['filter']) ) {
            
                $get->bindValue(':filter', $query['exec']['filter'], PDO::PARAM_STR);
            }
            
            if(array_key_exists('id', $query['exec']) && !is_null($query['exec']['id']) ) {
        
                $get->bindValue(':id', $query['exec']['id'], PDO::PARAM_INT);
            }

            $get->bindValue(':offset', $pagination['offset'], PDO::PARAM_INT);
              
            $get->bindValue(':limit', $pagination['limit'], PDO::PARAM_INT);

            $get->execute();
            
            $result = $get->fetchAll(PDO::FETCH_ASSOC);
            
            $get = null;
            

            return $result;

        }catch(PDOexception $e){
            return $e->getMessage();
        }
    }

    // GET ALL
    protected function getAll() {
        try{
            $get = $this->connect()->prepare("SELECT * FROM $this->table");
            $get->execute();
            $result = $get->fetchAll(PDO::FETCH_ASSOC);
            
            $get = null;
            return $result;
        }catch(PDOexception $e){
            return $e->getMessage();
        }
    }

    // GET ALL BY FIELD OR ID

    protected function getAllOtherById($where, $field) {
        try{

            $get = $this->connect()->prepare("SELECT * FROM $this->table WHERE $where = :id");

            $get->BindValue(':id', $field, PDO::PARAM_INT);

            $get->execute();
            $result = $get->fetchAll(PDO::FETCH_ASSOC);
            
            $get = null;
            

            return $result;

        }catch(PDOexception $e){
            return $e->getMessage();
        }
    }

    // GET BY FIELD

    protected function getBy(string $where, string $field) {
        try{
            $get = $this->connect()->prepare("SELECT * FROM $this->table WHERE $where = :where");
            
            $get->bindValue(':where', $field, PDO::PARAM_STR);
            $get->execute();

            $result = $get->fetch(PDO::FETCH_ASSOC);
            $get = null;

            return $result;
        }catch(PDOexception $e){
            return $e->getMessage();
        }
    }
    
    // GET BY ID

    protected function getById(int $id) {
        try{
            $get = $this->connect()->prepare("SELECT * FROM $this->table WHERE _id = :id");
            $get->bindValue(':id', $id, PDO::PARAM_INT);
            $get->execute();

            $result = $get->fetch(PDO::FETCH_ASSOC);
            $get = null;

            return $result;
        }catch(PDOexception $e){
            return $e->getMessage();
        }
    }

    // DELETE
    
    protected function deleteById(int $id) {
        try {
            $delete = $this->connect()->prepare("DELETE FROM $this->table WHERE _id = :id");
            $delete->bindValue(':id', $id, PDO::PARAM_INT);

            return $delete->execute();
        }catch(PDOexception $e){
            return $e->getMessage();
        }
    }

    // FINAL CURRENT TABLE

    // METHODS OTHER TABLES
    // GET ALL BY FIELD

    protected function getByOtherTable(string $table, string $where, string $field) {
        try{
            $get = $this->connect()->prepare("SELECT * FROM $table WHERE $where = :where");
            $get->bindValue(':where', $field, PDO::PARAM_STR);
            $get->execute();
            $result = $get->fetch(PDO::FETCH_ASSOC);
            $get = null;
            
            return $result;
        }catch(PDOexception $e){
            return $e->getMessage();
        }
    }

    // GET ALL

    protected function getAllOtherTable(string $table) {
        try{
            $get = $this->connect()->prepare("SELECT * FROM $table");
            $get->execute();
            $result = $get->fetchAll(PDO::FETCH_ASSOC);
            $get = null;

            return $result;
        }catch(PDOexception $e){
            return $e->getMessage();
        }
    }

}

?>
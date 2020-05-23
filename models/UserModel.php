<?php 

class UserModel extends BaseModel implements Crud {

    private int $id;
    private string $name;
    private string $lastname;
    private string $email;
    private string $password;
    private int $idRol;
    private int $idStatus;
    private $image;

    public function __construct($conn) {
        parent::__construct();
        $this->conn = $conn;
        $this->table = 'users';
        $this->setSchema('UserSchema');
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

    public function getLastname() {
        return $this->lastname;
    }

    public function setLastname(string $lastname) {
        $this->lastname = $lastname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail(string $email) {
        $this->email = $email;
        
    }
    
    public function getPassword() {
        return $this->password;
    }

    public function setPassword(string $password) {
        $this->password = $password;
    }

    public function getIdRol() {
        return $this->idRol;
    }

    public function setIdRol(int $id_rol) {
        $this->idRol = $id_rol;
    }

    public function getIdStatus() {
        return $this->idStatus;
    }

    public function setIdStatus(int $id_status) {
        $this->idStatus = $id_status;
    }

    public function getImage() {
        return $this->image;
    }

    public function setImage($image) {
        $this->image = $image;
    }

    /**
     *  METHODS
     *  PRIVATES METHODS
    */ 

    private function queryUsers() {

        require_once 'libs/QueryBuild.php';
        $build = new QueryBuild();

        $build->setSelect("$this->table._id, $this->table.name, $this->table.lastname, $this->table.email, $this->table._id_rol, $this->table._id_status, $this->table.image, $this->table.created, usr_rol.rol, usr_status.status");
        $build->setFrom($this->table);
        $build->setInner("INNER JOIN usr_rol ON $this->table._id_rol = usr_rol._id INNER JOIN usr_status ON $this->table._id_status = usr_status._id");
        $build->setSearch("$this->table.name LIKE :search OR $this->table.lastname LIKE :search OR $this->table.email LIKE :search");
            
        return $build->query();
    }

    private function _passHas() {
        return password_hash($this->getPassword(), PASSWORD_DEFAULT);
    }

    private function _sessionUser($userData) {

        $_SESSION['user_init']  = $userData['_id'];
        $_SESSION['name']       = $userData['name'];
        $_SESSION['lastname']   = $userData['lastname'];
        $_SESSION['email']      = $userData['email'];
        $_SESSION['rol']        = $userData['_id_rol'];
        $_SESSION['image']      = $userData['image'];
    }

    //  PUBLICS METHODS
    
    public function create() {
        try {
            
            $existEmail = $this->getBy('email', $this->getEmail() );
            
            if($existEmail) {
                return 'El correo "'.$this->getEmail().'" ya está registrado.';
            }

            $imageUpload = $this->Image('users', $this->getImage() );
            
            if($imageUpload['valid']) {

                $userNew = $this->connect()->prepare(
                    "INSERT 
                    INTO $this->table 
                    (name, 
                    lastname, 
                    email, 
                    password, 
                    _id_status, 
                    _id_rol,
                    image) 
                    VALUES (:name, :lastname, :email, :password, :idStatus, :idRol, :image)"
                );

                $userNew->bindValue(':name',$this->getName(), PDO::PARAM_STR);
                $userNew->bindValue(':lastname',$this->getLastname(), PDO::PARAM_STR);
                $userNew->bindValue(':email',$this->getEmail(), PDO::PARAM_STR);
                $userNew->bindValue(':password',$this->_passHas(), PDO::PARAM_STR);
                $userNew->bindValue(':idStatus',$this->getIdStatus(), PDO::PARAM_INT);
                $userNew->bindValue(':idRol',$this->getIdRol(), PDO::PARAM_INT);
                $userNew->bindValue(':image', $imageUpload['filename'], PDO::PARAM_STR);

                if($userNew->execute() ) {

                    header('Location: '.url_base.$_GET['controller'].'/'.$_GET['action'].'?status=1');

                }else {

                    header('Location: '.url_base.$_GET['controller'].'/'.$_GET['action'].'?status=0');
                }

            }else {
                return $imageUpload['errors'];
            }
         

        }catch(PDOexception $e) {
            
            return $e->getMessage();

        }
    }

    public function read() {
        try {

            $get = $this->connect()->prepare(
                "SELECT
                $this->table._id,
                $this->table.name,
                $this->table.lastname,
                $this->table.email,
                $this->table.password,
                $this->table._id_rol,
                $this->table._id_status,
                $this->table.created,
                $this->table.image,
                usr_status.status,
                usr_rol.rol
                FROM
                $this->table
                INNER JOIN
                usr_status
                ON $this->table._id_status = usr_status._id
                INNER JOIN
                usr_rol
                ON $this->table._id_rol = usr_rol._id
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

    public function readAll() {
        return $this->getAllQuery($this->queryUsers() );
    }

    public function update() {
        try {
            
            $existEmail = $this->getBy('email', $this->getEmail() );
            
            if($existEmail && $existEmail['_id'] != $this->getId() ) {
                return 'El correo "'.$this->getEmail().'" ya está registrado.';
            }

            $user = $this->read();
            
            $imageUpload = $this->Image('users', ['CurrentimageName' => $user['image'], 'updateImage' => $this->getImage()], 'update');
            
            if($imageUpload['valid']) {

                $image = !is_null($imageUpload['filename']) ? ', image = :image' : '';
                
                $update = $this->connect()->prepare(
                    "UPDATE 
                    $this->table 
                    SET 
                    name = :name, 
                    lastname = :lastname, 
                    email = :email, 
                    _id_rol = :rol, 
                    _id_status = :status
                    $image
                    WHERE _id = :id"
                );
                
                $update->bindValue(':name', $this->getName(), PDO::PARAM_STR);
                $update->bindValue(':lastname', $this->getLastname(), PDO::PARAM_STR);
                $update->bindValue(':email', $this->getEmail(), PDO::PARAM_STR);
                $update->bindValue(':rol', $this->getIdRol(), PDO::PARAM_INT);
                $update->bindValue(':status', $this->getIdStatus(), PDO::PARAM_INT);

                if(!is_null($imageUpload['filename']) ) {

                    $update->bindValue(':image', $imageUpload['filename'], PDO::PARAM_STR);
                }

                $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

                if($update->execute() ) {

                    if($_SESSION['user_init'] == $user['_id'] ) {
                        $this->_sessionUser($this->read() );
                    }
                    header('Location: '.url_base.$_GET['controller'].'/'.$_GET['action'].'/'.$_GET['id'].'?status=1');

                }else {
                    header('Location: '.url_base.$_GET['controller'].'/'.$_GET['action'].'/'.$_GET['id'].'?status=0');
                }

            }else {
                return $imageUpload['errors'];
            }

        }catch(PDOexception $e) {
            
            return $e->getMessage();

        }
    }

    public function delete() {

    }

    public function updatePassword() {
        try {
            $update = $this->connect()->prepare(
                "UPDATE $this->table 
                SET password = :password
                WHERE _id = :id");
            
            $update->bindValue(':password', $this->_passHas(), PDO::PARAM_STR);
            $update->bindValue(':id', $this->getId(), PDO::PARAM_INT);

            if($update->execute() ) {
                header('Location: '.url_base.$_GET['controller'].'/'.$_GET['action'].'?status=1');
            }else {
                header('Location: '.url_base.$_GET['controller'].'/'.$_GET['action'].'?status=0');
            }
        }catch(PDOexception $e) {
            return $e->getMessage();
        }
    }

    public function verifyPassword() {
        try{

            $userResponse = $this->read();
        
            if(password_verify($this->getPassword(), $userResponse['password'])) {
                return ['valid' => true];
            }else {
                return ['valid' => false, 'error' => 'La contraseña actual no es correcta.'];
            }
               
        }catch(PDOexception $e) {
            return ['valid' => false, 'error' => $e->getMessage()];
        }
    }

    public function login() {
        try{

            $userResponse = $this->getBy('email', $this->getEmail() );

            if(!$userResponse) {
                return 'La contraseña o usuario no es correcto.';
            }

            if(!($userResponse['_id_status'] == 1) ) {
                return 'El usuario está bloqueado, contacta con el administrador.';
            }
        
            if(password_verify($this->getPassword(), $userResponse['password'])) {

                $this->_sessionUser($userResponse);
                header('Location: '.url_base);

            }else {
                return 'La contraseña o usuario no es correcto.';
            }
               
        }catch(PDOexception $e) {
            return $e->getMessage();
        }
    }

    public function logout() {
        unset($_SESSION);
        session_destroy();
        session_regenerate_id(true);
        header('Location: '.url_base);
    }

    // OTHERS METHODS

    public function paginations() {
        return $this->pagination('paginations', $this->queryUsers() );
    }

    public function getRoles() {
        return $this->getAllOtherTable('usr_rol');
    }

    public function getStatus() {
        return $this->getAllOtherTable('usr_status');
    }
}

?>
<?php 
require_once 'models/BaseModel.php';

class BaseController {

  private  $modelsName = [], 
           $responseMessage;

  public function __construct(array $modelsName = null) {

    if($modelsName) {
      $this->loadModels($modelsName);
    }
  }
    // GET & SET
  public function getResponseMessage() {
    
    if(is_array($this->responseMessage)) {
      
      $text = "";
      
      foreach ($this->responseMessage as $key => $value) {
        $text = $text.'<p class="p text-red text-bold pd-t-1">'.$value.'</p>';
      }
      
      return $text;
    
    }else {
      return '<p class="p text-red text-bold pd-t-1">'.$this->responseMessage.'</p>';
    }

  }

  public function setResponseMessage($message) {
    $this->responseMessage = $message;
  }

 /**
   *  METHODS
   *  PRIVATES METHODS
  */ 

  private function loadModels(array $modelsName){
    
    $database = new Database();
    $conn = $database->connect();

    foreach ($modelsName as $modelName) {

      $model = ucfirst($modelName).'Model';

      if(file_exists('models/'.$model.'.php') ) {  
        require_once 'models/'.$model.'.php';
        $this->modelsName[$modelName] = new $model($conn);
      }
    }
  }

  private function redirectionPermission() {

    switch($_SESSION['rol']) {
      case 1:

        header('Location: '.url_base.'user');
        break;
      case 2:

        header('Location: '.url_base.'incidence/assigned');
        break;
    }
  }

  // PUBLICS METHODS

  public function model(string $name) {
    return $this->modelsName[$name];
  }

  public function permission(array $roles) {
    // 0  EVERYONE
    // 1  ADMIN
    // 2  EMPLOYE
    $ok = false;

    if($roles[0] == 0) {

      if(isset($_SESSION['user_init']) ) {

        $this->redirectionPermission();
     }
    }else {

      if(isset($_SESSION['user_init']) ) {
        
        foreach ($roles as $rol) {
          if($_SESSION['rol'] == $rol) {
              $ok = true;
          }
        }
      
        if(!$ok) {
          $this->redirectionPermission();
        }
      }else{
        ErrorHandler::response(401);
      }
    }
  }

  public function view(string $archive) {
      
    $route = 'views/'.$archive.'.php';
    
    if(!file_exists($route)) {   
      ErrorHandler::response(500);
    }

    return $route;

  }

  // OTHERS METHODS

  public function submitForm() {
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
      return true;
    }
    return false;
  }

  public function updateStatus() {
    $status = Utils::getCheck('status');
    
    switch ($_GET['action']) {
      case 'new':
        $succesful = 'creado';
        $error = 'crear';
      break;
      case 'update':
        $succesful = 'actualizado';
        $error = 'actualizar';
      break;
    }

    if($status) {
      switch ($status) {
        case 1:
          $this->setResponseMessage('Se ha '.$succesful.' correctamente.');
        break;
        case 0:
          $this->setResponseMessage('Hubo un error al '.$error.'.');
        break;
      }
      return true;
    }
    
    return false;
  }

}

?>
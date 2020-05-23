<?php 

class Router {

    private string $name_controller;
    private string $name_action;

    public function __construct() {
        $this->setNameController();
        $this->setNameAction();
        $this->controller();
    }

    private function getNameController() {
        return $this->name_controller;
    }

    private function setNameController() {
        $this->name_controller = trim(($_GET['controller'] ?? controller_default) );
    }

    private function getNameAction() {
        return $this->name_action;
    }

    private function setNameAction() {
        $this->name_action = trim(($_GET['action'] ?? action_default) );
    }

    private function controller() {
        
        $name_controller = $this->getNameController();

        if(isset($name_controller) ) {

            $name_controller = $name_controller.'Controller';
            
            if(file_exists('controllers/'.$name_controller.'.php') ) {

                if(class_exists($name_controller) ) {
            
                    $controller = new $name_controller();
                    $this->action($controller);

                }else{
                    ErrorHandler::response(404);
                }

            }else{
                ErrorHandler::response(404);
            }
            
        }else{
            ErrorHandler::response(500);
        }
    }

    private function action($controller) {
        $action = $this->getNameAction();

        if(!empty($action) ) {

            if(method_exists($controller, $action) ) {
                $controller->$action();

            }else{
                ErrorHandler::response(404);
            }

        }else {
            ErrorHandler::response(500);
        }

    }

}

?>
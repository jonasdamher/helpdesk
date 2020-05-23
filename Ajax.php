<?php 

require_once 'controllers/BaseController.php';

// SIRVE PARA GESTIONAR PETICIONES AJAX

class Ajax extends BaseController {

	private $response;

	public function __construct($models) {
		parent::__construct($models);
	}

	public function setResponse($response) {
		$this->response = $response;
	}

	public function getResponse() {
		return $this->response;
	}

}

$nameController = $_GET['controller'] ?? null;
$nameMethod = $_GET['action'] ?? null;

if(file_exists('ajax/'.$nameController.'.php') ) {

	require_once 'ajax/'.$nameController.'.php';

	$controller = new $nameController();

	if(method_exists($controller, $nameMethod) ) {

		$controller->setResponse($controller->$nameMethod() );
		
		$response = $controller->getResponse();	
	}
	else {
		$response = ['valid' => false, 'errors' => 'dont exist name method "'.$nameMethod.'" in controller : '.$nameController];
	}

}
else {
	$response = ['valid' => false, 'errors' => 'dont exist name controller: '.$nameController];
}

echo json_encode($response);

?>
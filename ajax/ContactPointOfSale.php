<?php 

class ContactPointOfSale extends Ajax {

	public function __construct() {
		parent::__construct(['contactPointOfSale']);
	}
		
	public function new() {

		$validator = $this->model('contactPointOfSale')->formValidate('all');

		if($validator['valid']){
			
			$schema = $validator['schema'];
		
			$this->model('contactPointOfSale')->setName($schema['name']);
			$this->model('contactPointOfSale')->setPhone($schema['phone']);
			$this->model('contactPointOfSale')->setEmail($schema['email']);
			$this->model('contactPointOfSale')->setIdPto(json_decode($_POST['form'], true)['id']);

			$result = $this->model('contactPointOfSale')->create();
			
			$validator['valid'] = $result['valid'];

			if(!$result['valid']) {

				unset($validator['schema']);
				
				array_push($validator['errors'], $result['error']);
				
			}else {
				$validator['schema']['id'] = $result['id'];
			}
		}

		return $validator;
	}

	public function read() {

		$this->model('contactPointOfSale')->setId(json_decode($_POST['form'], true)['id']);

		$result = $this->model('contactPointOfSale')->read();
		
		$validator = ['valid' => true];

		if(is_array($result) ) {
			$validator['read'] = $result;
		}else {
			$validator['valid'] = false;
			array_push($validator['errors'], $result);
		}

		return $validator;
	}

	public function update() {

		$validator = $this->model('contactPointOfSale')->formValidate('all');

		if($validator['valid']){
			
			$schema = $validator['schema'];

			$this->model('contactPointOfSale')->setName($schema['name']);
			$this->model('contactPointOfSale')->setPhone($schema['phone']);
			$this->model('contactPointOfSale')->setEmail($schema['email']);
			$this->model('contactPointOfSale')->setId(json_decode($_POST['form'], true)['id']);

			$result = $this->model('contactPointOfSale')->update();
			
			$validator['valid'] = $result['valid'];

			if(!$result['valid']) {

				unset($validator['schema']);
				
				array_push($validator['errors'], $result['error']);
				
			}
		}

		return $validator;
	}

	public function delete() {

		$this->model('contactPointOfSale')->setId(json_decode($_POST['form'], true)['id']);

		$result = $this->model('contactPointOfSale')->delete();
		
		$validator = [
			'valid' => $result['valid'],
			'errors' => []
		];
		
		if(!$result['valid']) {
			
			array_push($validator['errors'], $result['error']);
		}

		return $validator;
	}

}
?>
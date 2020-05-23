<?php 

class ArticlePointOfSale extends Ajax {

	public function __construct() {
		parent::__construct(['ArticlePointOfSale']);
	}

	public function new() {

		$validator = $this->model('ArticlePointOfSale')->formValidate('all');

		if($validator['valid']){

			$schema = $validator['schema'];

			$this->model('ArticlePointOfSale')->setName($schema['name']);
			$this->model('ArticlePointOfSale')->setBarcode($schema['barcode']);
			$this->model('ArticlePointOfSale')->setCode($schema['code']);
			$this->model('ArticlePointOfSale')->setSerial($schema['serial']);
			$this->model('ArticlePointOfSale')->setObservations($schema['observations']);
			$this->model('ArticlePointOfSale')->setIdType($schema['id_type']);
			$this->model('ArticlePointOfSale')->setIdIncidence(json_decode($_POST['form'], true)['id_incidence']);
			$this->model('ArticlePointOfSale')->setIdPto(json_decode($_POST['form'], true)['id_pto']);
			
			$result = $this->model('ArticlePointOfSale')->create();
			
			$validator['valid'] = $result['valid'];

			if($result['valid']) {

				$getArticle = $this->read($result['id']);
				$validator['schema'] = $getArticle['read'];
				$validator['valid'] = $getArticle['valid'];
			}else {
				unset($validator['schema']);
				array_push($validator['errors'], $result['error']);
			}
		}

		return $validator;
	}
	
	public function read($id = null) {

		if(is_null($id) ) {
			$id = json_decode($_POST['form'], true)['id'];
		}

		$this->model('ArticlePointOfSale')->setId($id);

		$result = $this->model('ArticlePointOfSale')->read();
		
		$validator = ['valid' => true];

		if(is_array($result) ) {
			$validator['read'] = $result['read'];
			$validator['read']['observations'] = (is_null($validator['read']['observations']) ) ? '' : mb_substr($validator['read']['observations'], 0, 50).'...';
		}else {
			$validator['valid'] = false;
			array_push($validator['errors'], $result);
		}

		return $validator;
	}

	public function update() {

		$validator = $this->model('ArticlePointOfSale')->formValidate('all');

		if($validator['valid']){
			
			$schema = $validator['schema'];

			$this->model('ArticlePointOfSale')->setName($schema['name']);
			$this->model('ArticlePointOfSale')->setBarcode($schema['barcode']);
			$this->model('ArticlePointOfSale')->setCode($schema['code']);
			$this->model('ArticlePointOfSale')->setSerial($schema['serial']);
			$this->model('ArticlePointOfSale')->setObservations($schema['observations']);
			$this->model('ArticlePointOfSale')->setIdType($schema['id_type']);
			$this->model('ArticlePointOfSale')->setId(json_decode($_POST['form'], true)['id']);

			$result = $this->model('ArticlePointOfSale')->update();
			
			$validator['valid'] = $result['valid'];

			if($result['valid']) {
				$getArticle = $this->read();
				$validator['schema'] = $getArticle['read'];
				$validator['valid'] = $getArticle['valid'];

			}else {
				unset($validator['schema']);
				array_push($validator['errors'], $result['error']);
	
			}
		}

		return $validator;
	}

	public function delete() {

		$this->model('ArticlePointOfSale')->setId(json_decode($_POST['form'], true)['id']);

		$result = $this->model('ArticlePointOfSale')->delete();
		
		$validator = [
			'valid' => $result['valid'],
			'errors' => []
		];

		if(!$result['valid']) {
			array_push($validator['errors'], $result['error']);
		}

		return $result;
	}
}
?>
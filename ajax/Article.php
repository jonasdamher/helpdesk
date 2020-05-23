<?php 

class Article extends Ajax {

	public function __construct() {
		parent::__construct(['article', 'generalArticle']);
	}

	public function new() {

		$validator = $this->model('article')->formValidate('all');

		if($validator['valid']){

			$schema = $validator['schema'];
		
			$this->model('article')->setCode($schema['code']);
			$this->model('article')->setSerial($schema['serial']);
			$this->model('article')->setObservations($schema['observations']);
			$this->model('article')->setIdStatus($schema['id_status']);
			$this->model('article')->setIdArticle(json_decode($_POST['form'], true)['id_article']);

			$this->model('generalArticle')->setId(json_decode($_POST['form'], true)['id_article']);

			$result = $this->model('article')->create();
			
			$validator['valid'] = $result['valid'];

			if($result['valid']) {

				// add 1 unit field at articles table 
				$newUnit = $this->model('generalArticle')->addUnit();

				if(!$newUnit['valid']) {
					unset($validator['schema']);
					array_push($validator['errors'], $newUnit['error']);
				}

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

		$this->model('article')->setId($id);

		$result = $this->model('article')->read();
		
		$validator = ['valid' => true];

		if(is_array($result) ) {
			$validator['read'] = $result['read'];
			$validator['read']['created'] = date_format(date_create($validator['read']['created']), 'd-m-Y');
		}else {
			$validator['valid'] = false;
			array_push($validator['errors'], $result);
		}

		return $validator;
	}
	
	public function update() {

		$validator = $this->model('article')->formValidate('only');

		if($validator['valid']){
			
			$schema = $validator['schema'];
			
			$this->model('article')->setCode($schema['code']);
			$this->model('article')->setSerial($schema['serial']);
			$this->model('article')->setObservations($schema['observations']);
			$this->model('article')->setIdStatus($schema['id_status']);
			$this->model('article')->setId(json_decode($_POST['form'], true)['id']);

			$result = $this->model('article')->update();
			
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

		$this->model('article')->setId(json_decode($_POST['form'], true)['id']);
		$this->model('generalArticle')->setId(json_decode($_POST['form'], true)['id_article']);

		$result = $this->model('article')->delete();

		$validator = [
			'valid' => $result['valid'],
			'errors' => []
		];

		if($result['valid']) {

			// delete 1 unit field at articles table 
			$removeUnit = $this->model('generalArticle')->removeUnit();
		
			$validator['valid'] = $removeUnit['valid'];

			if(!$validator['valid']) {
				array_push($validator['errors'], $removeUnit['error']);
			}

		}else {
			array_push($validator['errors'], $result['error']);
		}

		return $validator;
	}
}

?>
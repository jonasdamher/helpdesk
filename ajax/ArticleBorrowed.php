<?php 

class ArticleBorrowed extends Ajax {

	public function __construct() {
		parent::__construct(['ArticleBorrowed', 'Article']);
	}
	
	public function new() {

		$validator = $this->model('ArticleBorrowed')->formValidate('all');

		if($validator['valid']){

			$schema = $validator['schema'];

			$this->model('ArticleBorrowed')->setIdIncidence($schema['id_incidence']);
			$this->model('ArticleBorrowed')->setIdPto($schema['id_pto']);
			$this->model('ArticleBorrowed')->setIdArticle($schema['id_article_only']);
	
			$result = $this->model('ArticleBorrowed')->create();
			
			$validator['valid'] = $result['valid'];

			if($result['valid']) {

				$getArticle = $this->read($result['id']);
				$validator['schema'] = $getArticle['read'];
				$validator['valid'] = $getArticle['valid'];

				$this->model('Article')->setIdBorrowed(2);
				$this->model('Article')->setId($schema['id_article_only']);
				$updateBorrowed = $this->model('Article')->updateBorrowed();

				if(!$updateBorrowed['valid']) {
					unset($validator['schema']);
					array_push($validator['errors'], $result['error']);
				}

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

		$this->model('ArticleBorrowed')->setId($id);

		$result = $this->model('ArticleBorrowed')->read();
		
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

		$validator = $this->model('ArticleBorrowed')->formValidate('only');

		if($validator['valid']){
			
			$schema = $validator['schema'];

			// ACTUALIZAR ARTICULO EN PRESTAMO
			$this->model('ArticleBorrowed')->setIdIncidence($schema['id_incidence']);
			$this->model('ArticleBorrowed')->setId(json_decode($_POST['form'], true)['id']);
			$this->model('ArticleBorrowed')->setIdArticle($schema['id_article_only']);
			
			$result = $this->model('ArticleBorrowed')->update();
			
			$validator['valid'] = $result['valid'];

			if($validator['valid']) {

				// ACTUALIZAR ESTADO DE PRESTAMO DE LISTA DE ARTICULOS
				$this->model('Article')->setIdBorrowed(json_decode($_POST['form'], true)['id_borrowed_status']);
				$this->model('Article')->setId($schema['id_article_only']);
				$updateBorrowedStatus = $this->model('Article')->updateBorrowed();

				if($updateBorrowedStatus['valid']){
				
					// AÑADIR EL ARTÍCULO ACTUALIZADO
					$getArticle = $this->read();
					$validator['schema'] = $getArticle['read'];
					$validator['valid'] = $getArticle['valid'];	
				
				}else {
				
					unset($validator['schema']);
					array_push($validator['errors'], $updateBorrowedStatus['error']);
				}
	
			}else {
				
				unset($validator['schema']);
				array_push($validator['errors'], $result['error']);
			}
		}

		return $validator;
	}

	public function delete() {

		$id = json_decode($_POST['form'], true)['id'];

		// GET ARTICLE
		$getArticle = $this->read($id);
	
		$validator = [
			'valid' => $getArticle['valid'],
			'errors' => []
		];

		if($validator['valid']) {
		
			// DELETE ARTICLE
			$this->model('ArticleBorrowed')->setId($id);
			$delete = $this->model('ArticleBorrowed')->delete();
			$validator['valid'] = $delete['valid'];

			// CHANGE STATUS BORROWED ARTICLE ONLY
			$this->model('Article')->setIdBorrowed(1);
			$this->model('Article')->setId($getArticle['read']['_id_article_only']);
			$updateBorrowed = $this->model('Article')->updateBorrowed();
	
			$validator['valid'] = $updateBorrowed['valid'];

			if(!$validator['valid']) {
				array_push($validator['errors'], $updateBorrowed['error']);
			}

		}else {
			array_push($validator['errors'], $getArticle['error']);
		}

		return $validator;
	}
}

?>
<?php 

class QueryBuild {

	private $select,
					$from,
					$inner = '',
					$where = null,
					$search = null,
					$filter = null,
					$byId = null,
					$order;
	
	private $result = [
					'select' => '',
					'from' => '',
					'inners' => '',
					'where' => 'WHERE ',
					'order' => '',
					'exec' => [
						'search' => null,
						'filter' => null,
						'id' => null
						]
					];

	private	$paramSearch,
					$paramFilter,
					$paramOrder;

	public function __construct() {
	
		$this->paramSearch = $this->param('search');
		$this->paramFilter = $this->param('filter');
	}

	// GET & SET

	public function setSelect($select){
		$this->select = $select;
	}
	
	public function getSelect(){
		return $this->select;
	}
	
	public function setFrom($from){
		$this->from = $from;
	}
	
	public function getFrom(){
		return $this->from;
	}

	public function setInner($inner){
		$this->inner = $inner;
	}
	
	public function getInner(){
		return $this->inner;
	}
	
	public function setWhere($where){
		$this->where = $where;
	}
	
	public function getWhere(){
		return $this->where;
	}

	public function setOrder($order) {
		$this->order = $order;
	}

	public function getOrder() {
		return $this->order;
	}

	public function setSearch($search) {
		$this->search = $search;
	}

	public function getSearch() {
		return $this->search;
	}

	public function setFilter($filter) {
		$this->filter = $filter;
	}

	public function getFilter() {
		return $this->filter;
	}

	
	public function setById($byId) {
		$this->byId = $byId;
	}

	public function getById() {
		return $this->byId;
	}

	// PRIVATE

	private function param(string $param) {
		require_once 'libs/GetParams.php';
		$get = new GetParams();

		if($param == 'order'){
			return $get->$param($this->getFrom() );
		}

		return $get->$param();
	}

	private function build() {

		$this->paramOrder = $this->param('order');

		$this->result['select'] = $this->getSelect();
		$this->result['from'] = $this->getFrom();
		$this->result['inners'] = $this->getInner();

		$this->result['order'] = $this->paramOrder['order'].' '.$this->paramOrder['alt'];

		if(!is_null($this->getWhere() ) ) {
			
			$this->result['exec']['id'] = $this->getById();
			$this->result['where'] .= $this->getWhere();
			return $this->result;
		}
	
		if(!is_null($this->paramSearch ) ) {

			$this->result['where'] .= $this->getSearch().(!is_null($this->paramFilter) ? ' AND ' : '');	
			$this->result['exec']['search'] = '%'.$this->paramSearch['search'].'%';
		}

		if(!is_null($this->paramFilter ) ) {

			$this->result['where'] .= $this->paramFilter['filter'].' = :filter';
			$this->result['exec']['filter'] = $this->paramFilter['to'];
		}

		if(is_null($this->paramSearch ) && is_null($this->paramFilter ) ) {
			
			$this->result['where'] = ''; 
		}

		return $this->result;
	}

	// PUBLIC

	public function query() {
		return $this->build();
	}

}

?>
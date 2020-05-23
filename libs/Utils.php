<?php 

class Utils {

	/**
	 *  METHODS
	 *  PRIVATES METHODS
	*/ 
	
  private function checkSelect(array $selects, $post) {
    if(!(empty($post) ) && $post != null) {

      $selectsNew = [];

      foreach ($selects as $key => $value) {
       
        if($value['_id'] == $post) {

          array_unshift($selectsNew, $value);
        }else {

          array_push($selectsNew, $value);
        }
      }
      
      return $selectsNew;

    }else {
      return $selects;
    }
  }

	private function paramUrl() {

    $params = (isset($_GET['action']) && $_GET['action'] != 'index' ) ?
    [
      'page' => (isset($_GET['page']) && !empty(trim($_GET['page']) ) ? $_GET['page'] : '')
      ] :
    [
      'page' => (isset($_GET['page']) && !empty(trim($_GET['page']) ) ? $_GET['page'] : ''),
      'search' => (isset($_GET['search']) && !empty(trim($_GET['search'] ) ) ? $_GET['search'] : ''),
      'filter' => (isset($_GET['filter']) && !empty(trim($_GET['filter'] ) ) ? $_GET['filter'] : ''),
      'to' =>   (isset($_GET['to']) && !empty(trim($_GET['to']) ) ? $_GET['to'] : ''),
      'order' => (isset($_GET['order']) && !empty(trim($_GET['order']) ) ? $_GET['order'] : ''),
      'alt' => (isset($_GET['alt']) && !empty(trim($_GET['alt']) ) ? $_GET['alt'] : '')
    ];

    return $params;
  }

  private function alterOrder(string $param) {
        
    $paramNameSecond = explode('=', explode('&', $param)[1])[0];
    $paramValueSecond = explode('=', explode('&', $param)[1])[1];

    if(!isset($_GET[$paramNameSecond]) ) {
      return $paramValueSecond;
    }
    if($_GET[$paramNameSecond] == $paramValueSecond) {
      return $paramValueSecond == 'ASC' ? 'DESC' : 'ASC';
    }

    return $paramValueSecond;
	}

  // STATICS PUBLICS METHODS

  public static function imageCheck(string $image) {

    $imageName = explode('/', $image);

    $lengthImageName = mb_strlen($imageName[1]);

    return ((file_exists('public/images/'.$image) && $lengthImageName > 0 ) ) ? true : false;
  }

  public static function image(string $image) {

    return url_base.'public/images/'.$image;
  }
  
  public static function getCheck(string $name) {

    if(isset($_GET[$name]) ) {

      return $_GET[$name];
    }

    return false;

  }

  public static function postCheck(string $name) {

    if(isset($_POST[$name]) ) {

      return $_POST[$name];
    }

    return '';

  }
  
  public static function fileCheck(string $name) {

    if($_FILES[$name]) {

      return $_FILES[$name];
    }

    return null;

  }

  public static function postCheckSelect(array $selects, $name) {

    $post = self::postCheck($name);
    return self::checkSelect($selects, $post);
  }

  public static function resultCheckSelect(array $selects, $name) {

    return self::checkSelect($selects, $name);
  }
  
  public static function nameDatalist(array $selects, $id, $name) {
    if($id != null) {
      foreach($selects as $data) {
        if($data['_id'] == $id){
          return $data[$name];
        }
      }
    }
    return '';
  }
  
  public static function linkPagination(int $page) {
        
    $params = self::paramUrl();

    $params['page'] = $page;

    $queryParams = http_build_query($params);

    $action = (isset($_GET['action']) ? '/'.$_GET['action'] : '/index' );
    $id = (isset($_GET['id']) ) ? '/'.$_GET['id'] : '';

    return  url_base.$_GET['controller'].$action.$id.'?'.$queryParams;
  }

  public static function linkParams(string $param) {
    
    $currentParam = explode('=', $param);
  
    $params = self::paramUrl();

    switch($currentParam[0]) {
      case 'filter':
        $params['filter'] = self::activeQueryParam($param) == '' ? explode('=', explode('&', $param)[0])[1] : '';
        $params['to'] = self::activeQueryParam($param) == '' ? explode('=', explode('&', $param)[1])[1] : '';
      break;
      case 'order':
        $params['order'] = explode('=', explode('&', $param)[0])[1];
        $params['alt'] = self::alterOrder($param);
      break;
    }
  
    $queryParams = http_build_query($params);
    $action = (isset($_GET['action']) ) ? $_GET['action'] : 'index';

    return url_base.$_GET['controller'].'/'.$action.'?'.$queryParams;
  }

  public static function activeQueryParam(string $param) {
    
    $paramNameFirst = explode('=', explode('&', $param)[0])[0];
    $paramValueFirst = explode('=', explode('&', $param)[0])[1];

    $paramNameSecond = explode('=', explode('&', $param)[1])[0];
    $paramValueSecond = explode('=', explode('&', $param)[1])[1];

    if(!isset($_GET[$paramNameFirst]) || !isset($_GET[$paramNameSecond]) ) {
      return '';
    }

    if($_GET[$paramNameFirst] != $paramValueFirst || $_GET[$paramNameSecond] != $paramValueSecond) {
    
      return '';
    
    }

    return 'active';
  }

  public static function activeQueryIconOrder(string $param) {
    
    $paramNameFirst = explode('=', explode('&', $param)[0])[0];
    $paramValueFirst = explode('=', explode('&', $param)[0])[1];

    $paramNameSecond = explode('=', explode('&', $param)[1])[0];
    $paramValueSecond = explode('=', explode('&', $param)[1])[1];

    if(!isset($_GET[$paramNameFirst]) || !isset($_GET[$paramNameSecond]) ) {
      return 'chevron-down';
    }

    if($_GET[$paramNameFirst] != $paramValueFirst || $_GET[$paramNameSecond] != $paramValueSecond) {
    
      return 'chevron-down';
    
    }

    return 'chevron-up';
  }

  public function activeNav(string $section, $action = 'index') {
    if($_GET['controller'] == $section) {
      if(!isset($_GET['action']) && 'index' == $action || isset($_GET['action']) && $_GET['action'] == $action) {
        return 'active';
      }
    }
    return '';
  }

}

?>
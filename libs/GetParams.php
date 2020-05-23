<?php 

class GetParams {

  public function search() {

    $search = [
        'search' => isset($_GET['search']) && !empty(trim($_GET['search']) ) ? (string) trim($_GET['search']) : null
    ];

    if(is_null($search['search']) ) {
        return null;
    }

    return $search;
  }

  public function filter() {

    $filter = [
        'filter' => isset($_GET['filter']) && !empty(trim($_GET['filter']) ) ? (string) $_GET['filter'] : null,
        'to' => isset($_GET['to']) && !empty(trim($_GET['to']) ) ? (string) $_GET['to'] : null
    ];

    if(is_null($filter['filter']) || is_null($filter['to']) ) {
        return null;
    }

    return $filter;
  }

  public function order($table = null) {
    $order = [
        'order' => isset($_GET['order']) && mb_strlen(trim($_GET['order']) ) > 0 ? (string) $_GET['order'] : $table.'._id',
        'alt' => isset($_GET['alt']) && mb_strlen(trim($_GET['alt']) ) > 0 ? (string) $_GET['alt'] : 'DESC'
    ];
    return $order;
  }
  
}

?>
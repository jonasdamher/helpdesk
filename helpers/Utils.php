<?php

declare(strict_types=1);

class Utils
{

  /**
   *  METHODS
   *  PRIVATES METHODS
   */

  private static function checkSelect(array $selects, $post): array
  {
    if (empty($post) || $post == null) {
      return $selects;
    }

    $selectsNew = [];

    foreach ($selects as $value) {

      if ($value['_id'] == $post) {
        array_unshift($selectsNew, $value);
      } else {
        array_push($selectsNew, $value);
      }
    }

    return $selectsNew;
  }

  private static function paramUrl()
  {

    $params = (isset($_GET['action']) && $_GET['action'] != 'index') ?
      [
        'page' => (isset($_GET['page']) && !empty(trim($_GET['page'])) ? $_GET['page'] : '')
      ] :
      [
        'page' => (isset($_GET['page']) && !empty(trim($_GET['page'])) ? $_GET['page'] : ''),
        'search' => (isset($_GET['search']) && !empty(trim($_GET['search'])) ? $_GET['search'] : ''),
        'filter' => (isset($_GET['filter']) && !empty(trim($_GET['filter'])) ? $_GET['filter'] : ''),
        'to' => (isset($_GET['to']) && !empty(trim($_GET['to'])) ? $_GET['to'] : ''),
        'order' => (isset($_GET['order']) && !empty(trim($_GET['order'])) ? $_GET['order'] : ''),
        'alt' => (isset($_GET['alt']) && !empty(trim($_GET['alt'])) ? $_GET['alt'] : '')
      ];

    return $params;
  }

  private static function alterOrder(string $param)
  {

    $paramNameSecond = explode('=', explode('&', $param)[1])[0];
    $paramValueSecond = explode('=', explode('&', $param)[1])[1];

    if (!isset($_GET[$paramNameSecond])) {
      return $paramValueSecond;
    }
    if ($_GET[$paramNameSecond] == $paramValueSecond) {
      return $paramValueSecond == 'ASC' ? 'DESC' : 'ASC';
    }

    return $paramValueSecond;
  }

  // STATICS PUBLICS METHODS

  public static function imageCheck(string $image): bool
  {

    $imageName = explode('/', $image);

    $lengthImageName = mb_strlen($imageName[1]);

    return (file_exists('public/images/' . $image) && $lengthImageName > 0);
  }

  public static function image(string $image): string
  {
    return URL_BASE . 'public/images/' . $image;
  }

  public static function getCheck(string $name): string
  {
    return filter_var(trim($_GET[$name] ?? ''), FILTER_SANITIZE_STRING);
  }

  public static function postCheck(string $name): string
  {
    return filter_var(trim($_POST[$name] ?? ''), FILTER_SANITIZE_STRING);
  }

  public static function fileCheck(string $name): mixed
  {
    return  $_FILES[$name] ?? null;
  }

  public static function postCheckSelect(array $selects, $name)
  {
    $post = self::postCheck($name);
    return self::checkSelect($selects, $post);
  }

  public static function resultCheckSelect(array $selects, $name)
  {

    return self::checkSelect($selects, $name);
  }

  public static function nameDatalist(array $selects, $id, $name): string
  {
    if ($id == null) {
      return '';
    }

    foreach ($selects as $data) {
      if ($data['_id'] == $id) {
        return $data[$name];
      }
    }
  }

  public static function linkPagination(int $page)
  {

    $params = self::paramUrl();

    $params['page'] = $page;

    $queryParams = http_build_query($params);

    $action = (isset($_GET['action']) ? '/' . $_GET['action'] : '/index');
    $id = (isset($_GET['id'])) ? '/' . $_GET['id'] : '';

    return  URL_BASE . $_GET['controller'] . $action . $id . '?' . $queryParams;
  }

  public static function linkParams(string $param)
  {

    $currentParam = explode('=', $param);

    $params = self::paramUrl();

    switch ($currentParam[0]) {
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
    $action = (isset($_GET['action'])) ? $_GET['action'] : 'index';

    return URL_BASE . $_GET['controller'] . '/' . $action . '?' . $queryParams;
  }

  public static function activeQueryParam(string $param)
  {

    $paramNameFirst = explode('=', explode('&', $param)[0])[0];
    $paramValueFirst = explode('=', explode('&', $param)[0])[1];

    $paramNameSecond = explode('=', explode('&', $param)[1])[0];
    $paramValueSecond = explode('=', explode('&', $param)[1])[1];

    if (!isset($_GET[$paramNameFirst]) || !isset($_GET[$paramNameSecond])) {
      return '';
    }

    if ($_GET[$paramNameFirst] != $paramValueFirst || $_GET[$paramNameSecond] != $paramValueSecond) {

      return '';
    }

    return 'active';
  }

  public static function activeQueryIconOrder(string $param)
  {

    $paramNameFirst = explode('=', explode('&', $param)[0])[0];
    $paramValueFirst = explode('=', explode('&', $param)[0])[1];

    $paramNameSecond = explode('=', explode('&', $param)[1])[0];
    $paramValueSecond = explode('=', explode('&', $param)[1])[1];

    if (!isset($_GET[$paramNameFirst]) || !isset($_GET[$paramNameSecond])) {
      return 'chevron-down';
    }

    if ($_GET[$paramNameFirst] != $paramValueFirst || $_GET[$paramNameSecond] != $paramValueSecond) {

      return 'chevron-down';
    }

    return 'chevron-up';
  }

  /**
   * Devuelve un valor de petición POST, 
   * uso para campos de formularios.
   */
  public static function postValue(string $postFieldName): string
  {
    if (!isset($_POST[$postFieldName])) {
      return '';
    }
    return $_POST[$postFieldName];
  }

  /**
   * Devuelve un valor de petición GET, 
   * uso para campos de formularios.
   */
  public static function getValue(string $postFieldName): string
  {
    if (!isset($_GET[$postFieldName])) {
      return '';
    }
    return trim($_GET[$postFieldName]);
  }

  /**
   * Redirecciona a una página especificada.
   */
  public static function redirection(string $to = ''): void
  {
    header('Location:' . URL_BASE . $to);
  }

  /**
   * Devuelve el nombre de sección de la página web.
   */
  public static function getSection(): string
  {
    $controller = filter_var(trim($_GET['controller'] ?? ''), FILTER_SANITIZE_STRING);
    $action = filter_var(trim($_GET['action'] ?? ''), FILTER_SANITIZE_STRING);
    $list = $_SESSION['permission_page'] ?? [];
    $section = '';

    if (array_key_exists($controller, $list)) {
      foreach ($list[$controller] as $page) {
        if ($page['action'] == $action) {
          $section = $page['title'];
          break;
        }
      }
    }
    return $section;
  }
}

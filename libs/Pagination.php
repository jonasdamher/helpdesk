<?php

declare(strict_types=1);

class Pagination
{

  private $limit = 10,
    $offset,
    $currentPage,
    $totalPages;

  public function __construct($rows)
  {

    $this->currentPage();
    $this->offset();
    $this->totalPages($rows);
  }

  private function currentPage()
  {

    $currentPage = isset($_GET['page']) && mb_strlen(trim($_GET['page'])) > 0 ? (int) $_GET['page'] : 1;
    --$currentPage;
    $this->currentPage = $currentPage;
  }

  private function offset()
  {

    $this->offset = $this->currentPage * $this->limit;
  }

  private function totalPages($rows)
  {

    $this->totalPages = Ceil($rows / $this->limit);
  }

  public function page()
  {

    $get = [
      'limit' => $this->limit,
      'offset' => $this->offset
    ];

    return $get;
  }

  public function paginations()
  {

    $pagination = [];
    $currentPage = $this->currentPage;
    ++$currentPage;

    if ($currentPage == $this->totalPages) {
      if ($currentPage == $this->totalPages && $currentPage == 1) {

        $item_page = ['page' => $currentPage, 'status' => 'active'];
        array_push($pagination, $item_page);

        $item_page = ['page' => ++$currentPage, 'status' => 'disabled'];
        array_push($pagination, $item_page);

        $item_page = ['page' => ++$currentPage, 'status' => 'disabled'];
        array_push($pagination, $item_page);
      } else {

        $item_page = ['page' => --$currentPage, 'status' => ''];
        array_push($pagination, $item_page);

        $item_page = ['page' => ++$currentPage, 'status' => 'active'];
        array_push($pagination, $item_page);

        $item_page = ['page' => ++$currentPage, 'status' => 'disabled'];
        array_push($pagination, $item_page);
      }
    } elseif ($currentPage == 1) {
      $item_page = ['page' => $currentPage, 'status' => 'active'];
      array_push($pagination, $item_page);

      $item_page = ['page' => ++$currentPage, 'status' => ''];
      array_push($pagination, $item_page);

      if ($currentPage == $this->totalPages) {
        $item_page = ['page' => ++$currentPage, 'status' => 'disabled'];
        array_push($pagination, $item_page);
      } else {
        $item_page = ['page' => ++$currentPage, 'status' => ''];
        array_push($pagination, $item_page);
      }
    } elseif ($currentPage < $this->totalPages) {
      $item_page = ['page' => --$currentPage, 'status' => ''];
      array_push($pagination, $item_page);

      $item_page = ['page' => ++$currentPage, 'status' => 'active'];
      array_push($pagination, $item_page);

      $item_page = ['page' => ++$currentPage, 'status' => ''];
      array_push($pagination, $item_page);
    }

    return $pagination;
  }
}

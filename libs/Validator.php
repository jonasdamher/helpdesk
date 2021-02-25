<?php

declare(strict_types=1);

class Validator extends ResponseHandler
{

  private $data;
  private $type = '';

  public function validate($data)
  {
    $this->data = $data;
  }

  public function int(): void
  {
      
  }

  public function string(): void
  {
  }
}

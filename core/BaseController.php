<?php

declare(strict_types=1);

class BaseController
{

  private array $modelsName = [];

  public function loadModels(array $modelsName)
  {
    foreach ($modelsName as $modelName) {

      $model = ucfirst($modelName) . 'Model';

      if (file_exists('models/' . $model . '.php')) {
        require_once 'models/' . $model . '.php';
        $this->modelsName[$modelName] = new $model();
      }
    }
  }

  public function model(string $name): object
  {
    return $this->modelsName[$name];
  }
}

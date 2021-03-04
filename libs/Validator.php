<?php

declare(strict_types=1);

class Validator extends ResponseHandler
{

  private $data = null;

  /**
   * Para iniciar la validación de un dato.
   */
  public function validate($data)
  {
    $this->data = trim($data);
    return $this;
  }

  /**
   * Devuelve una lista y muestra si algún dato introducido no es correcto.
   */
  public function isValid(): array
  {
    return $this->send();
  }

  /**
   * Para indicar que el dato es obligatorio.
   */
  public function require()
  {
    try {
      if (empty($this->data)) {
        throw new Exception('El campo es obligatoria.');
      }
    } catch (Exception $e) {
      $this->status(400)->fail($e->getMessage());
    } finally {
      return $this;
    }
  }

  /**
   * Valida un correo electrónico.
   */
  public function email()
  {
    $newData = filter_var($this->data, FILTER_SANITIZE_EMAIL);
    try {
      if (!filter_var($newData, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('El correo electrónico no es válido.');
      }
    } catch (Exception $e) {
      $newData = '';
      $this->status(400)->fail($e->getMessage());
    } finally {
      $this->data = null;
      return (string) $newData;
    }
  }

  /**
   * Valida si un dato es un número entero.
   */
  public function int()
  {
    $newData = filter_var($this->data, FILTER_SANITIZE_NUMBER_INT);
    try {
      if (!filter_var($newData, FILTER_VALIDATE_INT)) {
        throw new Exception('El dato no es válido.');
      }
    } catch (Exception $e) {
      $newData = 0;
      $this->status(400)->fail($e->getMessage());
    } finally {
      $this->data = null;
      return (int) $newData;
    }
  }

  /**
   * Valida si un dato es un número flotante.
   */
  public function float()
  {
    $newData = filter_var($this->data, FILTER_SANITIZE_NUMBER_FLOAT);
    try {
      if (!filter_var($newData, FILTER_VALIDATE_FLOAT)) {
        throw new Exception('El dato no es válido.');
      }
      return $newData;
    } catch (Exception $e) {
      $newData = 0;
      $this->status(400)->fail($e->getMessage());
    } finally {
      $this->data = null;
      return (float) $newData;
    }
  }

  /**
   * Valida si un dato son letras y números.
   */
  public function string()
  {
    $newData = filter_var($this->data, FILTER_SANITIZE_STRING);
    try {
      if (empty($newData)) {
        throw new Exception('El dato no es válido.');
      }
      return $newData;
    } catch (Exception $e) {
      $newData = '';
      $this->status(400)->fail($e->getMessage());
    } finally {
      $this->data = null;
      return (string) $newData;
    }
  }
}

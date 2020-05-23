<?php 

class Validator {

  private array $schema;
  private array $response =  [
            'errors' => [],
            'valid' => true
          ];
  
  public function __construct(array $schema, string $validateType) {

    switch($validateType){
      case 'all':

        $this->schema = $this->allValues($schema);
      break;
      case 'only':

        $this->schema = $this->onlyValues($schema);
      break;
    }

  }

  private function allValues(array $schema){
    
    $posts = isset($_POST['form']) && json_decode($_POST['form'], true) ? json_decode($_POST['form'], true) : $_POST;

    foreach ($schema as $field => $value) {
      
      // FOR POST
      if(array_key_exists($field, $posts) ) {

        $schema[$field]['value'] = $posts[$field];
        
      }

    }
  
    return $schema;
  }

  private function onlyValues(array $schema){
    
    $posts = isset($_POST['form']) && json_decode($_POST['form'], true) ? json_decode($_POST['form'], true) : $_POST;

    foreach ($schema as $field => $value) {
      
      // FOR POST
      if(array_key_exists($field, $posts) ) {

        $schema[$field]['value'] = $posts[$field];
        
      }else {
        unset($schema[$field]);
      }

    }
  
    return $schema;
  }

  // NAME FIELD FOR RESPONSE ERROR
  private function nameField($keySchema){
    return (key_exists('nameError', $this->schema[$keySchema])) ? $this->schema[$keySchema]['nameError'] : $keySchema;
  }

  // METHODS CLEAN SCHEMA

  private function clearSchema(array $schema) {

    foreach ($schema as $keySchema => $valueSchema) {

      $value = $this->sanitize($schema[$keySchema]['type'], trim($schema[$keySchema]['value']) );
  
      $schema[$keySchema]['value'] = (!empty($value) ? $value : null);

    }

    return $schema;
  }

  private function sanitize($type, $value){
    
    $sanitizeValue = '';
    
    switch ($type) {
      case 'string':
        $sanitizeValue = filter_var($value, FILTER_SANITIZE_STRING);
        break;
      case 'int':
        $sanitizeValue = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
      break;
      case 'float':
        $sanitizeSimbols = preg_replace('/[a-zA-Z][\/\&%#\$]/', '', str_replace(',', '.', $value) );
        $sanitizeValue = filter_var($sanitizeSimbols, FILTER_SANITIZE_STRING);
      break;
    }

    return $sanitizeValue;
  }

  // END METHODS CLEAN SCHEMA

  // METHODS CHECK SCHEMA

  private function addResponse ($res) {

    array_push($this->response['errors'], $res);
    $this->response['valid'] = false;
  }

  private function transformToType($keySchema) {
    
    $valueNew = '';

    if($this->schema[$keySchema]['type'] == 'int' && filter_var($this->schema[$keySchema]['value'], FILTER_VALIDATE_INT) ) {

      $valueNew = (int) $this->schema[$keySchema]['value'];

    }else if($this->schema[$keySchema]['type'] == 'float' && filter_var($this->schema[$keySchema]['value'], FILTER_VALIDATE_FLOAT) ) {

      $valueNew = (float) $this->schema[$keySchema]['value']; 

    }else if($this->schema[$keySchema]['type'] == 'bool' && filter_var($this->schema[$keySchema]['value'], FILTER_VALIDATE_BOOLEAN) ) {

      $valueNew = (bool) $this->schema[$keySchema]['value'];

    }else {

      $valueNew = $this->schema[$keySchema]['value'];
    }
    
    return $valueNew;
  }

  private function type($keySchema, $valueField) {

    $this->schema[$keySchema]['value'] = $this->transformToType($keySchema);

    if(!('is_'.$valueField)($this->schema[$keySchema]['value']) && $this->schema[$keySchema]['value'] != NULL) {                    
      $response = "El valor del campo '".$this->nameField($keySchema)."' tiene que ser de tipo '$valueField'";
      $this->addResponse($response);  
    }
  }

  private function required($keySchema, $valueField) {
    
    switch ($valueField) {
      case true:

        if(is_null($this->schema[$keySchema]['value']) ) {

          $response = "El valor del campo '".$this->nameField()."' está vacío y es requerido";
          $this->addResponse($response);
        }

      break;
    }
  }

  private function match($keySchema, $regex) {
    
    $value = $this->schema[$keySchema]['value'];

    if(!preg_match($regex, $value)){

      $response = "El campo '".$this->nameField($keySchema)."' no cumple con el formato";
      $this->addResponse($response);  
    }
    
  }

  private function minLength($field, $min) {

    $length = mb_strlen($this->schema[$field]['value']);

    if($length < $min) {

      $response = "El campo '".$this->nameField($field)."' debe tener mínimo $min caracteres";
      $this->addResponse($response); 
    }

  }
  
  private function maxLength($field, $max) {

    $length = mb_strlen($this->schema[$field]['value']);

    if($length > $max) {

      $response = "El campo '".$this->nameField($keySchema)."' no puede superar el máximo de $max caracteres";
      $this->addResponse($response); 
    }

  }

  private function fieldCheck($keySchema) {
  
    $fields = $this->schema[$keySchema];

    foreach ($fields as $keyField => $valueField) {

      if($keyField != 'value'){

        $valueLength = mb_strlen($valueField);
        
        if($valueLength == 0) {

          $response = "En el apartado '$keySchema', el campo '$keyField' no tiene valor ";
          $this->addResponse($response);
          return $this->response;
        }

        if(method_exists(__CLASS__, $keyField) ){
          $this->$keyField($keySchema, $valueField);
        }
        
      }
    }

  }

  // END METHODS CHECK SCHEMA

  private function responseSchema() {
    
    $this->response['schema'] = [];

    foreach ($this->schema as $field => $value) {

      $this->response['schema'][$field] = $this->schema[$field]['value'];
    }
  }

  public function schemaCheck() {

    $this->schema = $this->clearSchema($this->schema);

    foreach ($this->schema as $keySchema => $value) {

        if(is_array($this->schema[$keySchema])){
          $this->fieldCheck($keySchema);
        }
    }

    if($this->response['valid']) {
      
      $this->responseSchema();
    }

    return $this->response;
  }

}

?>
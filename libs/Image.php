<?php 

class Image {

  private array $valid = ['valid' => true, 'filename' => null, 'errors' => ''];

          //  CONFIGURATION
  private string $target_dir = 'public/images/';
  private array $format = ['png', 'jpg', 'jpeg', 'webp'];
  private int $maxSize = 2097152 ; // 2 MB
  private array $dimensions = ['x' => 128, 'y' => -1];
  private string $formFileName; //nombre del campo del formulario
  private string $formatImage = 'imagecreatefrom';
  private $typeUpload;  //actualizar o nueva image , update or new
        
          // IMAGE
  private $image,
          $fileName,
          $target_file,
          $size,
          $type;

  private $oldImageName; //Imagen Antigua, si es que la hay en el parametro $formFileName

  public function __construct($dir, $formFileName, $type) {

    $this->target_dir .= $dir;

    $this->typeUpload = $type;

    switch($this->typeUpload) {
    
      case 'new': 
      
        $this->formFileName = $formFileName;
    
        $this->postImageFile();

      break;
      case 'update':

        $this->formFileName = $formFileName['updateImage'];
        $this->oldImageName = $formFileName['CurrentimageName'];

        $this->postImageFile();

      break;
    }

  }

  private function rename($path) {

    $unqid = uniqid();
    $fileName = strtolower( pathinfo( $path, PATHINFO_FILENAME) );
    $rename = $unqid.$fileName;

    return $rename;
  }

  private function postFileExist() {
    if(isset($_FILES[$this->formFileName]) && mb_strlen($_FILES[$this->formFileName]['tmp_name']) > 0 ) {

      return true;
    }
    return false;

  }

  private function postImageFile() {

    if($this->postFileExist() ) {

      $this->image = $_FILES[$this->formFileName];
          
      $target = $this->target_dir.'/'.$this->image['name'];

      $this->size = $this->image['size'];
      $this->type = strtolower( pathinfo( $target, PATHINFO_EXTENSION) );

      $this->fileName = $this->rename($target).'.webp';

      $this->target_file = $this->target_dir.'/'.$this->fileName;
    }

  }

  private function format() {
    
    foreach ($this->format as $type) {
      if($type == $this->type){
        $this->formatImage .= $this->type == 'jpg' ? 'jpeg' : $this->type;
        return true; 
      }
    }

    $this->valid['valid'] = false;
    return false;
  }

  private function size() {
    if($this->size <= $this->maxSize) {                      
      return true;
    }

    $this->valid['valid'] = false;
    return false;
  }

  private function validateImage() {

    if(!($this->size() ) ) {
      $this->valid['errors'] = 'Tiene que ser una imagen menor a 3 MB';
    }
    
    if(!($this->format() ) ) {
      $this->valid['errors'] = 'El formato de imagen no es correcto.';
    }

    return $this->valid;
  }

  private function destroyOldImage() {
    
    $target = $this->target_dir.'/'.$this->oldImageName;
    
    if(file_exists($target)) {
      unlink($target);
    }
  }

  private function crop($image) {

    $crop_width = imagesx($image);
    $crop_height = imagesy($image);

    $size = min($crop_width, $crop_height);

    $coordinates = [
      'x' => 0,
      'y' => 0
    ];
    
    ($crop_width >= $crop_height) ? 
    $coordinates['x'] = ($crop_width-$crop_height)/2 :
    $coordinates['y'] = ($crop_height-$crop_width)/2;
    
    $cropped = imagecrop($image, [
      'x' => $coordinates['x'], 
      'y' => $coordinates['y'], 
      'width' => $size, 
      'height' => $size
    ]);
    
    return $cropped;
  }

  private function scale($image) {

    $imageNew = imagescale(
      $this->crop($image), 
      $this->dimensions['x'], 
      $this->dimensions['y'], 
      IMG_BILINEAR_FIXED
    );

    return $imageNew;
  }
  
  public function upload() {

    if($this->postFileExist() ) {

      $validate = $this->validateImage();
      
      if($validate['valid']) {

        $image = ($this->formatImage)($this->image['tmp_name']);

        $imageNew = $this->scale($image);

        if(!(imagewebp($imageNew, $this->target_file) ) ) {
      
          $this->valid['valid'] = false;
          return $this->valid['errors'] = 'La imagen no pudo subirse, intentelo de nuevo';
        }

        imageDestroy($imageNew);

        if($this->typeUpload == 'update' && !is_null($this->oldImageName) ){
          $this->destroyOldImage();
        }

        $this->valid['filename'] = $this->fileName;
      
      }

    }

    return $this->valid;
  }

}

?>
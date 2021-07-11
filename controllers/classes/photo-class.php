<?php

class Photo
{
  private $photoId;
  private $photoName;
  private $photoAltText;
  private $creationDate;


  function __construct($photoId)
  {

    $this->photoId=$photoId;
  }
  public function setPhotoName($photoName){
    $this->photoName=$photoName;
  }
  public function setPhotoAltText($photoAltText){
    $this->photoAltText=$photoAltText;
  }
  public function setCreationDate($creationDate){
    $this->creationDate=$creationDate;
  }
  public function getPhotoName(){
    return $this->photoName;
  }
  public function getPhotoId(){
    return $this->photoId;
  }
  public function getPhotoAltText(){
    return $this->photoAltText;
  }
  public function getCreationDate(){
    return $this->creationDate;
  }

}



 ?>

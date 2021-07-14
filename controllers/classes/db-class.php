<?php

class db
{
  private $host;
  private $user;
  private $password;
  private $schema;
  function __construct($host,$user,$password,$schema)
  {
    $this->host=$host;
    $this->user=$user;
    $this->password=$password;
    $this->schema=$schema;
  }
  function  connect(){
    try{
      $con=new PDO("mysql:host=$this->host;dbname=$this->schema", $this->user, $this->password);
      $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      
      return $con;
    }catch(PDOException $e){
      return  $e;
    }

  }
}

?>

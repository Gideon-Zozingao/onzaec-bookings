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
    $con=mysqli_connect($this->host,$this->user,$this->password,$this->schema);
    if($con){
      return  $con;
    }else{
      return  "Error  Connecting:".mysqli_error($con);
    }
  }
}

?>

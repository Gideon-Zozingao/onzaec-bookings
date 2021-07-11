<?php
//filter and sanitize string input
function  filterName($string){
    $string=filter_var(trim($string), FILTER_SANITIZE_STRING);
        if(filter_var($string, FILTER_VALIDATE_REGEXP,    array("options"=>array("regexp"=>"/^[a-zA-Z0-9\s]+$/")))){
            return $string;
      }
      else{
          return FALSE;
      }
}
function filterEmail($email){
// Sanitize e-mail address
 $email = filter_var(trim($email), FILTER_SANITIZE_EMAIL);
 // Validate e-mail address
 if(filter_var($email, FILTER_VALIDATE_EMAIL)){
return $email;
}
else{
return FALSE;
}
}
function filterString($string){
// Sanitize string
$field = filter_var(trim($string), FILTER_SANITIZE_STRING);
if(!empty($string)){
 return $string; }
 else{
return FALSE;
} }

?>

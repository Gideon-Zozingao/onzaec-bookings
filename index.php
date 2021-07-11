<?php
    session_start();
      if(!isset($_SESSION['logedin'])){
        $page_tittle="Onaze-Bookings ||Welcome ";
        $page_robots_mete="folow,index";
        $page_mete_description="This site  Provides information about various  accomodations and Properties accross PNG and real time listing of rooms and their rates and availabilties";
          include("default.php");
    }else{
      if(isset($_SESSION['account'])&&$_SESSION['account']==='advanced'){
          header("Location:account");
      }else{
        $page_robots_mete="nofolow,noindex";
        $page_tittle="Onaze-Bookings ||Home ";
        $page_mete_description="This site  Provides information about various  accomodations and Properties accross PNG and real time listing of rooms and their rates and availabilties";
          include("home.php");
      }
  }
?>

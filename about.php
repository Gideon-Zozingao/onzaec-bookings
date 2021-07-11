<?php

switch ($_SERVER["REQUEST_METHOD"]) {
  case 'GET':

  if(isset($_GET["redir"])&&$_GET["redir"]=="true"){
    if(isset($_GET["section"])){
      switch ($_GET["section"]) {
        case 'services':
        $meta_robots="index, follow";
         $page_tittle="Onaze-Bookings || About >> Services ";
         $meta_description="All the Services Provided at Onzaec Bookings";
        include("views/onzaec-services.php");
        break;

        case 'team':
        $meta_robots="index, follow";
         $page_tittle="Onaze-Bookings || About >> Team ";
         $meta_description="A team of Tallented and Highly Skilled individuals in the digital world";
         include("views/team.php");
        break;


        case 'contactus':
        $meta_robots="index, follow";
         $page_tittle="Onaze-Bookings || About >>Contact Us";
         $meta_description="We are a team of Digital marketing professionals dedicated in Providing digital marketing Services for Small, Hotesl and  Inns with  Papua New Guinea with  an aim to Drive more revenue generations and bring their businesses to the next step";
        include("contact-us.php");
        break;
        case 'termsOfServices':
        $meta_robots="index, follow";
         $page_tittle="Onaze-Bookings || About >> Terms Of Services ";
         $meta_description=" Onzaec Bookings Terms of Services";
        include("views/terms-of-services.php");
        break;
        case 'plans':
        $meta_robots="index, follow";
         $page_tittle="Onaze-Bookings || About >> Property Listing Plans ";
         $meta_description="";
          include("views/property-listing-plan.php");
        break;

        default:

          break;
      }
    }else{
      echo "Wrong Request";
    }
  }else{
    $meta_robots="index, follow";
     $page_tittle="Onaze-Bookings || About ";
     $meta_description="We are a team of Digital marketing professionals dedicated in Providing digital marketing Services for Small, Hotesl and  Inns with  Papua New Guinea with  an aim to Drive more revenue generations and bring their businesses to the next step";
    include("./views/general-about-info.php");
  }

    break;

  default:
    // code...
    break;
}

 ?>

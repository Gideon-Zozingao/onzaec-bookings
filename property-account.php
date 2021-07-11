<?php
  if(isset($_SESSION["logedin"])){?>
  <?php //include("views/account.layout.php")?>
  <!-- pop up modal for displaying on the fly data -->
  <?php include("views/modal.php")?>
  <!-- open sidebar menu -->

  		<!-- Wrapper -->
      	<div class="wrapper">
          <?php include("views/property-side-nav.php")?>
  			<!-- End sidebar -->
  			<!-- Dark overlay -->
      		<div class="overlay"></div>
          <main id="content">
            <?php 	include('views/property-nav.php');?>
              <!-- ======= Featured Services Section ======= -->
              <section>
  			<!-- Content -->
  			<div class="content  container-fluid"  data-aos="fade-up">
                  <?php
          if(isset($_REQUEST["action"])){
            switch ($_REQUEST["action"]) {
              case 'add':
              switch ($_REQUEST["a?"]) {
                case 'room':
                  include("properties/add-rooms.php");
                break;
                case 'service':
                    echo "Adding a  service";
                break;
                case 'facility':
                      //echo "Adding a  Facility";

                      include("properties/add-facilities.php");
                break;
                case 'employee':
                        include("properties/add-employee.php");
                break;


                default:
                  echo "Property  Dashboard";
                  break;
              }
                //echo "Adding  Somtehing";
                break;

                case 'view':
                switch ($_REQUEST["page"]) {
                  case 'reservations':
                    include("properties/bookings.php");
                  break;
                  case 'rooms':
                  include("properties/rooms.php");
                      // code...
                  break;
                  case 'services':
                        echo "Viewing Services";
                    break;
                    case 'property-site-management':
                          //echo "Property  Management";
                          include("properties/property-management.php");
                      break;
                    case 'facilities':
                          // code.\
                          include("properties/facilities.php");

                          // echo "Viewing Facilities";
                    break;
                  default:
                    if($_SESSION['userType']==="admin"){
                      include("properties/prop-admin.dashboard.php");
                    }else{
                      include("properties/prop-employee.dashboard.php");

                    }
                    break;
                }
                  //echo "Viewing Something";
                //break;

            }
          }else{
            if($_SESSION['userType']==="admin"){
              include("properties/prop-admin.dashboard.php");
            }else{
              include("properties/prop-employee.dashboard.php");

            }
          }
        ?>
  		      <!-- Top content -->
  		   </div>
  	        <!-- End content -->
          </main>
                <!-- ======= Featured Services Section ======= -->
              </section>
          </div>
          <!-- End wrapper -->

    <?php
    include("views/property-footer.php");
 }else{

  }

?>

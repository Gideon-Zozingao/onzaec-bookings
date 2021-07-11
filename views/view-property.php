<?php
    $sql1="SELECT *FROM properties WHERE property_link='$_REQUEST[Propertylink]'";
    $query1=mysqli_query($conn,$sql1);
    if($query1){
      $query_result1=mysqli_num_rows($query1);
      if($query_result1>0){
            $row1=mysqli_fetch_array($query1);
            $page_tittle="Onaze-Bookings || ".$row1['propertyName'];
            ?>
            <meta name="robots" content="index,folow">
            <meta name="description" content="<?php echo $row1['property_description']?>">
            <title><?php echo $page_tittle?></title>
            <?php include("views/layout-links.php") ?>
            </head>
            <body>

              <header id="header" class="fixed-top">
                <div class="container d-flex align-items-center">
                  <a href="/" class="logo mr-auto"><img src="public/images/Onzaec-bookings-64x64.png" alt=""></a>
                  <?php include("views/nav.php")?>
                </div>
              </header>
            <?php

            $sql2="SELECT *FROM site_profile WHERE  propertyId='$row1[propertyId]'";
            $query2=mysqli_query($conn,$sql2);
            $num_rows2=mysqli_num_rows($query2);
        if($num_rows2>0){
        $row2=mysqli_fetch_array($query2);
        ?> <section id="hero" class="d-flex align-items-center" style=" background: url('../public/gallery/images/<?php echo$row2['propertyCoverPhoto'];?>') top left;background-repeat: no-repeat;background-size: 100%; width:100%; max-height:250vh">
          <div class="container" data-aos="zoom-out" data-aos-delay="100">
            <br>
            <h1> <span><?php echo $row2['propertyHeading']?> </spa>
            </h1>
            <div class="col-md-7">
              <h2><?php echo $row2['site_profileSubheading']?></h2>
            </div>
              <div class="container-fluid" data-aos="fade-up">
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                  <div class="col-lg-6">
                    <div class="info-box mb-4">
                      <i class="bx bx-map"></i>
                      <h6>Our Address</h6>
                      <p><?php echo $row2['propertyAddress'] ." |".$row1['location']?></p>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                    <div class="info-box  mb-4">
                      <i class="bx bx-envelope"></i>
                      <h6>Email Us</h6>
                      <p><?php echo $row2['propertyEmail'] ?></p>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                    <div class="info-box  mb-4">
                      <i class="bx bx-phone-call"></i>
                      <h6>Call Us</h6>
                        <p><?php echo $row2['propertyPhone'] ?></p>
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </section>
        <?php
      }else{?>
        <section id="hero" class="d-flex align-items-center">
          <div  data-aos="zoom-out" data-aos-delay="100">
            <h1> <span><?php echo $row1['propertyName']?></spa>
            </h1>
            
              <div class="container" data-aos="fade-up">
                <div class="row" data-aos="fade-up" data-aos-delay="100">
                  <div class="col-lg-6">
                    <div class="info-box mb-4">
                      <i class="bx bx-map"></i>
                      <p><?php echo $row1['address'] ." |".$row1['location']?></p>
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                    <div class="info-box  mb-4">
                    </div>
                  </div>
                  <div class="col-lg-3 col-md-6">
                    <div class="info-box  mb-4">
                    </div>
                  </div>
                </div>
              </div>
          </div>
        </section>
        <?php
      }?>
      <hr>
<main id="main" class="container">
  <div class="row ">
    <div class=" col-md-2">
      <ul class="list-unstyled property-page-nav">
          <li class="active">
          <a href="?feature=rooms" title="Rooms">Rooms</a></li>
          <li><a href="?feature=facilities" title="Facilities">Facilities</a></li>
          <li><a href="?feature=services" title="Services">Services</a></li>
          <li><a href="?feature=events" title="Events">Events</a></li>
          <li><a href="?feature=photos" title="Photos"> <span class="fas fa-photo"></span> Photos</a></li>
        </ul>
    </div>
    <div class="col-md-10 ">
      <?php
      if(isset($_REQUEST["feature"])){
        switch ($_REQUEST["feature"]) {
          case 'services':
          break;
          case 'facilities':
          include("views/property-facilities.php");
          break;
          case 'rooms':
          include("views/property-rooms.php");
          break;
          case 'events':
          break;
          case 'photos':
          include("views/property-photos.php");
          break;
          default:
          break;
        }
      }else{
        include("views/property-profile.php");
      }
      ?>
    </div>
  </div>
</main>
<?php
      }else{
        ?>
        <main id="main">
          <h1>The Property You are Looking for does Not Exist</h1>
        </main>
        <?php
      }
    }else{
      ?>
      <div class="alert alert-warning">
        <h5>Property Information Cannot be displayed at this time</h5>
        <p>Please Try again Later or contact the Onzae Team if the issues is continues to arrise</p>
      </div>
      <?php
    }?>
    <?php include("./views/footer-1.php")?>
  </body>

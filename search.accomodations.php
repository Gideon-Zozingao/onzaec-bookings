<?php
session_start();
include("views/layout.php");
  //echo "No  Post  Re Request  Recieed from  the Client";
  $page_tittle="Onaze-Bookings  ||Accomodations-Search ";
  echo"<title>$page_tittle</title>";

  ?>
  <?php include("views/layout-links.php") ?>
  </head>
  <body>
      <!-- ======= Header ======= -->
      <header id="header" class="fixed-top">
        <div class="container d-flex align-items-center">
          <a href="/" class="logo mr-auto"><img src="public/images/Onzaec-bookings-64x64.png" alt=""></a>
          <?php include("views/nav.php")?>
        </div>
      </header><!-- End Header -->
      <!-- ======= Hero Section ======= -->
      <section id="hero" class="d-flex align-items-center" style=" background: url('../src/assets/img/hero-bg.jpg') top left; background-repeat:no-repeat; background-size:100%">
        <div class="container" data-aos="zoom-out" data-aos-delay="100">
          <div class="d-flex">
            <?php
            //session_start();
            if(isset($_SESSION["sqNumberOfAdult"])&&isset($_SESSION["sqNumberOfChildren"])&&isset($_SESSION["sqDestination"])&&isset($_SESSION["sqCheckinDate"])&&isset($_SESSION["sqCheckoutdate"])){?>
            <div  class="">
                <form class="accom-search-form " action="../controllers/_s-director.php" method="POST"  name="search.accomodations" class="form-inline" id="accom-search-form">
                  <div class="form-group">
                    <label>Destination</label>
                      <input type="text" class="form-control form-control-lg" placeholder="Destination" name="destination"  value="<?php echo($_SESSION["sqDestination"]) ?>" id="destination">
                  </div>
                  <div class="form-group">
                    <label>Checkin  </label>
                    <input type="date" class="form-control form-control-lg" placeholder="Checkin  Date" name="checkinDate"  value="<?php echo($_SESSION["sqCheckinDate"])?>" id="checkinDate">
                  </div>
                  <div class="form-group">
                    <label>Checkout </label>
                    <input type="date" class="form-control form-control-lg" placeholder="Checkout Date" name="checkoutdate" value="<?php echo($_SESSION["sqCheckoutdate"])?>" id="checkoutDate">
                  </div>
                  <div class="form-group">
                    <label> Children</label>
                      <input type="number" max="12"  min="0" class="form-control form-control-lg" placeholder="Number Of  Children" name="numberOfChildren" value="<?php echo($_SESSION["sqNumberOfChildren"])?>" id="numberOfChildren">
                  </div>
                  <div class="form-group">
                    <label>  Adults</label>
                      <input type="number" max="12"  min="0" class="form-control form-control-lg"  placeholder="Number Of  Adults"  name="numberOfAdult" value="<?php echo($_SESSION["sqNumberOfAdult"])?>" value="0" id="numberOfAdult">
                  </div>
                  <div class="form-group">
                    <label></label>
                      <button type='sumbit' class=" btn btn-info btn-lg btn-block"  name="accom_search_btn">SEARCH</button>
                  </div>
                </form>

            <script type="text/javascript">
            $(document).ready(function(){
                $("#accom-search-form").on("submit",function(e){
                  e.preventDefault()
                  if($("#checkinDate").val()==""){
                    $("#checkinDate").css({
                      border:1px solid red;
                    })
                  }
                  alert("Search Accomodation")
                })
            })

            //id="accom-search-form
            </script>
              <?php

            }else{
            ?>
              <div  class="col-md-12">
                <form  action="../controllers/_s-director" method="POST"  name="search.accomodations" class="form-inline" id="accom-search-form">
                  <div class="row">
                  <div class="">
                    <label>Destination</label>
                      <input type="text" class="form-control form-control-lg" placeholder="Destination" name="destination"  id="destination">
                  </div>
                  <div class="">
                    <label>Checkin  </label>
                    <input type="date" class="form-control form-control-lg" placeholder="Checkin  Date" name="checkinDate" id="checkinDate">
                  </div>
                  <div class="">
                    <label>Checkout </label>
                    <input type="date" class="form-control form-control-lg" placeholder="Checkout Date" name="checkoutdate" id="checkoutdate">
                  </div>
                  <div class="">
                    <label>Children</label>
                      <input type="number" max="12"  min="0" class="form-control form-control-lg" placeholder="Number Of  Children" name="numberOfChildren" value="0" id="numberOfChildren">
                  </div>
                  <div class="">
                    <label>  Adults</label>
                      <input type="number" max="12"  min="0" class="form-control form-control-lg"  placeholder="Number Of  Adults"  name="numberOfAdult" value="0" id="numberOfAdult">
                  </div>
                  <div class="">
                    <label></label>
                      <button type='sumbit' class="btn btn-info text-white btn-lg btn-block"  name="accom_search_btn">SEARCH</button>
                  </div>
                  </div>
                </form>

                <script type="text/javascript">
                $(document).ready(function(){
                    $("#accom-search-form").on("submit",function(e){
                      e.preventDefault()
                      if($("#checkinDate").val()==""){
                        $("#checkinDate").css({
                          background-color:"red",
                          border:"1px solid red"
                        })
                      }
                      //alert("Search Accomodation")
                    })
                })

                //id="accom-search-form
                </script>

            <?php
            }

            ?>

          </div>
        </div>
      </section><!-- End Hero -->
    <?php if(
      isset($_SESSION["sqNumberOfAdult"])
      &&isset($_SESSION["sqNumberOfChildren"])
      &&isset($_SESSION["sqDestination"])
      &&isset($_SESSION["sqCheckoutdate"])
      &&isset($_SESSION["sqCheckinDate"])){?>
          <?php
                include("views/accom-srp.php");
}else{?>
  <div class="container" data-aos="fade-up">
    <div class="section-title">
      <h2>Accomodations Availability accross  The Country</h2>
      <h3>Accomodations available<span></span></h3>
      <p>Ut possimus qui ut temporibus culpa velit eveniet modi omnis est adipisci expedita at voluptas atque vitae autem.</p>
    </div>
    <div class="row">
      <div class="col-lg-6" data-aos="zoom-out" data-aos-delay="100">
        <img src="src/assets/img/about.jpg" class="img-fluid" alt="">
      </div>
      <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
        <h3>Voluptatem dignissimos provident quasi corporis voluptates sit assumenda.</h3>
        <p class="font-italic">
          Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore
          magna aliqua.
        </p>
        <ul>
          <li>
            <i class="bx bx-store-alt"></i>
            <div>
              <h5>Ullamco laboris nisi ut aliquip consequat</h5>
              <p>Magni facilis facilis repellendus cum excepturi quaerat praesentium libre trade</p>
            </div>
          </li>
          <li>
            <i class="bx bx-images"></i>
            <div>
              <h5>Magnam soluta odio exercitationem reprehenderi</h5>
              <p>Quo totam dolorum at pariatur aut distinctio dolorum laudantium illo direna pasata redi</p>
            </div>
          </li>
        </ul>
        <p>
          Ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate
          velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in
          culpa qui officia deserunt mollit anim id est laborum
        </p>
      </div>
    </div>
  </div>
  <?php
}?>
  <?php include("./views/footer-1.php")?>
  </body>

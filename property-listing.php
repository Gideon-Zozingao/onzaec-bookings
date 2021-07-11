<?php
session_start();
if(isset($_SESSION['logedin'])&&$_SESSION['logedin']==true){
  include("views/layout.php");
  $page_tittle="Onaze-Bookings || Property  Listings ";
?>
<meta name="robots" content="index,follow">
<title><?php echo $page_tittle?></title>
<meta name="description" content="Register Your Property and Bring more  Guest, revenue and drive your Business to the next step">
<?php include("views/layout-links.php") ?>
</head>
<body>
      <!-- ======= Top Bar ======= -->
      <!-- <div id="topbar" class="d-none d-lg-flex align-items-center fixed-top">
        <div class="container d-flex">
          <div class="contact-info mr-auto">
            <i class="icofont-envelope"></i> <a href="mailto:contact@example.com">contact@example.com</a>
            <i class="icofont-phone"></i> +1 5589 55488 55
          </div>
          <div class="social-links">
            <a href="#" class="twitter"><i class="icofont-twitter"></i></a>
            <a href="#" class="facebook"><i class="icofont-facebook"></i></a>
            <a href="#" class="instagram"><i class="icofont-instagram"></i></a>
            <a href="#" class="skype"><i class="icofont-skype"></i></a>
            <a href="#" class="linkedin"><i class="icofont-linkedin"></i></i></a>
          </div>
        </div>
      </div> -->
      <header id="header" class="fixed-top">
    <?php include("views/nav.php")?>
        </div>
      </header>

      <section id="hero" class="d-flex align-items-center" style=" background: url('src/assets/img/hero-bg.jpg') top left; background-repeat:no-repeat; background-size:100%;">
        <div class="container" data-aos="zoom-out" data-aos-delay="100">
          <h1> <span>Onzaec Bookings</spa>
          </h1>
          <h2>Property Registration</h2>
          <section>

          </section>
        </div>
      </section>
  <section>

    <div  class="container ">
    <div  class="card " id="form-card">
      <div  class="card-header">
        <h1 class="text-primary text-center">Property Registration</h1>
      </div>
      <div  class="card-body">
        <form action="controllers/register-property" method="post" ectype="multipart/form-data" id="property_reg_form">
          <div  class="row">
            <div  class="form-group col-md-6">
              <lable>Property Name  *</lable>
              <input  type="text" class="form-control form-control-lg"  name="property-name"  placeholder="Property Name" />
            </div>
            <div  class="form-group col-md-6">
              <lable>Property Type  *</lable>
              <select  class="form-control  form-control-lg"  name="property-type">
                <option value="">-Property Type-</option>
                <option value="Hotel">Hotel</option>
                <option value="Apartments">Apartments</option>
                <option value="Hotel & Apartments">Hotel & Apartments</option>
                <option value="Motel">Motel</option>
                <option value="Lodge">Lodge</option>
                <option value="Guest House">Guest House</option>
              </select>
            </div>
          </div>
          <div  class="row">
            <div  class="form-group col-md-6">
            <lable>Country*</lable>
            <input  type="text" class="form-control form-control-lg"    name="country"  placeholder="Country" />
          </div>
          <div  class="form-group col-md-6">
            <lable>Location*</lable>
            <select class="form-control form-control-lg"  placeholder="Town/City" name="location">
              <option value="">-Location-</option>
              <option value="Buka">Buka</option>
              <option value="Kavieng">Kavieng</option>
              <option value="Kokopo">Kokopo</option>
              <option value="Rabaul">Rabaul</option>
              <option value="Lorengau">Lorengau</option>
              <option value="Kimbe">Kimbe</option>
              <option value="Daru">Daru</option>
              <option value="Kereme">Kereme</option>
              <option value="Vanimo">Vanimo</option>
              <option value="Wewak">Wewak</option>
              <option value="Madang">Madang</option>
              <option value="Popondeta">Popondeta</option>
              <option value="Milnebay">Milnebay</option>
              <option value="Lae">Lae</option>
              <option value="Goroka">Goroka</option>
              <option value="Kundiawa">Kundiawa</option>
              <option value="Jowaka">Jowaka</option>
              <option value="Mt.Hagen">Mt.Hagen</option>
              <option value="Mendi">Mendi</option>
              <option value="Tari">Tari</option>
              <option value="Wabag">Wabag</option>
              <option value="Wabag">Port Moresbey</option>
            </select>
          </div>
          </div>
          <div  class="row">
            <div  class="form-group col-md-6">
            <lable>Address*</lable>
            <input  type="text" class="form-control form-control-lg" name="address" placeholder="Address" />
            </div>
          <div  class="form-group col-md-6">

            <lable>Email*</lable>
            <input  type="text" class="form-control form-control-lg"  value="<?php echo($_SESSION['email'])?>"  name="email"  placeholder="Email"/>
          </div>
          </div>
          <div  class="row">
            <div  class="form-group col-md-6">
            <lable>Phone*</lable>
            <input  type="text" class="form-control form-control-lg"  name="phone"  placeholder="Phone" />
          </div>
          <div  class="form-group col-md-6">
            <lable>Rate Intervals*</lable>
            <select   class="form-control form-control-lg"  name="rate-interval">
              <option>-Rate Intervals-</option>
              <option>Per Night</option>
              <option>Per Day</option>
              <option>Per Hour</option>
              <option>Per Week</option>
              <option>Per Forthnight</option>
              <option>Per Month</option>
            </select>
          </div>
          </div>
          <div  class="row">
            <div  class="form-group col-md-3">
            <lable>Number of Assets*</lable>
            <input  type="number" class="form-control form-control-lg"  min="0" placeholder="Number of Assets" name="number-of-assets"/>
          </div>
            <div  class="form-group col-md-3">
            <lable>Rate range*</lable>
          <div  class="row">
            <div  class="col-md-6">
              <input  type="text" class="form-control form-control-lg"  min="0" name="max-rate" placeholder="Max" />
            </div>
            <div  class="col-md-6">
              <input  type="text" class="form-control  form-control-lg"  min="0"  name="min-rate" placeholder="Min" />
            </div>
          </div>
          </div>
          <div  class="col-md-9 form-group">
            <lable>Property  Description</lable>
            <textarea class="form-control"  rows="8"  name="property-description" placeholder="Property Description"></textarea>
          </div>
          </div>
          <hr>
          <div class="col-md-4  offset-4 text-center" id="resposnse">

          </div>
          <div  class="row">
            <div  class="col-md-4">
            </div>
            <div  class="col-md-4">
              <div  class="form-group">
                <button class="btn-primary  btn-lg btn-block" name="property-listing-button">REGISTER  PROPERTY</button>
              </div>
            </div>
            <div  class="col-md-4">

            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  </section>
  <br>
  <script type="text/javascript">
$(document).ready(function(){
  $("#property_reg_form").on("submit",function(e){
    e.preventDefault()
      $.ajax({
        url:"controllers/register-property.php",
				type:"POST",
				data:new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
        beforeSend : function(){
          $("#resposnse").html("<img src='public/images/loading.gif'>").show();
        },
        success:function(data){

          var realData=JSON.parse(data);
          if(realData.alert_type=="error"){
            setTimeout(()=>{
              $("#resposnse").html("<p class=' alert  alert-danger text-danger'>"+realData.message+"</p>").fadeIn();
            },2000)

            setTimeout(function(){
              $("#resposnse").fadeOut('slow')
            },5000);

          }else{
            setTimeout(()=>{
              $("#property_reg_form")[0].reset();
              $("#resposnse").html("<p class=' alert  alert-success text-success'>"+realData.message+"</p>").fadeIn();
            },1500)

            setTimeout(function(){
              $("#resposnse").fadeOut('slow')
                $("#modal-content").load("account.switch");
                $("#modal").fadeIn("slow")
            },2000);
          }
        },
      })
  })
})
  </script>
<?php
include("./views/footer-1.php");
}else{
  header("Location:./");
}
?>

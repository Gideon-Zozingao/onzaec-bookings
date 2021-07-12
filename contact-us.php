<?php include("views/layout.php");

$page_tittle="Onzaec Bookings || Contact Us";
?>

    <title><?php echo $page_tittle?></title>
    <?php include("views/layout-links.php") ?>
</head>
<body>
    <!-- ======= Top Bar ======= -->
  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top">
    
<?php include("views/nav.php")?>
    </div>
  </header><!-- End Header -->
  <!-- ======= Hero Section ======= -->
  <section id="hero" class="d-flex align-items-center" style=" background: url('src/assets/img/hero-bg.jpg') top left; background-repeat:no-repeat; background-size:100%;">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
      <h1>Contact Us Now</spa>
      </h1>

    </div>

  </section><!-- End Hero -->
<hr>
<main id="main" >
<section class="container">
  <h1>Contact Forms</h1>
</section>


  <script type="text/javascript">
    $(document).ready(function(){
$("#after-header").load("views/after-header.php","#afterHeaderSection");
      setInterval(function(){
        $("#after-header").load("views/after-header.php");
      },1000*60*2)
    })
  </script>
    <!-- ======= Featured Services Section ======= -->
    <!-- ======= Featured Services Section ======= -->

    <!-- End Featured propert Types Section --><!-- End Featured Services Section -->
    <!-- ======= About Section ======= -->
    <!-- End Contact Section -->
  </main>
<?php include("./views/footer-1.php")?>
<script type="text/javascript">
  $(document).ready(function(){
    $("#accomodation-Searchbtn").click(()=>{
      $.ajax({
        url:"views/a-s.php",
        type:"GET",
        beforeSend:function(){
          $("#modal").fadeIn("slow")
        },
        success:function(data){
          $("#modal-content").html(data);
        }
      })
    })
  })
</script>
</body>

<?php
$page_tittle="Onaze-Bookings || Properties";
?>
<title><?php echo $page_tittle?></title>
</head>
<body>
  <header id="header" class="fixed-top">
    <div class="container d-flex align-items-center">
      <a href="/" class="logo mr-auto"><img src="public/images/Onzaec-bookings-64x64.png" alt=""></a>
      <?php include("views/nav.php")?>
    </div>
  </header>

  <section id="hero" class="d-flex align-items-center" style=" background: url('src/assets/img/hero-bg.jpg') top left; background-repeat: no-repeat; background-size:100%;">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
      <h1>Welcome to <span>Onzaec Bookings</spa>
      </h1>
      <div class="d-flex">
        <?php //include("views/a-s.php")?>
      </div>
    </div>
  </section><!-- End Hero -->
  <main id="main" class="container">
  </main>
  <?php include("./views/footer-1.php")?>
  </body>

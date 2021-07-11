
  <div id="preloader"></div>
  <a href="#" class="back-to-top"><i class="icofont-simple-up"></i></a>

  <!-- Vendor JS Files -->

  <script src="../src/assets/vendor/jquery.easing/jquery.easing.min.js"></script>
  <script src="../src/assets/vendor/php-email-form/validate.js"></script>
  <script src="../src/assets/vendor/waypoints/jquery.waypoints.min.js"></script>
  <script src="../src/assets/vendor/counterup/counterup.min.js"></script>
  <script src="../src/assets/vendor/owl.carousel/owl.carousel.min.js"></script>
  <script src="../src/assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="../src/assets/vendor/venobox/venobox.min.js"></script>
  <script src="../src/assets/vendor/aos/aos.js"></script>

  <!-- Template Main JS File -->
  <script src="../src/assets/js/main.js"></script>
<hr>

    <script type="text/javascript">
        $(document).ready(function () {
            $('#sidebarCollapse').on('click', function () {
                $('#sidebar').toggleClass('active');
            });
            $("#close-sidebar").on("click",function(){
              $('#sidebar').toggleClass('active');
            })
        });
    </script>
        <script
              src="https://maps.googleapis.com/maps/api/js?key=AIzaSyB41DRUbKWJHPxaFjMAwdrzWzbVKartNGg&callback=initMap&libraries=&v=weekly"
              async
            ></script>
<footer style="width:100%;">

  <!-- Grid container -->
  <!-- Copyright -->
  <?php
if(isset($_SESSION["logedin"])){
  ?>
  <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.81);color:#ffff;" class="fixed-bottom">Onzaec  Bookings
    © 2021 Copyright:
  </div>
  <?php
}else{
  ?>
  <div class="text-center p-3" style="background-color: rgba(0, 109, 255, 0.76);">Onzaec  Bookings
    © 2021 Copyright:
  </div>
  <?php
}
  ?>

  <!-- Copyright -->
</footer>
<!-- Footer -->

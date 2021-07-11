<div class="container d-flex align-items-center">
<a href="/" class="logo mr-auto"><img src="../public/images/Onzaec-bookings-64x64.png" alt=""></a>

<?php include("modal.php")?>
<script type="text/javascript">
  $(document).ready(function(){
    var roomdetailslink=$(".roomdetailsLink");
  //  console.log(roomdetailslink);
    for(let i=0; i<roomdetailslink.length;i++){
      $(roomdetailslink[i]).on("click",function(e){
        e.preventDefault();
        $.ajax({
          url:`../views/room-details.php?roomId=${roomdetailslink[i].accessKey}`,
          type:"GET",
          beforeSend:function(){
            $("#modal").fadeToggle("slow")
            $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='../public/images/loading.gif'></div><div class='col-md-4'></div></div>");
          },
          success:function(data){
            setTimeout(()=>{
            $("#modal-content").html(data)
          },1500)
          }
        })
      })
    }
  })
</script>
<script type="text/javascript">
  $(document).ready(()=>{
    var reservationButton=$(".reservationButton");
    //alert(reservationButton);
    for(let i=0; i<reservationButton.length;i++){
      $(reservationButton[i]).on("click",(e)=>{
        e.preventDefault();
        $.ajax({
          url:`../Booknow?roomid=${reservationButton[i].accessKey}`,
          type:"GET",
          beforeSend:()=>{
            $("#modal").fadeToggle("slow");
            $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='../public/images/loading.gif'></div><div class='col-md-4'></div></div>")
          },
          success:(data)=>{
            setTimeout(()=>{
            $("#modal-content").html(data);
          },1500)
          }
        })
      })
    }
  })
</script>
<?php
if(isset($_SESSION["logedin"])&&$_SESSION['logedin']===true){
?>
<!-- <h1 class="logo mr-auto"><a href="/">Onzae Bookings<span>.</span></a></h1> -->
<nav class="nav-menu d-none d-lg-block">
  <ul>
    <li class="active"><a href="/">Home</a></li>
    <li><a href="about">About us </a></li>

    <li><a href="events">Events</a></li>

    <li class="drop-down">
      <a href="#" class="text-success"> <span class="fa fa-user"></span> <?php echo $_SESSION['name'].' '.$_SESSION['surname']?></a></i>
      <ul>
        <li class="drop-down">
          <a href="#"><i  class="fa fa-cog"></i></a>
          <ul>
            <li><a href="property-listing">List a Property</a></li>
            <li><a href="account.switch" id="account-switch">Switch  Account</a></li>
          </ul>
        </li>
        <li><a href="profile">Your Profile</a></li>
        <li><a href="logout">Sigout</a></li>
      </ul>
    </li>
  </ul>
</nav>
<script type="text/javascript">
  $(document).ready(()=>{
    $("#account-switch").on("click",(e)=>{
      e.preventDefault();
      $.ajax({
        url:"../account.switch.php",
        type:"GET",
        beforeSend:()=>{
          $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='../public/images/loading.gif'></div><div class='col-md-4'></div></div>");
          $("#modal").show();
        },
        success:(data)=>{
          $("#modal-content").html(data)

        }
      })
    })
  })
</script>
<?php
}else{?>
<!-- <h1 class="logo mr-auto"><a href="/">Onzae Bookings<span>.</span></a></h1> -->
  <nav class="nav-menu d-none d-lg-block">
    <ul>
      <li class="active"><a href="/">Home</a></li>
      <li><a href="about">About us</a></li>

      <li><a href="properties.php">Properties</a></li>
      <li><a href="events">Events</a></li>
      <li class="drop-down"><a href="#"><i  class="fa fa-user"></i></a>
        <ul>
          <li><a href="register" id="signupLink">Signup</a></li>
          <li><a href="login" id="loginLink">Signin</a></li>
        </ul>
      </li>
      <li><a href="contact-us">Contact Us</a></li>
    </ul>
  </nav>
  <script type="text/javascript">
    $(document).ready(()=>{
      $("#signupLink").on("click",e=>{
        e.preventDefault()
          $.ajax({
            url:"../register.php",
            type:"GET",

            beforeSend:function(){
              $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='../public/images/loading.gif'></div><div class='col-md-4'></div></div>")

              $("#modal").fadeIn("slow")
             },
            success:function(data){

              $("#modal-content").html(data)
              $("#modal").show()
            }
          })
})

      //signin form
      $("#loginLink").on("click",(e)=>{
        e.preventDefault();
        $.ajax({
          url:"../login.php",
          type:"GET",
          beforeSend:function(){
            // $("#modal-content").html("")
            //
          },
          success:function(data){


              $("#modal-content-sm").html(data)
              $("#modal-sm").fadeIn("slow")

          },
          error:()=>{
            $("#modal-content-sm").html("Error");
            $("#modal-sm").show()
          }
        })
      })
    })
  </script>
  <?php
}
?>

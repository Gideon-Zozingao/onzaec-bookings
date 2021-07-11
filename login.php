<?php
session_start();
if(!isset($_SESSION['logedin'])){
  // include("views/layout.php");
  //  $page_tittle="Onaze-Bookings || Login";?>
    <!-- ======= Header ======= -->
      <div  class="container">
        <div  class="col-md-12">
          <div id="resposnse" class="alert text-center"></div>
          <p id="message" class="alert text-center"></p>
            <div  class="card" id="form-card">
              <div  class="card-header" >
                <h1 class="text-primary text-center">
                  Login
                </h1>
              </div>
              <div  class="card-body">
          <form action="controllers/user-login" method="POST" id="loginForm">
            <div  class="form-group">
              <label>Useranme</label>
              <input  type="text" placeholder="Username"class="form-control form-control-lg"  name="username"/>
            </div>
            <div  class="form-group">
              <label>Password</label>
              <input  type="password" placeholder="Password" name="userPassword"  class="form-control form-control-lg"/>
            </div>
            <div  class="form-group">
              <button class="btn-lg btn-primary btn-block"  name="login-btn">Login</button>
            </div>
          </form>
          </div>
        </div>
        </div>

      </div>
  <script>
  $(document).ready(function(){
    $("#loginForm").on("submit",function(e){
      e.preventDefault();
      $.ajax({
        url:"../controllers/user-login.php",
				type:"POST",
				data:new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
        beforeSend : function(){
          $("#message").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='../public/images/loading.gif'></div><div class='col-md-4'></div></div>").show()
        },
        success:function(data){
          $("#message").hide();
          var realData=JSON.parse(data)
          if(realData.alert_type=="error"){
            //$("#modal-top-content").css("background-color","red")
            $("#modal-top-body").html("<p class=' text-center text-danger'>"+realData.message+"</p>");
            $("#modal-top").fadeIn("slow")
            setTimeout(function(){
              $("#modal-top").fadeOut('slow')
            },5000)
          //  console.log(realData.message);
          }else{
            $("#loginForm")[0].reset();
            $("#form-card").hide()
            $("#modal-top-body").html("<p class='h6 text-center text-success'>"+realData.message+"</p>");
            $("#modal-top").fadeIn("slow")
            $("#modal-sm").hide()
            setTimeout(function(){

              // $("#modal-top").hide();
              window.location.replace("/")
            },2000);
          }
        },
        error:function(error){
          $("#message").hide();
          $("#resposnse").html("<h3 class='text-danger'>"+data+"</h3>")
          $("#alert").fadeIn()
        }
      })
    })
  })
  </script>
  </body>
  <?php
}else{
?>
<div class="col-md-4 offset-4 text-center etxt-success">
<h5>You are alredy logged in</h5>
</div>
<?php
}?>

<?php
//star the session
session_start();
//check for sesion variables
if(isset($_SESSION['logedin'])&&$_SESSION['logedin']==true){
  echo"You are already Logged in";
}else{?>
<!-- <h5 class="text-center">Register for Our Premiun Services and Offers</h5> -->
    <section>
      <div  class="container">
        <div  class="card" id="form-card">
          <div  class="card-header">
            <h4 class="text-primary text-center">
              User  Registation
            </h4>
          </div>
          <div  class="card-body">
      <!-- ===registration form=== -->
      <form action="controllers/register-user"  method="POST" enctype="multipart/form-data" id="user_reg_form">
        <div  class="container">
          <h3>Personal  Details</h3>
          <div  class="row">
            <div  class="form-group col-md-6">
              <label>Name</label>
              <input  type="" name="name" placeholder="Name"  class="form-control form-control-lg"/>
            </div>
            <div  class="form-group col-md-6">
            <label>Surname</label>
            <input  type="" name="surname" placeholder="Surname"   class="form-control form-control-lg"/>
            </div>
          </div>
          <div  class="row">
            <div  class="form-group col-md-6">
            <label>Date Of  Birth</label>
            <input  type="date" name="dateOfBirth" placeholder="Date  Of  Birth"  class="form-control form-control-lg"/>
            </div>
            <div  class="form-group col-md-6">
            <label>Gender</label>
            <select name="gender" placeholder=""  class="form-control form-control-lg">
              <option>Gender</option>
              <option  value="Male">Male</option>
              <option  value="Female">Female</option>
              <option  value="Other">Neither</option>
            </select>
            </div>
          </div>
          <div  class="row">
            <div  class="form-group col-md-6">
            <label>Country</label>
              <input  type="text" name="userCountry" placeholder="Country"  class="form-control form-control-lg"/>
            </div>
            <div  class="form-group col-md-6">
            <label>Postal Address</label>
            <input  type="text" name="postalAddress" placeholder="Postal  Address"  class="form-control form-control-lg"/>
            </div>
          </div>
          <div  class="row">
            <div  class="form-group col-md-6">
            <label>State</label>
            <input  type="text" name="userState" placeholder="State"  class="form-control form-control-lg"/>
            </div>
            <div  class="form-group col-md-6">
            <label>Phone</label>
            <input  type="text" name="userPhone" placeholder="Phone Number"  class="form-control form-control-lg"/>
            </div>
          </div>
          <div  class="row">
            <div  class="form-group col-md-6">
              <label>Email</label>
              <input  type="text" name="userEmail" placeholder="Email" class="form-control form-control-lg"/>
            </div>
            <div  class="form-group col-md-6">
            <label>Avata</label>
            <input  type="file" name="avata" class="form-control form-control-lg" accept="image/*" />
            </div>
          </div>
            <h3>User  Account Credentials</h3>
          <div  class="row">
            <div  class="form-group col-md-4">
              <label>Username</label>
              <input  type="text" name="username"  placeholder="username"  class="form-control form-control-lg">
            </div>
            <div  class="form-group col-md-4">
              <label>Password (8+ characcters)</label>
              <input  type="password" name="password"  placeholder="Password"  class="form-control form-control-lg">
            </div>
            <div  class="form-group col-md-4">
              <label>Confirm  Password</label>
              <input  type="password" name="cPassword"  placeholder="Confirm  Password"  class="form-control form-control-lg">
            </div>
          </div>
          <div id="response" class="text-center">
          </div>
          <hr>
          <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4">
              <button type="submit" name="user_reg_btn"class=" btn-primary btn-lg  btn-block">REGISTER</button>
            </div>
            <div class="col-md-4">

            </div>
          </div>
        <div  clas="from-control">

        </div>
        </div>
      </form>
      <!-- ====registration form ends== -->
      </div>
    </div>

  </div>
    </section>
  <br>
  <br>
<?php //include("./views/footer-1.php");
}?>
<script type="text/javascript">
  $(document).ready(function(){
    $("#user_reg_form").on("submit",function(e){
          e.preventDefault();
      $.ajax({
            url:"controllers/register-user.php",
            type:"POST",
            data:new FormData(this),
            contentType:false,
            cache:false,
            processData:false,
            beforeSend : function()
               {
                // $("#response").html("Processing data...")
                    $("#response").html("<img src='public/images/loading.gif'>");
                },
                success:function(data){

                    var realData=JSON.parse(data);
                    setTimeout(()=>{
                      $("#response").html("")
                      $("#modal-top").fadeIn("slow")
                      if(realData.alert_type==="error"){
                        $("#modal-top-body").html("<span  class=' text-center text-danger'>"+realData.message+"</span>")
                        //$("#response").html("").fadeIn('slow');
                        setTimeout(()=>{$("#modal-top").fadeOut("slow")},3000)
                }else{
                  $("#user_reg_form")[0].reset();
                  $("#modal-top-body").html("<span  class=' text-success text-center'>"+realData.message+"</span>")
                  //$("#response").html("").fadeIn('slow');
                  setTimeout(()=>{$("#modal-top").fadeOut("slow")},1000)
                $("#modal-content").load("login.php");
                  }

                },100)

          ;
        }
      })
    })
  })
</script>
</body>

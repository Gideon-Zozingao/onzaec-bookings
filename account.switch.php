<?php
session_start();
if(isset($_SESSION['logedin'])&&$_SESSION['logedin']==true){
  //include("views/layout.php");
  include("controllers/config.php");
  include('controllers/classes/db-class.php');
  $thisdb=new db($h,$u,$pass,$db);
  $conn=$thisdb->connect();
?>
  <div  class="container">
    <?php
    if(isset($_GET['action'])&&$_GET['action']=="switchAccount"){
      $action=$_GET['action'];
      $accountId=$_GET['to'];
      $userType=$_GET["uType"];
      if($userType==="general"){
        header("Location:./");
      }
      $q2="SELECT*FROM  user_accounts  WHERE accId='$accountId'";
      $query2=mysqli_query($conn,$q2);
      if($query2==true){
        $results2=mysqli_num_rows($query2);
        if($results2>0){
          $row2=mysqli_fetch_array($query2);
          ?>

            <div  class="col-md-10 offset-1">
              <div  class="card" id="form-card">
                <div  class="card-header">
                  <p  class="h5">You  are switching to  <span class="text-primary"><?php echo $row2['accountName']; ?></span>  </p>
                </div>
                <div  class="card-body">
                  <form method="POST" action="controllers/account.switch.confirm" id="accountSwitchForm">
                    <p>Reconfirm  Your  Password</p>
                    <input  type="hidden"  name="to"  value="<?php echo $accountId?>">
                    <input  type="hidden"  name="userType"  value="<?php echo $userType?>">
                    <input  type="hidden"  name="accountType"  value="<?php echo$row2['accountType']?>">
                    <div  class="form-group">
                    <input  type="password"class="form-control form-control-lg"  placeholder="password"  name="password"  id="cPassword"></div>
                    <hr>
                    <div class="" id="response">

                    </div>
                    <div  class="form-group">
                      <button type="submit"class="btn-primary btn-lg btn-block" name="account-switch-confirm-btn">CONFIRM</button>
                      </div>
                  </form>
                </div>
                <div  class="card-footer">
                  <a href="account.switch" id="account-switch">Switch  Account</a
                </div>
              </div>
              </div>

<script type="text/javascript">
  $(document).ready(function(){
    $("#account-switch").on("click",(e)=>{
      e.preventDefault();
      $.ajax({
        url:"account.switch.php",
        type:"GET",
        beforeSend:()=>{
          $("#modal").fadeOut();
          $("#modal-content-sm").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>");
          $("#modal-sm").show();
        },
        success:(data)=>{
          $("#modal-content-sm").html(data)

        }
      })
    })



    $("#accountSwitchForm").on("submit",function(e){
      e.preventDefault()
      //alert("Switching Accout");
      $.ajax({
        url:"../controllers/account.switch.confirm",
        type:"POST",
        data:new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
        beforeSend:function(){
          $("#response").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")

        //$("#modal").show()
        },
        success:function(data){
          $("#response").html("")
          var jsonData=JSON.parse(data);
          if(jsonData.alert_type=="success"){
            $("#modal-top-body").html(`<span class="text-center text-success h6">${jsonData.message}</span>`);
            $("#modal-sm").fadeOut("slow")
            $("#modal-top").fadeIn("slow");

            setTimeout(()=>{
              if(jsonData.accountType=="propertyacc"){
                window.location.replace("/account")
              }else{
                window.location.replace("/")
              }
            },2000)

          }else{
            $("#modal-top-body").html(`<span class="text-danger text-center h6">${jsonData.message}</span>`);
            $("#modal-top").fadeIn("slow");
            setTimeout(()=>{
              $("#modal-top-body").html("")
              $("#modal-top").fadeOut("slow");
          },2000)
        }
      }
    })
  })
  })
</script>
          <?php
        }
      }else{
        echo mysqli_error($conn);
      }
    }else{
      if($conn==true){
      $qery1="SELECT*FROM user_accounts WHERE accoutOwnerId='$_SESSION[id]'";
      $query=mysqli_query($conn,$qery1);
      if(!$query){
      die(mysqli_error($query));
      }
      $results=mysqli_num_rows($query);
      if($results>0){
      ?>
<div class="card">
  <div class="card-body">




      <?php
      while($rows=mysqli_fetch_array($query)){
      ?>



          <p class="h4 "><?php echo$rows['accountName']?></p>


          <p>Your are <?php echo$rows['userType']?>  user of this account</p>
          <p>Joined @ <?php echo$rows['registrationDate']?></p>


          <nav class="navbar">
            <a href="?action=switchAccount&to=<?php echo$rows["accId"]?>&uType=<?php echo$rows['userType']?>" class="text-primary h5 accountSwitButton" accessKey="<?php echo$rows["accId"]?>" name="<?php echo$rows['userType']?>">Sign in</a>
          </nav>
        <hr>


      <br>
      <?php
      }?>

      <script type="text/javascript">
        $(document).ready(()=>{
          var accountSwitButton=$(".accountSwitButton");
          for(let i=0; i<accountSwitButton.length;i++){
            $(accountSwitButton[i]).on("click",(e)=>{
              e.preventDefault();
              $.ajax({
                url:`../account.switch.php?action=switchAccount&to=${accountSwitButton[i].accessKey}&&uType=${accountSwitButton[i].name}`,
                type:"GET",
                beforeSend:()=>{
                  $("#modal").fadeOut("slow")
                   $("#modal-content-sm").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
                   $("#modal-sm").show()
                 },
                success:(data)=>{
                  $("#modal-content-sm").html(data)
                }
              })
            })
          }
        })
      </script>
      </div>
      </div>
      <?php
      }else{
      die("You  do not have Accounts  Attached  to  you");
      }
      }
    }
    ?>
  </div>
  <br>
  <?php
//include("./views/footer-1.php");


}else{
    header("Location:./");
}

?>

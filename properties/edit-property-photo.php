<?php
include("../controllers/config.php");
include('../controllers/classes/db-class.php');
include("../controllers/data-sanitiation.php");
$thisdb=new db($h,$u,$pass,$db);
$conn=$thisdb->connect();
session_start();
if(isset($_SESSION['logedin'])&&$_SESSION['account']==="advanced"&&$_SESSION['accountType']=="propertyacc"){
  if($_SERVER["REQUEST_METHOD"]=="POST"&&isset($_POST["photoAltext"])&&isset($_POST['photoId'])){
    $respose=Array("responseTyp"=>"","responseMessage"=>"");
    $photoAltext=filterName($_POST["photoAltext"]);
    if($photoAltext===FALSE){
      $respose['responseTyp']="error";
      $response['responseMessage']="Invalid Alt Text  Format";
      die(json_encode($response));
    }
$editphotoSql="UPDATE propertyphotos SET photoAltext='$_POST[photoAltext]' WHERE photoId='$_POST[photoId]'";
 $editphotoEditquery=mysqli_query($conn,$editphotoSql);
 if($editphotoEditquery==true){
   $respose['responseTyp']="success";
   $response['responseMessage']="Image  Data Updated successfully";
   die(json_encode($response));
 }else{
   $respose['responseTyp']="error";
   $response['responseMessage']="Your Image Data Cannot Be Updated Due to Some Technical faults";
   die(json_encode($response));
 }
}
  if($_SERVER["REQUEST_METHOD"]=="GET"&&isset($_GET["photo"])){
    $photooSql="SELECT *FROM propertyphotos WHERE photoName='$_GET[photo]'";
    $photoQuery=mysqli_query($conn,$photooSql);
    if($photoQuery==true){
        $photos=mysqli_num_rows($photoQuery);
        if($photos>0){
          $photorows=mysqli_fetch_array($photoQuery);
          ?>
          <div class="" id="photoarea">
            <img src="../public/gallery/images/<?php echo $photorows['photoName']?>" alt="<?php echo $photorows['photoAltext']?>" class="img-responsive img-fluid">
          <br>
          <form class="" action="properties/edit-property-photo.php" method="POST" id="phtoDetailEditForm">

            <div class="" id="photoTextArea">
              <input type="hidden" name="photoId" value="<?php echo
              $photorows['photoId']?>">
              <label for="photoAltext">Photo Details</label>
              <input type="text" name="photoAltext" value="<?php echo $photorows['photoAltext']?>" class="form-control form-control-lg">
            </div>
            <hr>
            <div class="row">
                  <div class="col-md-4">
                  </div>
                  <div class="col-md-4">
                      <button type="submit" class="btn-primary btn-lg btn-block">Edit Details Now</button>
                  </div>
                  <div class="col-md-4">
                  </div>
            </div>
          </form>
          </div>
          <script type="text/javascript">
            $(document).ready(()=>{
              $("#phtoDetailEditForm").on("submit",function(e){
                e.preventDefault();
                $.ajax({
                  url:"properties/edit-property-photo.php",
          				type:"POST",
          				data:new FormData(this),
          				contentType:false,
          				cache:false,
          				processData:false,
                  beforeSend : ()=>{
                    $("#modal-top-body").html("Processing Data...")
                    $("#modal-top").fadeIn("slow")
                  },
                  success:data=>{
                    const realData=JSON.parse(data);
                    if(realData.responseTyp=='error'){
                      $("#modal-top-body").html(`<h6 class=" text-danger">${realData.responseMessage}</h6>`);
                    }else{
                      $("#modal-top-body").html(`<h6 class=" text-success">${realData.responseMessage}</h6>`);
                    }
                      setTimeout(()=>{
                      $("#modal-top").fadeOut()
                    },3000)
                    window.location.replace("")
                  }
              })
            })
            })
          </script>

          <?php
        }else{
            echo "Photo Does Not Exist at this Time";
      }
    }else{
      echo "Photo Cannot Be displayed Due to some Technical issues.. Please try again Later";
  }
  }
?>
<?php
}else{
?>
<h1>	Unable to Edit Photo</h1>
<?php
}
?>

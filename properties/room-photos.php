<?php
session_start();
if(!isset($_SESSION['logedin'])){
  ?>
<h3 class="text-center text-muted">You are Not Logged in</h3>
<p class="text-center">You need to be logged in ot acces this sections</p>
  <?php
  die();
}
if(!isset($_SESSION['account'])&&($_SESSION['account'])!=="advanced"){
?>
  <h3 class="tet-muted text0-center">You dont have access rights for this sections</h3>
<?php
  die();
}
include("../controllers/config.php");
include('../controllers/classes/db-class.php');
//session_start();
$thisdb=new db($h,$u,$pass,$db);
$conn=$thisdb->connect();
//checking for database connection
if(!$conn){
  ?>
<h3 class="text-muted text-center"> You cannot access the content of this section at this time</h3>
<p class="text-muted text-center">System encountered dificulties connecting to tthe database</p>
  <?php
  die();
}
switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':

  if(isset($_GET['action'])&&$_GET['action']=="viewPhotoUploadForm"){
     //"
  ?>

<div class="card" id="form-card">

  <div class="card-body">
    <div class="" id="uploadImagePreview">
    </div>
    <section>
      <div class="">
        <form class="" action="" method="post" id="roomPhotoUploadForm" enctype="multipart/form-data">
          <input type="hidden" name="roomId" value="<?php echo $_GET['roomID']?>">
          <img id="roomImage" class="img-responsive img-fluid" src="public/images/image-icon.png"  />
          <input type="file" name="roomPhoto"  id="roomPhoto" accept="image/*" style="display:none">
          <hr>
    <div id="respose">

    </div>
           <button type="submit" name="button" class="btn-lg btn-primary btn">Upload Now</button>
        </form>
      </div>
    </section>
  </div>

</div>


  <hr>
  <script type="text/javascript">
    $(function(){
      $("#roomPhotoUploadForm").on("submit",function(e){
        e.preventDefault();
        $.ajax({
          url:"properties/room-photos.php",
          type:"POST",
          data:new FormData(this),
          contentType:false,
          cache:false,
          processData:false,
          beforeSend:function(){
            $("#respose").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
          },
          success:function(data){
            var JSONdata=JSON.parse(data)
             $("#respose").html("");
            if(JSONdata.response_type=="success"){
              alert("Success")
              $("#roomPhotoUploadForm")[0].reset();
              setTimeout(()=>{
               

                $("#modal-top-body").html(`<span class='text-center text-succes'>   ${JSONdata.response_message}</span>`)

                $("#modal-top").fadeIn("slow");
                
              },1500)
              
              setTimeout(()=>{
                $("#respose").html("")
                $("#modal-top").fadeOut("slow");

                $("#imageDisplay").load("properties/room-photos.php?roomID=<?php echo $_GET['roomID']?>&viewLink=roomPhotosLink")

              },3000)

            }else{
              alert("Error")
              setTimeout(()=>{
               
                $("#modal-top-body").html(`<span class="text-danger>${JSONdata.response_message}</span ">`)
                $("#modal-top").fadeIn("slow");
              },1500)
              setTimeout(()=>{
                $("#modal-top").fadeOut("slow");
              },3000)
            }

          }
        })
      })
    })
  </script>
  <script type="text/javascript">
    //image uploda preview
      $(function(){
        $("#roomImage").mouseover(()=>{
          $("#roomImage").css("cursor","pointer")
        })
        $("#roomImage").click(()=>{
          $("#roomPhoto").click()
        })
          $("#roomPhoto").on("change", function(){
            var file = this.files[0];
            var image=document.getElementById("roomImage")
          var readImg = new FileReader();
          readImg.readAsDataURL(file);

              //if (!files.length || !window.FileReader) return; // no     file selected, or no FileReader support
              readImg.onload = (e)=> {
                $('#roomImage').attr('src', e.target.result).fadeIn();

                var width=image.naturalWidth;
                var height=image.naturalHeight;
                // var  screenWidth=image.width;
                // var screenHeight=image.height;
                alert(` ${width}px X ${height}px`)
                // alert(`screenWidth: ${screenWidth} screenHeight: ${screenHeight}`)
            }
          });
      });
  </script>
  <?php
  }




  if(isset($_GET['roomID'])&&isset($_GET['viewLink'])){

    switch ($_GET['viewLink']) {
      case 'uploadNewCoverPhoto':

      ?>
      <h3 class="text-muted text-center">Upload a new Cover Photo  for this room</h3>

        <form class="" action="" method="post" id="coverPhototUplodaForm" enctype="multipart/form-data">
          <input type="hidden" name="roomId" value="<?php echo $_GET['roomID']?>">
          <div class="col-md-4 offset-4">
            <label for="">Insert an Image File </label>
            <input type="file" name="coverPhoto" id="cover_photo" >
          </div>

          <div class="" id="uploadImagePreview">

          </div>
          <hr>
          <div class="col-md-4 offset-4">
          <button type="submit" class="btn-primary btn-lg">Uload Photo</button>
          </div>
        </form>

      <script type="text/javascript">
        //image uploda preview
          $(function(){
              $("#cover_photo").on("change", function(){
                  var files = !!this.files ? this.files : [];
                  if (!files.length || !window.FileReader) return; // no     file selected, or no FileReader support
                  if (/^image/.test( files[0].type)){ // only image file
                      var reader = new FileReader(); // instance of the FileReader
                      reader.readAsDataURL(files[0]); // read the local file
                      reader.onloadend = function(){ // set image data as background of div
                          $("#uploadedImagePreview").css("display","block");
                          $("#uploadImagePreview").css("background-image", "url("+this.result+")");

                          $("#uploadImagePreview").css("background-size", "100%");

                          $("#uploadImagePreview").css("max-height","100%");
                          //$("#uploadImagePreview").css("max-width","200vh");
                          //
                          $("#uploadImagePreview").css("min-height","100%");
                          $("#uploadImagePreview").css("min-width","100%");
                          $("#uploadImagePreview").css("background-repeat","no-repeat");
                      }
                  }
              });
          });
      </script>


      <script type="text/javascript">
        $(document).ready(function(){
          $("#coverPhototUplodaForm").on("submit",function(e){
            e.preventDefault();

            alert("Upload New Cover Photo");
          })
        })
      </script>
      <?php
      break;
      //Recived and Process coverPhotoLink request
      case 'coverPhotoLink':

        $selectRoomCoverPhoto="SELECT * FROM rooms WHERE roomId='$_GET[roomID]'";
        $selectRoomCoverPhotoQuery=mysqli_query($conn,$selectRoomCoverPhoto);
        if($selectRoomCoverPhotoQuery==true){
        $selectRoomCoverPhotoQueryResults=mysqli_num_rows($selectRoomCoverPhotoQuery);
        if($selectRoomCoverPhotoQueryResults>0){
        $ResultsArray=mysqli_fetch_array($selectRoomCoverPhotoQuery);
        ?>

        <div id="imageDisplay">

          <img src="../public/gallery/images/<?php echo $ResultsArray['roomCoverPhoto']?>" alt="" class="img-responsive img-fluid">
        <!-- coverPhotoLink -->
        </div>




<a href="#" id="uploadNewCoverPhoto">Upload New Cover Photo</a>
<script type="text/javascript">
  $(document).ready(function(){
    $("#uploadNewCoverPhoto").on("click",(e)=>{
      e.preventDefault();
    //#imageDisplay"

    $.ajax({
      url:"properties/room-photos.php?roomID=<?php echo $ResultsArray['roomId']?>&&viewLink=uploadNewCoverPhoto",
      type:"GET",
      beforeSend:function(){
        $("#imageDisplay").html("")
      },
      success:function(data){
        $("#imageDisplay").html(data)
      }
    })

    })
  })
</script>
<?php

}else{
?>
  <h3 class="text-center text-muted">Informatioon for this room is not available at the moment</h3>
<?php
}
}else{
  ?>
<h3 class="text-muted text-center">Cannot access your Cover Photo Now</h3>

  <?php
}




        break;
        case 'roomPhotosLink':

        try {
          $selectRoomPhoto="SELECT * FROM rooms JOIN roomphotos ON rooms.roomId=roomphotos.roomId WHERE roomphotos.roomId='$_GET[roomID]'";
          $selectRoomPhotoQuery=$conn->query($selectRoomPhoto);
          $selectRoomPhotoQuery->setFetchMode(PDO::FETCH_ASSOC);
          $selectRoomPhotoQueryResults= $selectRoomPhotoQuery->rowCount();


            if($selectRoomPhotoQueryResults>0){
              ?>

                <div class="row ">
              <?php
              while($ResultsArray=$selectRoomPhotoQuery->fetch()){
                ?>
                <div class=" col-md-4">
                <img src="public/gallery/images/<?php echo $ResultsArray["photoName"]?>" class="img-fluid img-responsive" alt="<?php echo $ResultsArray['photoAltText']?>">
                <div class="portfolio-info">
                <a href="public/gallery/images/<?php echo $ResultsArray["photoName"]?>" data-gall="portfolioGallery" class="venobox preview-link vbox-item" title="<?php echo $ResultsArray['photoAltText']?>"><i class="bx bx-plus"></i></a>
                <a href="" class="details-link" title="<?php echo$ResultsArray['photoAltText']?>"><i class="bx bx-x"></i></a>
                <a href="#" class="details-link edit-photo" title="<?php echo $ResultsArray["photoAltText"]?>" accessKey="<?php echo $ResultsArray["photoName"]?>"><i class="bx bx-edit"></i></a>
                </div>
                </div>
                <br>
                <?php
                //echo $ResultsArray["photoName"]."<br>";
              }?>


            </div>

            <hr>
            <h6 class="text-center text-primary"> <a href="#" id="uploadNewPhotoLink">Upload New Photos Now</a> </h6>
              <?php

            }else{
              ?>
              <h5 class="text-muted text-center"> No Photos Available for this room</h5>

                  <h6 class="text-center text-primary"> <a href="#" id="uploadNewPhotoLink">Upload New Photos Now</a> </h6>
              <?php
            }
            ?>

            <script type="text/javascript">
              $(document).ready(()=>{
                $("#uploadNewPhotoLink").on("click",function(e){
                  e.preventDefault();
                  //alert("Hello");
                  $.ajax({
                    url:"properties/room-photos.php?action=viewPhotoUploadForm&roomID=<?php echo $_GET['roomID']?>",
                    type:"GET",
                    beforeSend:function(){
                      $("#imageDisplay").html("Loding...");
                    },
                    success:function(data){
                      $("#imageDisplay").html(data)
                    }
                  })
                })
              })
            </script>
<?php

        } catch (Exception $e) {
          echo $e->getMessage();
        }
          // code...
          
          break;
      default:
        // code...
        break;
    }
  }
    // code...
if(isset($_GET["roomId"])){

  try {
    $selectRoomCoverPhoto="SELECT * FROM rooms WHERE roomId='$_GET[roomId]'";
  $selectRoomCoverPhotoQuery=$conn->query($selectRoomCoverPhoto);
  $selectRoomCoverPhotoQuery->setFetchMode(PDO::FETCH_ASSOC);
  $selectRoomCoverPhotoQueryResults=$selectRoomCoverPhotoQuery->rowCount();
if($selectRoomCoverPhotoQueryResults>0){
  $ResultsArray=$selectRoomCoverPhotoQuery->fetch();
  ?>
  <a href="" id="coverPhotoLink" >Cover Photo</a> | <a href=""  id="roomPhotosLink" >Room Photos</a>
  <hr>
  <div id="imageDisplay">


    <img src="../public/gallery/images/<?php echo $ResultsArray['roomCoverPhoto']?>" alt="" class="img-responsive img-fluid">
  <!-- coverPhotoLink -->
  </div>
  <script type="text/javascript">
    $(document).ready(function(){

  //coverPhoto link Clicking event handlig
      $("#coverPhotoLink").on("click",(e)=>{
        e.preventDefault()
        //alert("View this Room Cover Photo")

        $.ajax({
          url:"properties/room-photos.php?roomID=<?php echo $ResultsArray['roomId']?>&viewLink=coverPhotoLink",
          type:"GET",
          beforeSend:function(){
            $("#imageDisplay").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>");
          },
          success:function(data){
            $("#imageDisplay").html(data)
          }
        })
      })

      //roomPhotosLink Clcking event Handler

      $("#roomPhotosLink").on("click",(e)=>{
        e.preventDefault();
        //alert("View this Rooms's Photos");

              $.ajax({
                url:"properties/room-photos.php?roomID=<?php echo $ResultsArray['roomId']?>&viewLink=roomPhotosLink",
                type:"GET",
                beforeSend:function(){
                  $("#imageDisplay").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>");
                },
                success:function(data){
                  $("#imageDisplay").html(data)
                }
              })
      })
    })
  </script>
  <?php
  }else{
    ?>
  <h3 class="text-center text-muted">The information about this room no longer exist</h3>
    <?php
  }
  } catch (Exception $e) {
    echo $e->getMessage();
  }
  
      ?>
      <?php
}

    break;

    case 'POST':
      // code...

      $response=Array("response_type"=>"","response_message"=>"","response_note"=>"");
        if(isset($_FILES['roomPhoto'])&&isset($_POST['roomId'])){

          //allowed immage files
          $validExtensions = Array("jpeg", "jpg", "png");
          if($_FILES['roomPhoto']['name']==""){
            $response["response_type"]="error";
            $response["response_message"]="No Image file Inserted";
            $response["response_note"]="Please Inserted an Image submit the Form again";
            echo (json_encode($response));
            die();
          }

          $temp=explode(".",$_FILES['roomPhoto']['name']);
          if(!in_array(end($temp),$validExtensions)){
            $response["response_type"]="error";
            $response["response_message"]=end($temp)." file is not allowed";
            $response["response_note"]="Please upload  a valid Image File [jpg,jpeg  or  PNG file]";
            die(json_encode($response));
            
          }
          //rename the image
          $newFileName="ONZAEC-IMG".date("YmdHis").round(microtime(true)).".".end($temp);
          //upload the image
          $upload=move_uploaded_file($_FILES['roomPhoto']["tmp_name"],"../public/gallery/images/".$newFileName);

          //confirm if the file ahs neen uploaded
          if($upload!=true){
            $response["response_type"]="error";
            $response["response_message"]="Image Upload Not Successful";
            $response["response_note"]="Unable to Upload File";
            echo(json_encode($response));
            die();
          }


          $photoId=date("YmdHis");
          $creationDate=date("Y-m-d");

try {
          $sql="INSERT INTO roomPhotos VALUES('$photoId','$newFileName','$_POST[roomId]','','$creationDate')";
          $query=$conn->query($sql);
          $count=$query->rowCount();
          if($count>0){
            $response["response_message"]="Photo Uloade Successfully";
            //$response["response_note"]="Unable to Upload File";
            echo(json_encode($response));
            die();
          }else{
            $response["response_type"]="error";
            $response["response_message"]="Photo Uloade Unsucessful";
            $response["response_note"]="Application Error ";
            echo(json_encode($response));
          }

  
} catch (Exception $e) {
            $response["response_type"]="error";
            $response["response_message"]=$e->getMessage();
            $response["response_note"]="Application Error ";
            echo(json_encode($response));
  
}
          //register photo information to the Database
 
}
      break;

  default:
    // code...
    break;
}
?>

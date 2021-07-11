<?php
if(!isset($_SESSION["logedin"])){
die('You Cannot Acces this Section');
}
if(!isset($_SESSION["account"])&&!isset($_SESSIPON["accountType"])){
die("You  cannot  Acces this section");
}
?>
<section class="col-md-10 offset-1">
  <br>

<div  class="card" id="form-card">
<div  class="card-header ">
  <h1 class="text-primary text-center">Room Registration</h1>
</div>
<div  class="card-body">
  <form action="../controllers/room-listing.php" method="POST" enctype="multipart/form-data"  id="roomRegForm">
    <div  class="row">
        <div  class="form-group col-md-4">
          <label>Room name/Room number</label>
          <input  type="text" class="form-control form-control-lg"  name="roomname"/>
        </div>
        <div  class="form-group col-md-4">
        <label>Room Category</label>
        <input  type="text" class="form-control form-control-lg"  name="roomcategory"/>
        </div>
        <div  class="form-group col-md-4">
        <label>Floor  number</label>
        <input  type="number"   name="floor" class="form-control form-control-lg"/>
        </div>
    </div>
    <div  class="row">
        <div  class="form-group col-md-4">
          <label>Number of People </label>
          <input  type="number" name="numbber_of_people" class="form-control form-control-lg"/>
        </div>
        <div  class="form-group col-md-4">
        <label>Number of  beds</label>
        <input  type="number" class="form-control form-control-lg"  name="number_of_beds"/>
        </div>
        <div  class="form-group col-md-4">
        <label>Bed  Size  ( cm <sup>2</sup> )</label>
        <input  type="text" class="form-control form-control-lg"  name="bed_size"/>
        </div>
    </div>
    <div  class="row">
        <div  class="form-group col-md-3">
          <label>Rate  (K)</label>
          <input type="text"class="form-control form-control-lg"  name="rate"/>
        </div>
        <div  class="form-group col-md-3">
          <label>GST (%)</label>
          <input type="text"class="form-control form-control-lg" name="gst"/>
        </div>
    </div>
    <div  class="row">
        <div  class="form-group col-md-12">
          <label>Additional Features</label>
          <textarea class="form-control " row="9" cols="15"  name="additional_features"></textarea>
        </div>
    </div>
    <div  class="row">
        <div  class="form-group col-md-12">
          <label>Room Description</label>
          <textarea class="form-control " rows="9" cols="15"  name="room_description"></textarea>
        </div>
    </div>
    <div  class="row">
    <div  class="form-group col-md-12">
      <label>Room Cover</label>
      <hr>
      <input  type="file" name="cover_photo" class="file" id="cover_photo" accept="image/*" style="display:none">
      <!-- preview uplodaed image -->
      <!-- <div  id="uploadedImagePreview">
        <div  id="imagePreview" >
        </div>
      </div> -->
      <img src="../public/images/image-icon.png" alt="" id="ImagePreview" class="img-fluid img-responsive">
      <p id="image-dimensions"></p>
    </div>
</div>
<div  class="row">
    <div  class="form-group col-md-3">
      <label>Publishing Status</label>
      <select class="form-control form-control-lg"  require="true"  name="publication_status">
        <option ></option>
        <option value="Under  Review">Publish  After Review</option>
        <option value=" Published">Publish Now</option>
      </select>
          </div>
</div>
    <hr>
    <div  clasee='row'>
    <div  class="col-md-12" >
      <div id="resposnse" class="alert text-center"></div>
    </div>
  </div>
    <div  class="row">
      <div  class="col-md-4">
      </div>
      <div  class="col-md-4">
        <button type="submit"class="btn-primary  btn-lg  btn-block"  name="room_reg_btn" id="room_reg_btn">Save Room  Information</button>
      </div>
      <div  class="col-md-4">
        <h4 class="text-info" id="message"></h4>
      </div>
    </div>
    <br>
  </form>
  <script type="text/javascript">
    //image uploda preview
      $(function(){
        $("#ImagePreview").on("mouseover",()=>{
          $("#ImagePreview").css("cursor","pointer")
        })
        $("#ImagePreview").on("click",()=>{
          $("#cover_photo").click()
        })
          $("#cover_photo").on("change", function(){
            var file = this.files[0];
            var image=document.getElementById("ImagePreview")
          var readImg = new FileReader();
          readImg.readAsDataURL(file);

              //if (!files.length || !window.FileReader) return; // no     file selected, or no FileReader support
              readImg.onload = (e)=> {
                $('#ImagePreview').attr('src', e.target.result).fadeIn();

                var width=image.naturalWidth;
                var height=image.naturalHeight;
                $("#image-dimensions").html(`${width} x ${height} `)
            }
          });
      });
  </script>
  <script type="text/javascript">
  $(document).ready(function(){
    $("#roomRegForm").on('submit',function(e){
      e.preventDefault();
      $("#resposnse").html("");
      $.ajax({
        url:"controllers/room-listing.php",
				type:"POST",
				data:new FormData(this),
				contentType:false,
				cache:false,
				processData:false,
        beforeSend : function(){
          $("#modal-top-body").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>").show();
          $("#modal-top").fadeIn("")
        },
        success:function(data){
          var realData=JSON.parse(data);
          if(realData.msg_type=="error"){
            setTimeout(()=>{
              $("#resposnse").html("")
              $("#modal-top-body").html("<p class='text-danger'>"+realData.message+"</p>")
              $("#modal-top").fadeIn("slow");
            },1500)
            setTimeout(function(){
              $("#modal-top").fadeOut('slow')
            },3000);
          }else{
            setTimeout(()=>{
              $("#modal-top-body").html("<p class=' text-center text-success'>"+realData.message+"</p>")
              $("#modal-top").fadeIn('fast');
            },1500)


            $("#roomRegForm")[0].reset();

            setTimeout(function(){
              $("#resposnse").html('')
              $("#imagePreview").css("background-image", "");
              $("#imagePreview").css("max-height","0");
              $("#imagePreview").css("height","0");
            },3000);

          }
        },
        error:function(error){
          $("#message").hide();
          $("#resposnse").html("<h3 class='text-danger'>"+data+"</h3>")
          $("#alert").fadeIn()
        }
      })
    });
    //function form processing image uploda preview
  })
  </script>
</div>
</div>
</section>

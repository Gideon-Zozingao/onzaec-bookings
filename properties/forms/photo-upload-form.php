
<div class="card" id="photoUplodaForm">
<div class="card-body">
<h6  >Upload New Photo now</h6>
<form class="" action="controllers/upload-photos" method="post"  enctype="multipart/form-data" id="photo-uploads-form">
  <input type="file" name="propertyPhoto" id="photo" style="display:none" accept="image/*">
  <img id="imagePreview" class="img-responsive img-fluid" src="public/images/image-icon.png"  />
  <div class="col-md-12" id="uploading-message">
  </div>
  <input type="submit" name="propertyPhotouploadbtn" value="Upload"  class=" btn-primary  btn-lg" >
</form>
</div>
</div>
<script type="text/javascript">
    $(function(){
      $("#imagePreview").mouseover(()=>{
        $("#imagePreview").css("cursor","pointer")
      })
      $("#imagePreview").on("click",()=>{
        $("#photo").click()
      })
        $("#photo").on("change", function(){
          var file = this.files[0];
          var image=document.getElementById("imagePreview")
          var readImg = new FileReader();
          readImg.readAsDataURL(file);
          readImg.onload = (e)=> {
            $('#imagePreview').attr('src', e.target.result).fadeIn();
        }
        });
    });
</script>
<script type="text/javascript">
$(document).ready(()=>{
  $("#photo-uploads-form").on("submit",function(e){
    e.preventDefault();
    $.ajax({
      url:"controllers/upload-photos.php",
      type:"POST",
      data:new FormData(this),
      contentType:false,
      cache:false,
      processData:false,
      beforeSend : function(){
          $("#uploading-message").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'>Uploading...</div><div class='col-md-4'></div></div>");
      },
      success:function(data){
            var message=JSON.parse(data)
            if(message.alert_type==="success"){

              $("#modal-top-body").html(`<span class='text-center text-success'> ${message.message}</span>`)
            $("#modal-top").fadeIn("slow")
              $("#photo-uploads-form")[0].reset();
              $("#uploading-message").html("")
              setTimeout(()=>{
                $("#modal-top").fadeOut("slow")

                $('#imagePreview').attr('src', "public/images/image-icon.png").fadeIn();
              },3000)
            }else{
              $("#modal-top-body").html(`<span class='text-center text-danger'> ${message.message}</span>`)
              $("#modal-top").fadeIn("slow")
              $("#uploading-message").html("")
              setTimeout(()=>{
                $("#modal-top").fadeOut("slow")

              },3000)
            }
          }
})
})
})
</script>

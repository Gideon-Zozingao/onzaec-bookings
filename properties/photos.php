<div class="card">
  <div class="card-body">
    <h5>Photos | <button type="button" name="button" class="btn btn-light " id="photoUplodaBtn">Upload Photos</button> </h5>

    <script type="text/javascript">
      $(document).ready(()=>{
        $("#photoUplodaBtn").on("click",()=>{

            $.ajax({
              url:"properties/forms/photo-upload-form.php",
              type:"GET",
                beforeSend:()=>{
                  $("#modal-content-sm").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>");
                  $("#modal-sm").show()
              },
              success:(data)=>{
                setTimeout(()=>{
                  $("#modal-content-sm").html(data);
                },1500)

              },
              error:function(){
                $("#modal-content-sm").html("Error Loading the Content ");
                $("#modal-sm").show()
              }
            })
        })
      })
    </script>

    <?php
    $photosSlq="SELECT*FROM propertyphotos  WHERE propertyId='$_SESSION[account_id]'";
    $photosQuery=mysqli_query($conn,$photosSlq);
    $photosResults=mysqli_num_rows($photosQuery);
    if($photosResults>0){?>
    <div class="container aos-init aos-animate" data-aos="fade-up">
      <div class="row portfolio-container aos-init aos-animate" data-aos="fade-up" data-aos-delay="200" style="position: relative; height: 4283.42px;">
    <?php
    while($photosResultsRows=mysqli_fetch_array($photosQuery)){
    ?>
    <div class="col-lg-4 col-md-6 portfolio-item filter-app" style="position: absolute; left: 0px; top: 0px;">
    <img src="public/gallery/images/<?php echo $photosResultsRows['photoName']?>" class="img-fluid img-responsive" alt="<?php echo $photosResultsRows['photoAltext']?>">
    <div class="portfolio-info">
    <a href="public/gallery/images/<?php echo $photosResultsRows['photoName']?>" data-gall="portfolioGallery" class="venobox preview-link vbox-item" title="<?php echo $photosResultsRows['photoAltext']?>"><i class="bx bx-plus"></i></a>
    <a href="" class="details-link" title="<?php echo$photosResultsRows['photoAltext']?>"><i class="bx bx-x"></i></a>
    <a href="#" class="details-link edit-photo" title="<?php echo $photosResultsRows['photoAltext']?>" accessKey="<?php echo $photosResultsRows['photoName']?>"><i class="bx bx-edit"></i></a>
    </div>
    </div>
    <?php
    }
    ?>
    </div>
    </div>


    <?php
    }else{
    echo"No Photos Availabble";
    ?>
    <div class="card" id="photoUplodaForm" style="display:none">
      <div class="card-header">
        <h5 id="uploading-message">Upload  Photos  Now</h5>
      </div>
      <div class="card-body">
        <form class="" action="controllers/upload-photos" method="post"  enctype="multipart/form-data" id="photo-uploads-form">
          <input type="file" name="propertyPhoto" multiple="true"  accept="image/*">
          <input type="submit" name="propertyPhotouploadbtn" value="Upload"  class=" btn-primary  btn-lg" >
          </form>
      </div>
    </div>
    <?php
    }?>

    <script type="text/javascript">
      $(document).ready(function(){
        var editbtn=$(".edit-photo");
        for(i=0;i<editbtn.length;i++){
          $(editbtn[i]).on("click",function(e){
            e.preventDefault();
            var photoName=this.accessKey;
            $.ajax({
              url:`properties/edit-property-photo.php?photo=${photoName}`,
              type:"GET",
              beforeSend : function(){
                $("#modal-content-sm").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
                $("#modal-sm").show();
              },
              success:function(data){
                setTimeout(()=>{
                  $("#modal-content-sm").html(data)
                },1500)
              }
            })
          })
        }
      })
    </script>
  </div>
</div>

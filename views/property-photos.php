<?php

echo"<h1>Property Photos</h1>";
if(isset($_REQUEST["Propertylink"])){
//$row1;
$photoSql="SELECT *FROM propertyphotos WHERE propertyId='$row1[propertyId]'";
$photoQuery=mysqli_query($conn,$photoSql);
if($photoQuery==true){
$photoResultRows=mysqli_num_rows($photoQuery);
if($photoResultRows>0){?>
  <div class="container aos-init aos-animate" data-aos="fade-up">
    <div class="row portfolio-container aos-init aos-animate" data-aos="fade-up" data-aos-delay="200" style="position: relative; height: 4283.42px;">
  <?php
while($photo_rows=mysqli_fetch_array($photoQuery)){
  ?>
  <!-- <div class="col-md-4">
<img src="public/gallery/images/<?php echo "$photo_rows[photoName]";?>" alt=""  class="img-responsive">
  </div> -->
  <div class="col-lg-4 col-md-6 portfolio-item filter-app" style="position: absolute; left: 0px; top: 0px;">
  <a href="public/gallery/images/<?php echo "$photo_rows[photoName]";?>" data-gall="portfolioGallery" class="venobox preview-link vbox-item" title="<?php echo$photo_rows['photoAltext'] ?>">  <img src="public/gallery/images/<?php echo "$photo_rows[photoName]";?>" class="img-fluid" alt="<?php echo$photo_rows['photoAltext'] ?>">
  </a>
    <div class="portfolio-info">
      <br>
      <!-- <a href="public/gallery/images/<?php echo "$photo_rows[photoName]";?>" data-gall="portfolioGallery" class="venobox preview-link vbox-item" title="<?php echo$photo_rows['photoAltext'] ?>"><i class="bx bx-plus"></i></a> -->

    </div>
  </div>
  <?php
}?>
</div>
</div>
<?php
}else{
}
}else{
  echo "Error:".mysqli_error($conn);
}
}else{
  echo "Not Available";
}
?>

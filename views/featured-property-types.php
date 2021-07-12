

<section id="featured-services" class="featured-property-groups">
  <div class="container" data-aos="fade-up">
<h2>View by Property Types</h2>
<div class="row">
<?php
include("../controllers/config.php");
include('../controllers/classes/db-class.php');
$thisdb=new db($h,$u,$pass,$db);
$conn=$thisdb->connect();
if(!$conn){
  ?>

<h5 class="text-muted text-center">Connection Not Success</h5>
  <?php
  die();
}
$q="SELECT  * FROM  properties
GROUP BY  propertyType";
$query=mysqli_query($conn,$q);
if($query){
$results=mysqli_num_rows($query);
if($results>0){
  while($rows=mysqli_fetch_array($query)){
    ?>
    <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
      <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
        <h4 class="title"><a href=""><?php echo $rows["propertyType"];?></a></h4>
        <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
      </div>
    </div>
    <?php
  }
}else{
  echo "<span class='alert alert-warning'>Connection Error 1 </span>".mysqli_error($conn);
}
}else{
  echo "<span class='alert alert-warning'>Connection Error 2 </span>".mysqli_error($conn);
}
?>
  </div>
  </div>
</section>
<hr>

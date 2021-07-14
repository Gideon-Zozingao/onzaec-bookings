

<section id="featured-services" class="featured-property-groups">
  <div class="container" data-aos="fade-up">
<h2>View by Property Types</h2>
<div class="row">
<?php
include("../controllers/config.php");
include('../controllers/classes/db-class.php');
$thisdb=new db($h,$u,$pass,$db);
$conn=$thisdb->connect();
if($conn!=true){
  ?>

<h5 class="text-danger text-center">Connection  Success</h5>
  <?php
  //die();
}

try {
  $query=$conn->query("SELECT  * FROM  properties
  GROUP BY  propertyType");
  $query->setFetchMode(PDO::FETCH_ASSOC);
  $rowCount=$query->rowCount();
  if($rowCount>0){
    while($row=$query->fetch()){?>
      <div class="col-md-6 col-lg-3 d-flex align-items-stretch mb-5 mb-lg-0">
        <div class="icon-box" data-aos="fade-up" data-aos-delay="100">
          <h4 class="title"><a href=""><?php echo $row["propertyType"];  ?></a></h4>
          <p class="description">Voluptatum deleniti atque corrupti quos dolores et quas molestias excepturi</p>
        </div>
      </div>

      <?php

    }
  }else{
    ?>
    <div class="container">
      <h5 class="text-center text-muted">Information for this section is not availabale at this time</h5>
    </div>
    <?php
  }


} catch (PDOException $e) {
echo $e->getMessage();
}



?>
  </div>
  </div>
</section>
<hr>


<?php
if($row2["propertyMapInfo"]!=""){
$data='{"lat":-6.7229476149570555,"lng":146.99783732433124}';
echo $data;
?>
<script type="text/javascript">
  $(document).ready(()=>{
    var data=JSON.parse(`<?php echo $row2["propertyMapInfo"]?>`);
    let lat=data.lat;
    let lng=data.lng;
    alert(`Lat: ${lat} Lng: ${lng}`);
  })
</script>
<div class="row">
<div class="col-md-6">
<div class="card">
  <div class="card-body" id="map" style="height:400px;">
  </div>
</div>

<script type="text/javascript">
var data=JSON.parse(`<?php echo $row2["propertyMapInfo"]?>`);
let datalat=data.lat;
let datalng=data.lng;
let positiion={lat:datalat,lgn:datalng}

      function initMap() {
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 15,
    center: positiion
  });

  //place the marker  at the center of the Map
    const marker = new google.maps.Marker({
        position: positiion,
        map: map,
      });
}

    </script>
</div>
<div class="col-md-6">
</div>
</div>
<?php
}else{
  ?>
<div class="row">
  <div class="col-md-6">
  </div>
  <div class="col-md-6">
  </div>
</div>

  <?php
}
?>

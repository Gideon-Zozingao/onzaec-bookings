<?php
if(!(isset($_SESSION['logedin'])&&$_SESSION['account']&&$_SESSION['accountType']=='propertyacc')){
  echo"<h5  class='text-muted text-center'>This Section of the is not available</h5>";
}else{?>
  <div class="card" id="form-card">
    <div class="card-body">
      <form class="" action="controllers/update-property-site" method="POST"  enctype="multipart/form-data" id="propsUpdateSiteInfofrm">
        <div class="row">
          <div class="form-group col-md-6">
            <label for="">Site Tile (<span class="text-info">Site Tile Can be Your Property Name</span>)  </label>
            <input type="text" name="siteTitle" value="<?php echo $proprty["propertyName"];?>" class="form-control form-control-lg"/>
          </div>
          <div class="form-group col-md-6">
            <label for="">Site Subtitle (<span class="text-info">Provide an Inofrmative Subtitle of your Property Site</span>)</label>
            <input type="text" name="siteSubTitle"  class="form-control form-control-lg"/>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-4">
            <label for="">Property Type</label>
            <input type="text" name="propertyType" value="<?php echo $proprty["propertyType"];?>" class="form-control form-control-lg"/>
          </div>
          <div class="form-group col-md-4">
            <label for="">Country</label>
            <input type="text" name="country" value="<?php echo $proprty["country"];?>" class="form-control form-control-lg"/>
              </div>
              <div class="form-group col-md-4">
                <label for="">Location (City/Town)</label>
                <input type="text" name="propertyLocation" value="" class="form-control form-control-lg"/>
              </div>
              </div>
        <div class="row">
          <div class="form-group col-md-4">
            <label for=""> Address (<span  class="text-info"> Street Address</span> )</label>
            <input type="text" name="propertyAddress" value="" class="form-control form-control-lg"/>
          </div>
          <div class="form-group col-md-4">
            <label for="">Email (<span  class="text-info">  Reservations  Email</span> )</label>
            <input type="text" name="reservationEmail" value="" class="form-control form-control-lg"/>
          </div>
          <div class="form-group col-md-4">
            <label for="">Phone (<span  class="text-info"> Reservation  Phone</span> )</label>
            <input type="text" name="reservationPhone" value="" class="form-control form-control-lg"/>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-12">
            <label for="">Property Description</label>
            <textarea name="siteDescription" rows="8" cols="80" class="form-control form-control-lg">
      <?php echo $proprty["property_description"];?>
            </textarea>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-3">
            <label for="">Number of Rooms</label>
            <input type="text" name="numberOfRoom" value="<?php echo $proprty["number_of_assests"];?>" class="form-control form-control-lg"/>
          </div>
          <div class="form-group col-md-3">
            <label for="">Minimum Room Rate</label>
            <input type="text" name="minRoomRate" value="<?php echo $proprty["min_asset_rate"];?>" class="form-control form-control-lg"/>
          </div>
          <div class="form-group col-md-3">
            <label for="">Maximum Room Rate</label>
            <input type="text" name="maxRoomRate" value="<?php echo $proprty["max_asset_rate"];?>" class="form-control form-control-lg"/>
          </div>
          <div class="form-group col-md-3">
            <label for="">Rate Intervals</label>
            <input type="text" name="rateIntervals" value="<?php echo $proprty["asset_rate_intervals"];?>" class="form-control form-control-lg"/>
          </div>
        </div>
        <div class="row">
          <div class="form-group col-md-12">

            <label for="">Site Cover Photo</label>
            <input type="file" name="propSisteCoverImage" value="" class="form-control form-control-lg" id="cover_photo">

          </div>
        </div>
        <div class="" id="imagePreview">

        </div>

        <div class="col-md-10">
      <div class="card">
        <div class="card-body" id="map" style="height:400px;">

        </div>
      </div>
      <input type="hidden" name="geoCoords" value="" id="mapLnagLat">
      </div>
      <hr>
        <div class="col-md-12">
          <span id="resposnse"  class="text-center"></span>
        </div>
        <div class="row">
          <div class="col-md-4">
          </div>
          <div class="col-md-4">
            <button type="submit" class=" btn-primary btn-lg btn-block" name="propInfoUpdateBtn">Update</button>
          </div>
          <div class="col-md-4">
          <div class="" id="message">
          </div>
          </div>
        </div>
      </form>
    </div>
  </div>


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
                    $("#imagePreview").css("background-image", "url("+this.result+")");
                    $("#imagePreview").css("max-height","150vh");
                    $("#imagePreview").css("height","100vh");
                    $("#imagePreview").css("background-repeat","no-repeat");
                    $("#imagePreview").css("background-size","100%");
                }
            }
        });
    });
</script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#propsUpdateSiteInfofrm").on("submit",function(e){
     e.preventDefault();
        $.ajax({
          url:"../controllers/update-property-site.php",
  				type:"POST",
  				data:new FormData(this),
  				contentType:false,
  				cache:false,
  				processData:false,
          beforeSend : function(){
            $("#modal-top-body").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='../public/images/loading.gif'></div><div class='col-md-4'></div></div>")
            $("#modal-top").fadeIn("slow")
            //$("#message").html("<p class='alert  alert-info text-info'>Processing data...</p>").show();
          },
          success:function(data){
            $("#message").hide();
            var JSONdata=JSON.parse(data);
            if(JSONdata.alert_type=="error"){
              $("#modal-top-body").html("<p class='  text-danger'>"+JSONdata.message+"</p>");
              setTimeout(function(){
                $("#modal-top").fadeOut('slow')
              },3000);

            }else{
              $("#propsUpdateSiteInfofrm")[0].reset();
              $("#modal-top-body").html("<p class='  text-success'>"+JSONdata.message+"</p>");

              setTimeout(function(){
                $("#modal-top").fadeOut('slow')
                $("#imagePreview").css("background-image", "");
                $("#imagePreview").css("max-height","0");
                $("#imagePreview").css("height","0");
                window.location.replace("/account?action=view&page=property-site-management")
              },3000);

            }
          },
          error:function(error){
            $("#message").hide();
          }

        })
    });
  })
</script>

<script type="text/javascript">
var marker;
var mapLongLat=document.getElementById("mapLnagLat");
//var mapLat=document.getElementById("mapLat");
function initMap() {
const map = new google.maps.Map(document.getElementById("map"), {
zoom: 15,
center: { lat: -6.721764901537771, lng: 147.0024936391811 },
});
map.addListener("click", (e) => {
//   var mapData=JSON.stringify(e.latLng)
// var  maCoords= JSON.parse(mapData);
mapLongLat.value=JSON.stringify(e.latLng);
// mapLat.value=maCoords.lat
//alert(mapData)
placeMarkerAndPanTo(e.latLng, map);
});
}

function placeMarkerAndPanTo(latLng, map) {

if (marker == null)
{
marker = new google.maps.Marker({
 position: latLng,
map: map,
});
}
else
{
marker.setPosition(latLng);
}
}
</script>
  <?php
}
?>

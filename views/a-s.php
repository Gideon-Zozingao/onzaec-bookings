<?php
session_start();
if(isset($_SESSION["sqNumberOfAdult"])&&isset($_SESSION["sqNumberOfChildren"])&&isset($_SESSION["sqDestination"])&&isset($_SESSION["sqCheckinDate"])&&isset($_SESSION["sqCheckoutdate"])){?>
<div  class="">
    <form class="accom-search-form " action="../controllers/_s-director" method="POST"  name="search.accomodations" class="form-inline" id="accom-search-form">
      <div class="form-group">
        <label>Destination</label>
          <input type="text" class="form-control form-control-lg" placeholder="Destination" name="destination"  value="<?php echo($_SESSION["sqDestination"]) ?>" id="destination">
      </div>
      <div class="form-group">
        <label>Checkin  </label>
        <input type="date" class="form-control form-control-lg" placeholder="Checkin  Date" name="checkinDate"  value="<?php echo($_SESSION["sqCheckinDate"])?>" id="checkinDate">
      </div>
      <div class="form-group">
        <label>Checkout </label>
        <input type="date" class="form-control form-control-lg" placeholder="Checkout Date" name="checkoutdate" value="<?php echo($_SESSION["sqCheckoutdate"])?>" id="checkoutDate">
      </div>
      <div class="form-group">
        <label> Children</label>
          <input type="number" max="12"  min="0" class="form-control form-control-lg" placeholder="Number Of  Children" name="numberOfChildren" value="<?php echo($_SESSION["sqNumberOfChildren"])?>" id="numberOfChildren">
      </div>
      <div class="form-group">
        <label>  Adults</label>
          <input type="number" max="12"  min="0" class="form-control form-control-lg"  placeholder="Number Of  Adults"  name="numberOfAdult" value="<?php echo($_SESSION["sqNumberOfAdult"])?>" value="0" id="numberOfAdult">
      </div>
      <div class="form-group ">

          <button type='sumbit' class="btn btn-info btn-lg btn-block"  name="accom_search_btn">SEARCH</button>
      </div>
    </form>

<script type="text/javascript">
$(document).ready(function(){
    $("#accom-search-form").on("submit",function(e){
      e.preventDefault()
      if($("#checkinDate").val()==""){
        $("#checkinDate").css({
          "border","1px solid red"
        })
      }
      alert("Search Accomodation")
    })
})

//id="accom-search-form
</script>
  <?php

}else{
?>
  <div  class="">
    <form class="accom-search-form " action="../controllers/_s-director" method="POST"  name="search.accomodations" class="form-inline" id="accom-search-form">
      <div class="form-group">
        <label>Destination</label>
          <input type="text" class="form-control form-control-lg" placeholder="Destination" name="destination"  value="" id="destination">
      </div>
      <div class="form-group">
        <label>Checkin  </label>
        <input type="date" class="form-control form-control-lg" placeholder="Checkin  Date" name="checkinDate"  value="" id="checkinDate">
      </div>
      <div class="form-group">
        <label>Checkout </label>
        <input type="date" class="form-control form-control-lg" placeholder="Checkout Date" name="checkoutdate" value="" id="checkoutDate">
      </div>
      <div class="form-group">
        <label> Children</label>
          <input type="number" max="12"  min="0" class="form-control form-control-lg" placeholder="Number Of  Children" name="numberOfChildren" value="" id="numberOfChildren">
      </div>
      <div class="form-group">
        <label>  Adults</label>
          <input type="number" max="12"  min="0" class="form-control form-control-lg"  placeholder="Number Of  Adults"  name="numberOfAdult" value="" value="0" id="numberOfAdult">
      </div>
      <div class="form-group  ">

          <button type='sumbit' class="btn btn-info btn-lg btn-block"  name="accom_search_btn">SEARCH </button>
      </div>
    </form>

    <script type="text/javascript">
    $(document).ready(function(){
        $("#accom-search-form").on("submit",function(e){
          e.preventDefault()
          if($("#checkinDate").val()==""){
            $("#checkinDate").css({
              background-color:"red",
              border:"1px solid red"
            })
          }
          //alert("Search Accomodation")
        })
    })

    //id="accom-search-form
    </script>

<?php
}

?>

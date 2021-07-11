
<section  id="">
<h1>Bookings</h1>
<div class="col-md-12">
  <span id="BookingNotifications" class="btn btn-light"></span>
  <a href="#" class="btn btn-light" id="activeBooking">Active Bookings</a> | <a href="#" class="btn btn-light" id="bookingPendingConfirmation">Pending Confirmation</a> | <a href="#" class="btn btn-light" id="cancelledBookings">Cancelled Bookings</a> |
  <a href="#" class="btn btn-light" id="checkedInBookings">Checked in</a> | <a href="#" class="btn btn-dark" id="reservationSearchButton">Search </a>
</div>
<hr>
<div class="col-md-2" id="loading" style="display:none">
<img src='public/images/loading.gif'>
</div>
      <div class="" id="viewBookings">
      </div>
<script type="text/javascript">
  $(document).ready(function(){
setTimeout(()=>{
  $("#viewBookings").load("properties/all-active-bookings")
  $("#BookingNotifications").load("properties/bookings-notifications.php")
},2000)
setInterval(()=>{
$.ajax({
  url:"properties/all-active-bookings",
  type:"GET",
  beforeSend:function(){
    $("#loading").show()
  },
  success:function(data){
    setTimeout(()=>{
      $("#loading").hide();
    $("#viewBookings").html(data)
    },1500)
  }
})
},1000*60*5)
    setInterval(function(){
      $.ajax({
        url:"properties/bookings-notifications.php",
        type:"GET",
        beforeSend:()=>{
          //$("#loading").show();
        },
        success:(data)=>{
          setTimeout(()=>{
            $("#loading").hide();
            $("#BookingNotifications").html(data)
          },1500)
        }
      })
    },10000)

    //navigation button clicking Function

    //active booking Button
$("#activeBooking").on("click",function(e){
    e.preventDefault()
    $.ajax({
      url:"properties/all-active-bookings",
      type:"GET",
      beforeSend:function(){
        $("#loading").show();
      },
      success:function(data){
        setTimeout(()=>{
          $("#loading").hide();
          $("#viewBookings").html(data)
        },1500)
      }
    })
})

//pending confirmation Button
$("#bookingPendingConfirmation").on("click",function(e){
  e.preventDefault()
  $.ajax({
    url:"properties/bookings-pending-confirmation",
    type:"GET",
    beforeSend:function(){
      $("#loading").show();
    },
    success:function(data){
      setTimeout(()=>{
        $("#loading").hide();
        $("#viewBookings").html(data)
      },1500)
    }
  })
})
//cancelledBookings button
$("#cancelledBookings").on("click",function(e){
  e.preventDefault();
  $.ajax({
    url:"properties/bookings-cancelled",
    type:"GET",
    beforeSend:function(){
      $("#loading").show();
    },
    success:function(data){
      setTimeout(()=>{
        $("#loading").hide();
        $("#viewBookings").html(data)
      },1500)
    }
  })
})
//checkedInBookings Button
$("#checkedInBookings").on("click",function(e){
  e.preventDefault()
  $.ajax({
    url:"properties/bookings-checkedin",
    type:"GET",
    beforeSend:function(){
      $("#loading").show();
    },
    success:function(data){
      setTimeout(()=>{
        $("#loading").hide();
        $("#viewBookings").html(data)
      },1500)
    }
  })
})

//reservationSearchButton click
$("#reservationSearchButton").on("click",(e)=>{
  e.preventDefault();
    $.ajax({
      url:"properties/search-bookings",
      type:"GET",
      beforeSend:()=>{
          $("#modal-content").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
          $("#modal").slideToggle("slow")
      },
      success:(data)=>{
        $("#modal-content").html(data)
      }
    })
})
  })
</script>
</section>
<?php

 ?>

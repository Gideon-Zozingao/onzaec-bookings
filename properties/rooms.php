<?php

if(isset($_SESSION['logedin'])&&isset($_SESSION['account'])&&$_SESSION['accountType']==="propertyacc"){?>
<section>
  
  <a href="#" class="btn btn-light" id="liveRoomSLink">Live Room</a> | <a href="#" class="btn btn-light" id="unPublishedRoomsLink">Unpublished Room</a>
          <hr>
          <div class="container-fluid" id="roomsView">

          </div>

</section>
<script type="text/javascript">
  $(document).ready(function(){
    $("#roomsView").load("properties/published-rooms.php");

    $("#liveRoomSLink").on("click",(e)=>{
      e.preventDefault();
      $.ajax({
        url:"properties/published-rooms.php",
        type:"GET",
        beforeSend:function(){
          $("#roomsView").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
        },
        success:function(data){
          setTimeout(()=>{
            $("#roomsView").html(data);
          },1500)

        }
      })
    })
    //publishedRoomsLink


    $("#unPublishedRoomsLink").on("click",(e)=>{
      e.preventDefault();
      $.ajax({
        url:"properties/unpublished-rooms.php",
        type:"GET",
        beforeSend:function(){
          $("#roomsView").html("<div class='row'><div class='col-md-4'></div><div class='col-md-4'><img src='public/images/loading.gif'></div><div class='col-md-4'></div></div>")
        },
        success:function(data){
          setTimeout(()=>{
            $("#roomsView").html(data);
          },1500)

        }
      })
    })


  })

</script>
  <?php
}else{
die("Unknow Error");
}
?>

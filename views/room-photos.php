<?php
include("../controllers/config.php");
include("../controllers/classes/db-class.php");
$dbobj=new db($h,$u,$pass,$db);
$conn=$dbobj->connect();
if(!$conn){
  echo("Connetion Not Established");
  die();
}
switch ($_SERVER['REQUEST_METHOD']) {
  case 'GET':

if(isset($_GET["room"])&&isset($_GET['roomPhotosLink'])&&$_GET['roomPhotosLink']=="true"){
$roomsql="SELECT * FROM rooms WHERE roomId='$_GET[room]'";
$roomQuery=mysqli_query($conn,$roomsql);
$roomQueryArray=mysqli_fetch_array($roomQuery);
  $photosql="SELECT * FROM roomphotos WHERE roomId='$_GET[room]'";
  $photosQuery=mysqli_query($conn,$photosql);
  if($photosQuery==true){
    $photosresult=mysqli_num_rows($photosQuery);
    if($photosresult>0){
      ?>
      <style type="text/css">
      .selected{
        width:100%;
        height:100%;
        display:block;
      }
      #slider{
        width:100%;
        height:500px;
        padding:0;
        margin:0 0 10px;
        overflow:hidden;
        /* background-color:#E6E6FA; */
        background-color:#696969;

      }
      @media(max-width:768px) {
        #slider{
          width:100%;
          height:200px;
          padding:0;
          margin:0 0 10px;
          overflow:hidden;
          /* background-color:#E6E6FA; */
          /* background-color:#696969; */

        }
      }
      #prev, #next {
      bottom:0;
      display:block;
      width:120px;
      background-color:#A9A9A9;
      padding:3px;
      border:none;
      font-size:17px;
      color:#fff;
      }
      #prev:hover, #next:hover{
        background-color:#696969;
      }
      #prev:active, #next:active{
        border: 2px solid #00BFFF;
      }
      #prev {
float:left;
}
#next {
float:right;
}
      </style>

      <div class="aos-init aos-animate" data-aos="fade-up">
        <ul id="slider">
          <li class="selected">
            <img src="../public/gallery/images/<?php echo $roomQueryArray['roomCoverPhoto']?>" alt="" class="img-responsive img-fluid">
          </li>
      <?php
      while($photosresultArray=mysqli_fetch_array($photosQuery)){
        ?>
        <li class="slide">
          <img src="../public/gallery/images/<?php echo $photosresultArray['photoName']?>" alt="" class="img-responsive img-fluid">
        </li>

        <?php
      }
      ?>
      </ul>
<hr>
      <h5 class="text-center"><?php echo 1+(int)$photosresult ?> Photos</h5>

      <button id="prev">Previous</button>


<button id="next">Next</button>
<div style="clear:both"></div>
      </div>

<script type="text/javascript">
$(document).ready(function(){
      // Have the first and last li's set to a variable
      var $first = $('li:first', '#slider'),$last = $('li:last', '#slider');
      $("#next").click(()=>{
          var $next,$selected = $(".selected");
          // get the selected item
          // If next li is empty , get the first
          $next = $selected.next('li').length ? $selected.next('li') : $first.addClass('selected').fadeIn('fast');
           $selected.removeClass("selected").fadeOut('fast');
          $next.addClass('selected').fadeIn('fast');
      });

      $("#prev").click( ()=>{
            var $prev,$selected = $(".selected");
            // get the selected item
            // If prev li is empty , get the last
            $prev = $selected.prev('li').length ? $selected.prev('li') : $last.addClass('selected').fadeIn('fast');

             $selected.removeClass("selected").fadeOut('fast');
            $prev.addClass('selected').fadeIn('fast');
      });

  // var time = 5000;
  // var tid = setTimeout(timer, time);
  // function timer() {
  // var $next,
  // $selected = $(".selected");
  // // get the selected item
  // // If next li is empty , get the first
  // $next = $selected.next('li').length ? $selected.next('li') : $first.addClass('selected').fadeIn('fast');
  //
  // $selected.removeClass("selected").fadeOut('fast');
  // $next.addClass('selected').fadeIn('fast');
  //   tid = setTimeout(timer, time); // repeat myself
  // }
  //
  // function abortTimer() { // to be called when you want to stop the ti
  // clearTimeout(tid);
  // }

})
</script>
      <?php
      }else{
        ?>
          <div class="text-center text-muted">
          <h5> No Photos available for this Room</h5>
        </div>
        <?php
            }
  }else{?>

        <section>
            <div class="text-muted text-center">
              <h5>Cannot retreive Photo Information for this Room</h5>
              <p>Try again later</p>
            </div>
        </section>
    <?php

    }
}





    break;

  default:
    // code...
    break;
}

 ?>

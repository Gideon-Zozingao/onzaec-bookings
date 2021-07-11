<?php
session_start();
if(
  isset($_SESSION["sqNumberOfAdult"])
  &&isset($_SESSION["sqNumberOfChildren"])
  &&isset($_SESSION["sqDestination"])
  &&isset($_SESSION["sqCheckoutdate"])
  &&isset($_SESSION["sqCheckinDate"])){
    ?>
    <h6 class="text-center text-primary">Your last Search </h6>

    <div class="colmd-8 " id="searchSessionNotice">
      <div class="icon-box text-sm">


        <strong><?php echo $_SESSION["sqDestination"]?></strong>

         <i><?php echo" <strong>  ".$_SESSION["sqCheckinDate"]."</strong> -  <strong>".$_SESSION["sqCheckinDate"]?></strong></i>
        <p> <?php echo "<strong>Children</strong>  ".$_SESSION["sqNumberOfChildren"]?>
     <?php echo "<strong>Adults</strong>  ".$_SESSION["sqNumberOfAdult"]?></p>
          </div>
    </div>
    <hr>
    <h6 class="text-right"><a href="search.accomodations/<?php echo $_SESSION['sqDestination']?>" class="text-primary">Revisit </a> <a href="#" id="closeSearchSession"  class=" text-muted">
     <span  class=" text-muted"></span> Clear</a></h6>
        <script type="text/javascript">
          $(document).ready(function(){
            $("#closeSearchSession").on('click',function(e){
              e.preventDefault();
              //alert("closeSearchSession");

              $.ajax({
                url:"../controllers/close-search-session.php",
                //url:"controllers/perform-booking-transaction.php",
                type:"GET",
                //data:new FormData(this),
                contentType:false,
                cache:false,
                processData:false,
                beforeSend : function(){
                  //console.log("Closing  Session....")
                },
                success:function(data){
                  $("#searchSessionNotice").fadeOut('hide');
                  $("#modal-left-body").html("")
                  $("#modal-left").fadeOut("slow")

                  //console.log(data);
                },
                error:function(error){
                }
              });
            })
          })
        </script>
<?php
}else{
  echo "null";
}
?>

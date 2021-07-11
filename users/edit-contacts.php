<?php
session_start();
include("../controllers/config.php");
include('../controllers/classes/db-class.php');
include('../controllers/classes/user-class.php');
$thisdb=new db($h,$u,$pass,$db);
$conn=$thisdb->connect();
$me=new User();
$me->setUserId($_SESSION['id']);
if(!$conn){
  die("Connection Failed Try Again Later");
}
$myData=$me->viewUSer($conn);
if($myData==FALSE){?>
  <section id="hero" class="d-flex align-items-center" >
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
      <h1>Error  retrieing Your  Profile Information
      </h1>

      <section>

      </section>
    </div>
  </section>
<?php
  die();
}
if($myData==0){
  ?>
  <section id="hero" class="d-flex align-items-center" >
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
      <h1>Your Profile information is  Not Available
      </h1>

      <section>

      </section>
    </div>
  </section>
  <?php
die();
}
 ?>
 <div class="card" id="form-card">
   <div class="card-body">

     <h3 class="text-muted">Edit your Contact details</h3>
     <hr>
     <?php //echo json_encode($myData) ?>

     <form class="" action="" method="post" id="editContactForm">
       <div class="row">
         <div class="col-md-6">
           <div class="form-group">
             <label for="">Phone</label>
             <input type="text" name="phone" value="<?php echo $myData["phone"]  ?> " class="form-control">
           </div>
         </div>
         <div class="col-md-6">
           <div class="form-group">
             <label for="">Email</label>
             <input type="text" name="phone" value="<?php echo $myData["email"]  ?> " class="form-control">
           </div>
         </div>
       </div>
       <hr>
       <div class="row">
       <div class="col-md-4">

       </div>
       <div class="col-md-4">
         <button type="submit" class="btn-primary btn-lg">Save Contacts</button>
       </div>
       <div class="col-md-4">

       </div>
       </div>
     </form>
   </div>

 </div>
<script type="text/javascript">
    $(document).ready(()=>{
      $("#editContactForm").submit((e)=>{
        e.preventDefault()
        alert("Save the Contact Details Now")
      })
    })
</script>

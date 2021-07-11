<?php
if($_SESSION["userType"]=="admin"){
  ?>

  <hr>
  <section>
    <div class="row">
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
          <h5>Rooms</h5>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
          <h5>Rservations</h5>
          </div>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card">
          <div class="card-body">
          <h5>Employees</h5>
          </div>
        </div>
      </div>
    </div>
  </section>
  <div class="row">
    <div class="col-md-4">
      <div class="card">
        <div class="card-body">
        <h5>Rooms</h5>
        </div>
      </div>
    </div>

  </div>

  <section>

  </section>
<script type="text/javascript">
  $(document).ready(()=>{
    //alert("Hellow")
    setTimeout(()=>{
      $("#modal-left-content").css("margin-top","10vh")
      $("#modal-left-body").html("Hello")
      $("#modal-left").fadeIn("slow");
    },1500)

  })
</script>
  <?php
}else{
  ?>
<div class="col-md-8 offset-2">
<h5 class="text-center text-muted">Your dont gave Access Previliege for this section</h5>
</div>

  <?php
}

?>

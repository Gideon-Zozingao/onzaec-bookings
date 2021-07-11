<div class="modal" id="modal">
  <div class="modal-content" id="modal-container" >
    <div class="modal-header">
      <span id="close-modal" class="close">&times</span>
    </div>
    <div class="modal-body" id="modal-content">
    </div>
  </div>
</div>
<div class="modal" id="modal-sm">
  <div class="modal-content" id="modal-content-small">
    <div class="modal-header">
      <span id="close-modal-sm" class="close">&times</span>
    </div>
    <div class="modal-body" id="modal-content-sm">
    </div>
  </div>
</div>
<div id="modal-top" class="modal-top ">

  <!-- Modal content -->
  <div  class=" modal-top-content">
    <div class="modal-top-header">
        <span class=" close close-top-modal" id="close-top-modal">&times;</span>
  </div>
    <div id="modal-top-body"class="modal-top-body">
    </div>

  </div>

</div>





<div class="modal" id="modal-left" >
  <div class="modal-content" id="modal-left-content">
      <span id="modal-left-close" class="close text-right">&times</span>
      <div class="modal-body" id="modal-left-body">
      </div>
  </div>
    </div>
<script type="text/javascript">
  $(document).ready(()=>{
$("#modal-left-content").css("border","1px solid #1E90FF")
$("#modal-left-close").on("click",()=>{
  $("#modal-left-body").html("")
  $("#modal-left").fadeOut("slow")
})
    $("#close-top-modal").on("click",function(){
      $("#modal-top-body").html("")
      $("#modal-top").fadeOut("slow")
    })

    $("#close-modal").on("click",function(){
      $("#modal-content").html("");
      $("#modal").fadeOut("slow")
    })


    $("#close-modal-sm").on("click",()=>{
      $("#modal-content-sm").html("")
      $("#modal-sm").fadeOut("slow")
    })
  })
</script>

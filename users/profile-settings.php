<!-- <nav class="navbar bg-light">
<a href="#" class="nav-links btn btn-default" id="edit-profile"> Profile Informtion</a>
<a href="#" class="nav-link btn btn-default" id="changecontacts"> Contacts Settings</a>
<a href="#" class="nav-link btn btn-default" id="changepassword"> Password Settings</a>

<a href="#" class="nav-links btn btn-default" id="delete-Account">Delete Account</a>

</nav> -->
<div class="" id="action-pane">
</div>
<script type="text/javascript">
  $(document).ready(()=>{
    $("#action-pane").load("users/profile-details.php");
    $("#edit-profile").click((e)=>{
      e.preventDefault();
      $.ajax({
        url:"users/edit-profile.php",
        type:"GET",
        beforeSend:()=>{
            $("#modal-top-body").html("<span class='col-md-2 offset-5'><img src='../public/images/loading.gif'></span>")
            $("#modal-top").fadeIn("slow");
        },
        success:(data)=>{
            setTimeout(()=>{
              $("#action-pane").html(data)
              $("#modal-top").fadeOut("slow")
            },1500)
        }
      })
    })
    $("#delete-Account").click((e)=>{
      e.preventDefault();
      $("#action-pane").html("Delete Your Account Now")
    })

    $("#changepassword").click((e)=>{
      e.preventDefault();
      $.ajax({
        url:"users/change-password.php",
        type:"GET",
        beforeSend:()=>{
          $("#modal-top-body").html("<span class='col-md-2 offset-5'><img src='../public/images/loading.gif'></span>")
          $("#modal-top").fadeIn("slow");
        },
        success:(data)=>{
          setTimeout(()=>{
            $("#action-pane").html(data)
            $("#modal-top").fadeOut("slow")
          },1500)
        }
      })
      //$("#action-pane").html("Change Your Password Now")
    })
    $("#changecontacts").click((e)=>{
      e.preventDefault();
      $.ajax({
        url:"users/edit-contacts.php",
        type:"GET",
        beforeSend:()=>{
          $("#modal-top-body").html("<span class='col-md-2 offset-5'><img src='../public/images/loading.gif'></span>")
          $("#modal-top").fadeIn("slow");
        },
        success:(data)=>{
          setTimeout(()=>{
            $("#action-pane").html(data)
            $("#modal-top").fadeOut("slow")
          },1500)
        }
      })
    })
  })
</script>

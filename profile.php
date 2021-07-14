<?php
session_start();
if(isset($_SESSION['logedin'])&&$_SESSION['logedin']==true){
  //viewUSer
  include("views/layout.php");
  include("controllers/config.php");
  include('controllers/classes/db-class.php');
  include('controllers/classes/user-class.php');
  $thisdb=new db($h,$u,$pass,$db);
  $conn=$thisdb->connect();
  $me=new User();
  $me->setUserId($_SESSION['id']);
  $page_tittle="Onzaec Bookings>>  ".$_SESSION['name']." ".$_SESSION['surname'];
?>
<meta name="robots" content="nofolow,noindex">
<title><?php echo $page_tittle?></title>
<?php include("views/layout-links.php") ?>
</head>
<body>
  <header id="header" class="fixed-top">
<?php include("views/nav.php")?>
</header>
    <?php
    if($conn){
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
<?php include("./views/footer-1.php");
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
      <?php include("./views/footer-1.php");
    }
    ?>
  <div class="sidenav">
  <a href="/profile?action=redir&soft=activity-log">Activitis <span class="fa fa-home"></span></a>
  <a href="/profile?action=redir&soft=favProperties">Properties You Love</a>
  <a href="/profile?action=redir&soft=scores">Socres</a>
  <a href="/profile?action=redir&soft=prices">Prices</a>
  <a href="/profile?action=redir&soft=accounts">Accounts <span class="fa fa-user"></span>  </a>
<a href="/profile?action=redir&soft=settings">Settins <span class="fa fa-cog"></span>   </a>
</div>
<div class="main">
  <section  class="header-mini d-flex align-items-center">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
      <div class="profile-heading row">
        <div class="col-md-4">
          <?php
          if($myData["avata"]!=""){?>

              <img src="users/user-photos/<?php echo$myData["avata"] ?> " alt="<?php echo $myData["name"] ." ".$myData["surname"]?> " class="img-responsive img-fluid" style="min-width:200px; min-height:200px; max-width:200px;min-height:100px;">
            <?php
          }else{
            ?>
                <img src="users/user-photos/default.jpg" alt="<?php echo $myData["name"] ." ".$myData["surname"]?> " class="img-responsive img-fluid  ">
            <?php
          } ?>

        </div>
        <div class="col-md-8">
          <h1><span><?php echo $myData["name"]." ".$myData["surname"]?></span>
          </h1>
        </div>
      </div>
      <hr>
      <button type="button" class="btn btn-dark" id="avata" title="Change Avata"><span class="fa fa-camera"></span>    </button>
      <button type="button" class="btn btn-dark" id="profile-settings" title="Profile Settings"><span class="fa fa-cog" ></span>   </button>
    </div>
  </section>
  <section class="container">
    <?php
        if(isset($_GET["action"])){
          if(isset($_REQUEST["soft"])){
            try {
              switch ($_REQUEST["soft"]) {
                case 'settings':
                  ?>
                    <h2 class="text-primary">Profile Settings</h2>
                  <?php
                  include("users/profile-settings.php");
                  break;
                  case 'activity-log':
                      ?>
                      <h2 class="text-primary">Activity Log</h2>
                      <?php
                    break;
                    case 'accounts':
                      ?><h2 class="text-primary">Accounts You are Managing</h2>  <?php
                      include("users/accounts.php");
                      break;
                      case 'scores':
                        ?>
                        <h2 class="text-primary">Scores</h2>
                        <?php
                        break;
                        case 'prices':
                          ?>
                          <h2 class="text-primary">Prices</h2>
                          <?php
                          break;
                          case 'favProperties':
                            ?>
                            <h2 class="text-primary">Properties You Love</h2>
                            <?php
                            break;
                default:
                  // code...
                  break;
              }
            } catch (Exception $e) {
              echo $e;
            }
          }else{
            ?>
              <div class="alert alert-danger">
                <h4 class="text-danger text-center">Your Link is Broken</h4>
              </div>
            <?php
          }
        }else{

        }
     ?>

  </section>
  <?php include("./views/footer-1.php"); ?>
</div>
    <script type="text/javascript">
      $(document).ready(()=>{
        $("#avata").on("click",()=>{
          $.ajax({
            url:"users/change-avata.php",
            type:"GET",
            beforeSend:()=>{
            },
            success:(data)=>{
              $("#modal-content-sm").html(data)
              $("#modal-sm").fadeIn("slow")
            }
          })
        })
        $("#profile-settings").on("click",()=>{
          window.location.replace("/profile?action=redir&soft=settings")
        })
      })
    </script>
    <?php

  }else{
    ?>
    <section id="hero" class="d-flex align-items-center" style=" background: url('src/assets/img/hero-bg.jpg') top left; background-repeat:no-repeat; background-size:100%;">
      <div class="container" data-aos="zoom-out" data-aos-delay="100">
        <h1>Connection Error:  Your cannot  view  your  Profile
        </h1>
        <section>
        </section>
      </div>
      <?php include("./views/footer-1.php"); ?>
    </section>
    <?php

    //die("");
  }
    ?>

<?php

}else{
    header("Location:./");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta name="keywords" content="#">
    <meta name="description" content="<?= $pageDescrption ?>">
    <title><?=$pageTitle ?></title>
    <!--    <meta name="description" content="ds">-->
    <!--    <title>sd</title>-->
    <!-- Fav and touch icons -->


    <!-- <script src="https://unpkg.com/feather-icons"></script> -->


    <!--    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />-->
    <!--   -->
    <!-- favicon -->

    <link href="/public/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="/public/css/admin/jasny-bootstrap.min.css" rel="stylesheet" />

    <link href="/public/css/admin/admin.css" rel="stylesheet" />
    <!---->
    <!--		<script type="text/javascript" src="/public/lib/ckeditor/ckeditor.js" ></script>-->

    <link href="/public/css/admin/dataTables.bootstrap.css" rel="stylesheet" />


    <link rel="shortcut icon" href="/public4/images/con_only.png" />
    <link rel="shortcut icon" type="/public4/images/con_only.png" href="/public4/images/con_only.png">
    <link href="/public3/assets/css/font/flaticon.css" rel="stylesheet">



    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />









    <link rel="stylesheet" href="/public/uploads/css/jquery.fileupload.css" />




    <script async defer src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDmHkJWNlvdxcycOeuC9AYZXWHqBEiBbMc"></script>


    <link href="/public/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <link href="/public/css/admin/jasny-bootstrap.min.css" rel="stylesheet" />

    <link href="/public/css/admin/admin.css" rel="stylesheet" />

    <link href="/public/lib/datePicker/daterangepicker.css" rel="stylesheet" type="text/css"/>




    <script src="/public/js/jquery.js"></script>

    <script src="/public/js/admin/jquery.dataTables.min.js"></script>








    <script src="/public/js/admin/jquery.dataTables.min.js"></script>

    <link rel="stylesheet" href="/public4/css/jquery-ui.css">
    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Lato:300,300i,400,400i%7CMontserrat:600,800" rel="stylesheet">
    <!-- FONT AWESOME -->
    <link rel="stylesheet" href="/public4/css/fontawesome-all.min.css">
    <link rel="stylesheet" href="/public4/css/font-awesome.min.css">
    <!-- Slider Revolution CSS Files -->
    <link rel="stylesheet" href="/public4/jquery-ui-1.11.4/jquery-ui.css">


    <link rel="stylesheet" href="/public4/revolution/css/settings.css">
    <link rel="stylesheet" href="/public4/revolution/css/layers.css">
    <link rel="stylesheet" href="/public4/revolution/css/navigation.css">
    <!-- ARCHIVES CSS -->
    <link rel="stylesheet" href="/public4/css/animate.css">
    <link rel="stylesheet" href="/public4/css/magnific-popup.css">
    <link rel="stylesheet" href="/public4/css/lightcase.css">
    <link rel="stylesheet" href="/public4/css/owl.carousel.min.css">
    <link rel="stylesheet" href="/public4/css/bootstrap.css">
    <link rel="stylesheet" href="/public4/css/styles.css">

    <!-- problem -->
    <link href="/public2/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />



<style media="screen">
.modalDialog {
  position: fixed;
  font-family: Arial, Helvetica, sans-serif;
  top: 0;
  right: 0;
  bottom: 0;
  left: 0;
  background: rgba(0, 0, 0, 0.8);
  z-index: 99999;
  opacity:0;
  -webkit-transition: opacity 400ms ease-in;
  -moz-transition: opacity 400ms ease-in;
  transition: opacity 400ms ease-in;
  pointer-events: none;
}
.modalDialog:target {
  opacity:1;
  pointer-events: auto;
}
.modalDialog > div {
  width: 400px;
  position: relative;
  margin: 10% auto;
  padding: 5px 20px 13px 20px;
  border-radius: 10px;
  background: #fff;
  background: -moz-linear-gradient(#fff, #999);
  background: -webkit-linear-gradient(#fff, #999);
  background: -o-linear-gradient(#fff, #999);
}
.close {
  background: #606061;
  color: #FFFFFF;
  line-height: 25px;
  position: absolute;
  right: -12px;
  text-align: center;
  top: -10px;
  width: 24px;
  text-decoration: none;
  font-weight: bold;
  -webkit-border-radius: 12px;
  -moz-border-radius: 12px;
  border-radius: 12px;
  -moz-box-shadow: 1px 1px 3px #000;
  -webkit-box-shadow: 1px 1px 3px #000;
  box-shadow: 1px 1px 3px #000;
}
.close:hover {
  background: #00d9ff;
}


#loading {
    position: fixed;
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100%;
    top: 0;
    left: 0;
    opacity: 0.7;
    background-color: #fff;
    z-index: 99;
}

#loading-image {
    z-index: 100;
}
</style>


<body>





  <div id="loading">
      <img id="loading-image" src="/public4/images/yos.gif" alt="Loading..." />
  </div>

<div class="header">
    <div class="header-top">
        <div class="container">
            <div class="top-info hidden-sm-down">
<!--                <div class="call-header">-->
<!--                    --><?php //foreach ($footer2 as $value) {?>
<!--                        <p><a style="color: white" href=" +31 6 36 10 44 47"><i style="font-size: 12px" class="fa fa-phone" aria-hidden="true"></i> --><?//=$value->thePhone1?><!--</a></p>-->
<!--                    --><?php //} ?>
<!--                </div>-->
<!---->
<!--                <div class="mail-header">-->
<!--                    --><?php //foreach ($footer2 as $value) {?>
<!--                        <p> <a style="color: white" href="mailto:info@hurenkangoedkoper.com?subject = Feedback&body = Message"> <i style="font-size: 15px" class="fa fa-envelope" aria-hidden="true"></i> --><?//=$value->theEmail1?><!--</a></p>-->
<!--                    --><?php //} ?>
<!--                </div>-->
            </div>
            <div class="top-social hidden-sm-down">
                <div class="login-wrap">
                    <ul class="d-flex">


                        <?php  if (isset($this->session->name)){?>

                            <li><a href="#"><i class="fa fa-user"></i>    <?php echo substr($this->session->name, 0, 7);?></a></li>

                            <li><a href="/logout1"><i style="font-size: 20px" class="la la-sign-in-alt"></i> logout</a></li>

                            <!--                                  <a class="dropdown-item" href="/panel/logout1/">logout</a>-->


                        <?php }else{?>


                            <li><a href="#" data-toggle="modal" data-target="#modalLoginForm"><i class="fa fa-user"></i> Login</a></li>
                            <li><a href="#"data-toggle="modal" data-target="#productview"><i style="font-size: 20px" class="la la-sign-in-alt"></i> Registreer</a></li>

                        <?php }?>



                    </ul>
                </div>
                <div class="social-icons-header">
                    <div class="social-icons" style="font-size: 5px!important;">
                        <!--                        --><?php //foreach ($footer3 as $value) {?>
                        <!--                            <a style="" href=" --><?//=$value->url?><!--"><i style="color: white; font-size:5px  " class=" --><?//=$value->icon?><!--" aria-hidden="true"></i></a>-->
                        <!---->
                        <!--                        --><?php //} ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="header-bottom heading sticky-header" id="heading">
        <div class="container" style="width: 96%;margin-left: 6%">
            <?php foreach ($footer11 as $value){?>
                <div class="netabout" style=" width: 16%">
                    <a href="/" class="logo">
                        <img  src="<?= $value->thePhoto ?>" style="width: 100%;  margin: 0;  " alt="netcom">
                    </a>


                </div>
            <?php }?>

            <button type="button" class="search-button" data-toggle="collasdpse" data-target="#bloq-sedsfssarch" aria-expanded="false">

            </button>
            <div style=" " class="get-quote hidden-lg-down" id="Submit">
                <?php  if (isset($this->session->name)){?>
                    <a href="/submit">
                        <p>Submit Property</p>
                    </a>

                <?php }else{?>
                    <a href="#"data-toggle="modal" data-target="#productview"">
                    <p>Submit Property</p>
                    </a>


                <?php }?>
            </div>
            <div   style="margin-left: 7px" class="get-quote hidden-lg-down" id="Submits">
                <?php  if (isset($this->session->name)){?>
                    <a href="/add-submit">
                        <p>manage post</p>
                    </a>


                <?php }else{?>
                    <a href="#"data-toggle="modal" data-target="#productview"">
                    <p>manage post</p>
                    </a>






                <?php }?>

            </div>


            <button type="button" class="button-menu hidden-lg-up" data-toggle="collapse" data-target="#main-menu" aria-expanded="false">
                <i class="fa fa-bars" aria-hidden="true"></i>
            </button>


            <form action="#" id="bloq-search" class="collapse">
                <div class="bloq-search">
                    <input type="text" placeholder="search...">
                    <input type="submit" value="Search">
                </div>
            </form>

            <nav id="main-menu" class="collapse">
                <ul>
                    <?php foreach ($menu_link as $key => $values){
                        $links = $this->db->query("SELECT url FROM links WHERE page = 'menu_link' AND content_id = '$values->id'")->result_object();
                        if($links){
                            $link = '/'.$links[0]->url;
                        }else {
                            $link ="javascript:";
                        }
                        $sub_menu_link = $this->db->query("SELECT * FROM cities WHERE  category_id = $values->id")->result_object();
                        if($sub_menu_link){ ?>
                            <li class="hidden-lg-up">
                                <div class="po">
                                    <a data-toggle="collapse" href="#home" aria-expanded="false"><?=$values->theName?></a>
                                </div>
                                <div class="collapse" id="home">
                                    <div class="card card-block">
                                        <?php foreach ($sub_menu_link as $key => $value){
                                            $li2 = $this->db->query("SELECT url FROM links WHERE page = 'cities' AND content_id = '$value->id'")->result_object();
                                            if ($li2) {
                                                $sss2 = '/' . $li2[0]->url;
                                            } else {
                                                $sss2 = "javascript:;";
                                            }  ?>


                                            <a class="dropdown-item " href="<?=$sss2?>"><?=$value->theName?></a>
                                        <?php   } ?>

                                    </div>
                                </div>
                            </li>
                            <!-- END COLLAPSE MOBILE MENU -->

                            <li class="dropdown hidden-md-down"  style=" margin-left : 5em;
        margin-right : 4em;" >
                                <a class="active dropdown-toggle" href="<?=$link?>"data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  > <?=$values->theName?></a>
                                <div class="dropdown-menu">
                                    <?php foreach ($sub_menu_link as $key => $value){
                                        $li2 = $this->db->query("SELECT url FROM links WHERE page = 'cities' AND content_id = '$value->id'")->result_object();
                                        if ($li2) {
                                            $ssd2 = '/' . $li2[0]->url;
                                        } else {
                                            $ssd2 = "javascript:;";
                                        }  ?>

                                        <a class="dropdown-item" href="<?=$ssd2?>"><?=$value->theName?></a>
                                    <?php   } ?>

                                </div>
                            </li>

                        <?php   }else { ?>
                            <li><a class="" href="<?=$link?>"> <?=$values->theName?></a></li>

                        <?php   } ?>
                    <?php   } ?>
                    <!--                      <li><a href=""</a>kop</li>-->



                    <!-- STAR COLLAPSE MOBILE MENU -->

                    <!-- STAR COLLAPSE MOBILE MENU -->


                </ul>
            </nav>
        </div>
    </div>
</div>

<div style=" z-index: 99999;" class="modal fade" id="modalLoginForm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form action="/panel/front_login" method="post">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Sign in</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <i  style="  font-size: 23px;margin-right: 5px " class="fas fa-envelope prefix grey-text"></i><label data-error="wrong"   data-success="right" for="defaultForm-email">Your name</label>
                        <input type="text" name="theName" id="defaultForm-email" class="form-control validate">

                    </div>

                    <div class="md-form mb-4">
                        <i style="  font-size: 23px;margin-right: 5px" class="fas fa-lock prefix grey-text"></i><label data-error="wrong" data-success="right" for="defaultForm-pass">Your password</label>
                        <input type="password" name="thePassword" id="defaultForm-pass" class="form-control validate">

                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button style="width: 44%" class="btn btn-secondary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div  style=" z-index: 99999;" class="modal fade" id="productview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
      aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" class="form" action="/site/ajax/signup" name="myForm"  enctype="multipart/form-data">

                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Sign up</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <i  style="  font-size: 23px;margin-right: 5px "class="fas fa-user prefix grey-text"></i><label data-error="wrong" data-success="right" for="orangeForm-name">Your name</label>

                        <input type="text" id="orangeForm-name"  name="theName" class="form-control validate">
                    </div>
                    <div class="md-form mb-5">
                        <i style="  font-size: 23px;margin-right: 5px " class="fas fa-envelope prefix grey-text"></i> <label data-error="wrong" data-success="right" for="orangeForm-email">Your email</label>
                        <input type="email" id="orangeForm-email" name="theEmail" class="form-control validate">

                    </div>

                    <div class="md-form mb-4">
                        <i  style="  font-size: 23px;margin-right: 5px "class="fas fa-lock prefix grey-text"></i>  <label data-error="wrong" data-success="right" for="orangeForm-pass">Your password</label>
                        <input type="password" name="thePassword" id="orangeForm-pass" class="form-control validate">

                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button style="width: 44%"class="btn btn-secondary">Sign up</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(window).on('load', function () {
        $('#loading').hide();
    })
</script>

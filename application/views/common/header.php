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
    <link rel="shortcut icon" href="/public4/images/con_only.png" />
    <link rel="shortcut icon" type="/public4/images/con_only.png" href="/public4/images/con_only.png">
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
    <link href="/public2/assets/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
<!--    AIzaSyAC6Y6emK6EqQrp2pfgAdt7BdRxTN0eIL4-->
<!--    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAC6Y6emK6EqQrp2pfgAdt7BdRxTN0eIL4&callback=initMap"></script>-->
    <script async defer src="https://maps.googleapis.com/maps/api/js?v=3.exp&libraries=places&key=AIzaSyDmHkJWNlvdxcycOeuC9AYZXWHqBEiBbMc"></script>
<!--    <link rel="stylesheet" href="/public1/uploads/css/jquery.fileupload.css" />-->

<!--    <script async-->
<!--            src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAC6Y6emK6EqQrp2pfgAdt7BdRxTN0eIL4&libraries=geometry&callback=initMap">-->
<!--    </script>-->



    <!-- Google Fonts -->

</head>
<body>
<!-- Navbar STart -->

<!-- Navbar End -->
























<div class="header">
    <div class="header-top">
        <div class="container">
            <div class="top-info hidden-sm-down">

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
                            <li><a href="#"data-toggle="modal" data-target="#productview"><i style="font-size: 20px" class="la la-sign-in-alt"></i>Registreer</a></li>

                        <?php }?>



                    </ul>
                </div>
                <div class="social-icons-header">
                    <div class="social-icons">
                        <?php foreach ($footer3 as $value) {?>
                            <a href=" <?=$value->url?>"><i style="color: white; font-size: 15px" class=" <?=$value->icon?>" aria-hidden="true"></i></a>

                        <?php } ?>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="header-bottom heading sticky-header" id="heading">
        <div class="container"style="width: 96%;margin-left: 6%">
            <?php foreach ($footer11 as $value){?>
                <div id="logos" class="netabout" style=" ">
                    <a href="/" class="logo">
                        <img  src="<?= $value->thePhoto ?>" style="width: 100%;  margin: 0;  " alt="netcom">
                    </a>


                </div>
            <?php }?>

            <button type="button" class="search-button" data-toggle="collasdpse" data-target="#bloq-sedsfssarch" aria-expanded="false">

            </button>
            <div  class="get-quote hidden-lg-down" id="Submit">
                <?php  if (isset($this->session->name)){?>
                    <a href="/submit">
                        <p >Submit Property</p>
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
                                    <a  data-toggle="collapse" href="#home" aria-expanded="false"><?=$values->theName?></a>
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


                                            <a  class="dropdown-item " href="<?=$sss2?>"><?=$value->theName?></a>
                                        <?php   } ?>

                                    </div>
                                </div>
                            </li>
                            <!-- END COLLAPSE MOBILE MENU -->

                            <li class="dropdown hidden-md-down"  style=" margin-left : 5em;
        margin-right : 4em;" >
                                <a style="font-size: 14px" class="active dropdown-toggle"   href="<?=$link?>"data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"  > <?=$values->theName?></a>
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
                            <li><a  style="font-size: 14px" class="" href="<?=$link?>"> <?=$values->theName?></a></li>

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
            <form action="/front_login" method="post">
                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Login</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <i  style="  font-size: 16px;margin-right: 5px " class="fas fa-envelope prefix grey-text"></i><label data-error="wrong"   data-success="right" for="defaultForm-email">Your Email</label>
                        <input type="email" name="theEmail" id="defaultForm-email" class="form-control validate">

                    </div>

                    <div class="md-form mb-4">
                        <i style="  font-size: 16px;margin-right: 5px" class="fas fa-lock prefix grey-text"></i><label data-error="wrong" data-success="right" for="defaultForm-pass">Your password</label>
                        <input type="password" name="thePassword" id="defaultForm-pass" class="form-control validate">

                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button style="width: 44%" class="btn btn-secondary" type="submit">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
<div  style=" z-index: 99999;" class="modal fade" id="productview" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
      aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" class="form" action="site/ajax/signup" name="myForm"  enctype="multipart/form-data">

                <div class="modal-header text-center">
                    <h4 class="modal-title w-100 font-weight-bold">Sign up</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body mx-3">


                    <div  class="" role="alert" id="showresults" >

                    </div>

                    <div class="row">




                        <div class="col-lg-6 col-md-12">

                            <i  style="  font-size: 16px;margin-right: 5px "class="fas fa-user prefix grey-text"></i><label data-error="wrong" data-success="right" for="orangeForm-name">Your Name </label>

                            <input type="text" id="orangeForm-name"  name="theName" class="form-control validate" placeholder="Your Name " required>
                        </div>
                        <div class="col-lg-6 col-md-12">
                            <i  style="  font-size: 16px;margin-right: 5px "class="fas fa-user prefix grey-text"></i><label data-error="wrong" data-success="right" for="orangeForm-name">Your  Surname</label>

                            <input type="text" id="orangeForm-nickname"  name="nickname" class="form-control validate" placeholder="Your Surname" required>
                        </div>
                    </div>

                    <div class="md-form mb-5">
                        <i style="  font-size: 16px;margin-right: 5px " class="fas fa-envelope prefix grey-text"></i> <label data-error="wrong" data-success="right" for="orangeForm-email">Your email</label>
                        <input type="email" id="orangeForm-email" name="theEmail" class="form-control validate" placeholder="Your Email">

                    </div>

                    <div class="md-form mb-4">
                        <i  style="  font-size: 16px;margin-right: 5px "class="fas fa-lock prefix grey-text"></i>  <label data-error="wrong" data-success="right" for="orangeForm-pass">Your password</label>
                        <input type="password" name="thePassword" id="orangeForm-pass" class="form-control validate" placeholder="Your password">

                    </div>

                </div>
                <div class="modal-footer d-flex justify-content-center">
                    <button style="width: 44%"class="btn btn-secondary">Sign up</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--  <div class="text-center">-->
<!--      <a href="" class="btn btn-default btn-rounded mb-4" >Launch-->
<!--          Modal Register Form</a>-->
<!--  </div>-->
<!--  <div class="text-center">-->
<!--      <a href="" class="btn btn-default btn-rounded mb-4" data-toggle="modal" data-target="#modalLoginForm">Launch-->
<!--          Modal Login Form</a>-->
<!--  </div>-->





<!--  <script src="/public/js/jquery.form.js"></script>-->

<script
        src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>


<script src="/public/lib/validation/jquery.validate.js"></script>
<script src="/public/js/jquery.form.js"></script>

<script>






    $(".form").ajaxForm({


        complete: function (xhr) {

            var response = xhr.responseText;

            if (response == 1) {

                window.open("/", "_self");

            } else {

                $('#showresults').addClass( "alert alert-danger" );;
                $('#showresults').html(response);




            }

        }

    });




</script>

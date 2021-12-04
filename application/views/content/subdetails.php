<div class="inner-pages">

    <section class="headings"style="background: -webkit-linear-gradient(rgba(32, 51, 100, 0.5), rgba(32, 51, 100, 0.5)), url(../public4/images/bg/bg-details.jpeg) no-repeat center center;
         background: linear-gradient(rgba(32, 51, 100, 0.5), rgba(32, 51, 100, 0.5)), url(../public4/images/bg/bg-details.jpeg) no-repeat center center;">
        <div class="text-heading text-center">
            <div class="container">
                <h1 style="font-size: 17px">Property Details</h1>

            </div>
        </div>
    </section>
    <!-- END SECTION HEADINGS -->

    <!-- START SECTION PROPERTIES LISTING -->
    <section class="blog details">
        <div class="container">
            <div class="row">
                <?php  if (isset($prodact)){
                foreach ($prodact as $key => $value){ ?>
                <div class="col-lg-9 col-md-12 blog-pots">
                    <!-- Block heading Start-->
                    <div class="block-heading details">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-2">
                                <h4>
                            <span class="heading-icon">
                                <i class="fa fa-map-marker"></i>
                                </span>
                                    <span class="hidden-sm-down"><?=  substr($value->theLocation, 0, 30); ?> ... </span>

                                </h4>
                                <div style="margin-top: 10px" class="sortings-options">



                                </div>

                            </div>
                            <div class="col-lg-6 col-md-6 col-10  col-2">
                                <div class="sorting-options"style="  ">
                                    <!--                                    float: right; padding: 10px;margin-right: 60px;
                                                                               float: right; margin-left: 20px;
                                                                               float: left; padding-top: 0; font-size: 16px
                                    -->



                                    <h5  style=" " class="type"> <span>Price:</span> € <?= $value->thePrice ?></h5>

                                    <h5 style=""><span>Type:</span> For Rent</h5>

                                </div>

                            </div>

                        </div>
                    </div>
                    <?php } ?>
                    <!-- Block heading end -->
                    <br>
<!--                    --><?php //foreach ($thePhoto as $value){ ?>
<!--                        <div class="carousel-item">-->
<!--                            <img class="d-block w-100" src="--><?//= $value->thePhoto ?><!--" alt="Second slide">-->
<!--                        </div>-->
<!--                    --><?php //} ?>


                    <div class="row">
                        <div class="col-md-11 mb-4">
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                                <ol class="carousel-indicators">
                                    <?php if ($value->user_id != 0){?>

                                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>

                                    <?php }else{?>
                                    <li data-target="#carouselExampleIndicators" data-slide-to="<?=$key ?>" class="<?php  if ($key == 0) {echo "active"; }  ?>"></li>
                                    <?php  } ?>
                                </ol>
                                <div class="carousel-inner" role="listbox">

                                    <?php if ($value->user_id != 0){?>
                                    <div class="carousel-item active">
                                        <img style="height: 500px" src="/admin/public1/uploads/php/files/prodact_user/medium/<?= $value->thePhoto?>" alt="bbb">

                                    </div>
                                        <?php if (isset($value->thePhoto1)){?>
                                            <div class="carousel-item ">
                                                <img  style="height: 500px;"src="/admin/public1/uploads/php/files/prodact_user1/medium/<?= $value->thePhoto1?>" alt="bbb">

                                            </div>


                                        <?php }?>
                                        <?php if (isset($value->thePhoto2)){?>
                                            <div class="carousel-item ">
                                                <img  style="height: 500px;"src="/admin/public1/uploads/php/files/prodact_user2/medium/<?= $value->thePhoto2?>" alt="bbb">

                                            </div>


                                        <?php }?>
                                        <?php if (isset($value->thePhoto3)){?>
                                            <div class="carousel-item ">
                                                <img  style="height: 500px;" src="/admin/public1/uploads/php/files/prodact_user3/medium/<?= $value->thePhoto3?>" alt="bbb">

                                            </div>


                                        <?php }?>
                                        <?php if (isset($value->thePhoto4)){?>
                                            <div class="carousel-item ">
                                                <img  style="height: 500px;" src="/admin/public1/uploads/php/files/prodact_user4/<?= $value->thePhoto4?>" alt="bbb">

                                            </div>


                                        <?php }?>




                                    <?php }else{?>

                                        <?php foreach ($thePhoto as $key => $value){ ?>
                                            <div class="carousel-item <?php if ($key == 0) {echo "active"; } ?>">
                                                <img style="height: 500px;" class="d-block img-fluid" src="https://admin.hurenkangoedkoper.com/<?= $value->thePhoto ?>" alt="First slide">
                                            </div>
                                        <?php } ?>

                                    <?php }?>


                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>

                        </div>
<!--                        <div class="col-md-11 mb-4">-->


<!--                            </div>-->

                            <?php  foreach ($prodact as $value){ ?>
                            <div class="blog-info details">
                                <!-- cars content -->
                                <div class="homes-content details-2 mb-5">
                                    <!-- cars List -->
                                    <ul  style="width: 100%; margin-left: 40px" class="homes-list clearfix">

                                        <li>
                                            <i class="fa fa-columns" aria-hidden="true"></i>
                                            <span><?= $value->theType ?></span>
                                        </li>
                                        <li>
                                            <i class="fa fa-object-group" aria-hidden="true"></i>
                                            <span>Room : <?= $value->theRoom ?></span>
                                        </li>

                                        <li >
                                            <i class="fa fa-map-marker" aria-hidden="true"></i>
                                            <span><?= $value->theLocation ?></span>
                                        </li>

                                    </ul>
                                </div>
                                <h5 class="mb-4"><?= $value->theTitle ?></h5>
                                <p class="mb-3"><?= $value->theText ?></p>
                            </div>
                        </div>
                    </div>
                    <!-- cars content -->
                    <div class="homes-content details mb-5">
                        <!-- title -->
                        <h5 class="mb-4">Amenities</h5>
                        <!-- cars List -->
                        <ul class="homes-list clearfix">


                            <li>
                                <?php  if(isset($value->pool)){?>
                                    <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                    <i class="far fa-minus-square" aria-hidden="true"></i>
                                <?php }  ?>

                                <span> Pool</span>
                            </li>
                            <li>

                                <?php  if(isset($value->parking)){?>
                                    <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                    <i class="far fa-minus-square" aria-hidden="true"></i>
                                <?php }  ?>
                                <span>Parking</span>
                            </li>
                            <li>
                                <?php  if(isset($value->balcony)){?>
                                    <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                    <i class="far fa-minus-square" aria-hidden="true"></i>
                                <?php }  ?>
                                <span>Balcony</span>

                            </li>
                            <li>
                                <?php  if(isset($value->cable)){?>
                                    <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                    <i class="far fa-minus-square" aria-hidden="true"></i>
                                <?php }  ?>
                                <span>Cable TV</span>
                            </li>
                            <li>
                                <?php  if(isset($value->garden)){?>
                                    <i class="fa fa-check-square" aria-hidden="true"></i>
                                <?php }else{?>
                                    <i class="far fa-minus-square" aria-hidden="true"></i>
                                <?php }  ?>
                                <span>Garden </span>
                            </li>

                        </ul>
                    </div>


                </div>



                <aside class="col-lg-3 col-md-12 car">
                    <div class="widget">
                        <div class="section-heading">
                            <div class="media">
                                <div class="media-left">
                                    <i class="fa fa-home"></i>
                                </div>
                                <div class="media-body">
                                    <h5>Property Owner</h5>
                                    <div class="border"></div>

                                </div>
                            </div>
                        </div>
                        <!-- Search Fields -->

                        <!-- Price Fields -->


                        <div class="recent-post py-5">

                            <div class="recent-main">
                                <div class="card" style="width: 22rem; height: 350px">
                                    <!--                                    <img class="card-img-top" src="/public4/images/partners/1.png" alt="Card image cap">-->
                                    <div class="container">
                                        <div class="card-body" style="padding-top:25px">

                                            <h5 class="card-title"> <i class="fa fa-user" style="padding-right:8px"></i>name: <?= $value->theNameHome ?></h5>
                                            <p style="margin-bottom: 15%" class="card-text"> <i class="fa fa-map-marker"style="padding-right:8px"></i> <?= $value->theLocation ?>.</p>
                                            <p>You can contact the property owner and get detailed <a href="#">information</a>  about the property.</p>
                                            <form action="/order" method="post" enctype="multipart/form-data">
                                                <div class="form-group">
                                                    <input  type="hidden" class="form-control form-control-solid" value="<?= $value->thePrice ?>" name="thePrice" required/>
                                                </div>
                                                <div class="form-group">
                                                    <input  type="hidden" class="form-control form-control-solid" value="<?= $value->theTitle ?>" name="theTitle" required/>
                                                </div>
                                                <div class="form-group">
                                                    <input  type="hidden" class="form-control form-control-solid" value="<?= $value->id ?>" name="id" required/>
                                                </div>



                                        </div>

                                        <?php  if (isset($this->session->name)){?>



<!--                                            <div >-->
                                                <button style="  text-align: center;margin: 0 ; width: 100%; border: none " class="get-quote -down" id="Submit" type="submit">
                                                    <p>Contact</p>
                                                </button>
<!--                                            </div>-->

                                        <?php }else{?>


                                            <div style="  text-align: center;margin: 0  " class="get-quote -down" id="Submit">
                                                <a href="#" data-toggle="modal" data-target="#modalLoginForm">
                                                    <p>Contact</p>
                                                </a>
                                            </div>
                                        <?php }?>

                                        </form>
                                        <br>


                                    </div>

                                </div>
                            </div>


                        </div>
                        <?php }}?>



                            </div>
                        </aside>
                    </div>
            </div>
    </section>

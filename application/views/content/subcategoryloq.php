<!-- Start Subheader -->
<?php foreach ($blogheader as $key => $value) {?>

<section class="bg-half d-table w-100" style="background: url('/public1/uploads/php/files/blogheader/<?= $value->thePhoto?>');">
    <div class="bg-overlay"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12 text-center">
                <div class="page-next-level title-heading">
                    <h1 class="text-white title-dark"> <?= $value->theTitle1tr?> </h1>
                    <p class="text-white-50 para-desc mb-0 mx-auto"> <?= $value->theText1tr?>.</p>
                    <div class="page-next">
                        <nav aria-label="breadcrumb" class="d-inline-block">
                            <ul class="breadcrumb bg-white rounded shadow mb-0">
                                <li class="breadcrumb-item"><a href="index.html">Landrick</a></li>
                                <li class="breadcrumb-item"><a href="#">Company</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Aboutus</li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div><!--end col-->
        </div><!--end row-->
    </div> <!--end container-->
</section><!--end section-->
   <?php }?>
<div class="position-relative">
    <div class="shape overflow-hidden text-white">
        <svg viewBox="0 0 2880 48" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M0 48H1437.5H2880V0H2160C1442.5 52 720 0 720 0H0V48Z" fill="currentColor"></path>
        </svg>
    </div>
</div>


     <!-- End Subheader -->
     <!-- Start Blog -->
     <!--Blog Lists Start-->
    <section class="section">
        <div class="container">
            <div class="row">
                <!-- Blog Post Start -->
                <div class="col-lg-8 col-12">
                    <div class="row">



                      <?php if ($id != 0) {?>
                             <?php foreach ($subcategoryloq as $key => $value){
                               $links2 = $this->db->query("SELECT url FROM links WHERE page = 'subcategoryloq' AND content_id = $value->id")->result_object();
                               if ($links2) {
                                $link2 ='/'.$links2[0]->url;
                              }else {
                                $link2 = "javascript:;";
                              }?>

                        <div class="col-12 mb-4 pb-2">
                            <div class="card blog rounded border-0 shadow overflow-hidden">
                                <div class="row align-items-center g-0">
                                    <div class="col-md-6">
                                        <img src="/public1/uploads/php/files/subcategoryloq/<?= $value->thePhoto?>" class="img-fluid" alt="">
                                        <div class="overlay bg-dark"></div>
                                        <div class="author">
                                            <small class="text-light user d-block"><i class="uil uil-user"></i> Calvin Carlo</small>
                                            <small class="text-light date"><i class="uil uil-calendar-alt"></i> 13th August, 2019</small>
                                        </div>
                                    </div><!--end col-->

                                    <div class="col-md-6">
                                        <div class="card-body content">
                                            <h5><a href="javascript:void(0)" class="card-title title text-dark"><?= $value->theTitleen?></a></h5>
                                            <p class="text-muted mb-0">Due to its widespread use as filler text for layouts, non-readability</p>
                                            <div class="post-meta d-flex justify-content-between mt-3">
                                                <ul class="list-unstyled mb-0">
                                                    <li class="list-inline-item me-2 mb-0"><a href="javascript:void(0)" class="text-muted like"><i class="uil uil-heart me-1"></i>33</a></li>
                                                    <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted comments"><i class="uil uil-comment me-1"></i>08</a></li>
                                                </ul>
                                                <a href="<?= $link2?>" class="text-muted readmore">Read More <i class="uil uil-angle-right-b align-middle"></i></a>
                                            </div>
                                        </div>
                                    </div><!--end col-->
                                </div> <!--end row-->
                            </div><!--end blog post-->
                        </div><!--end col-->
                      <?php }  ?>
                       <?php }else{ ?>
                             <?php foreach ($subAll as $key => $value){
                               $links2 = $this->db->query("SELECT url FROM links WHERE page = 'subcategoryloq' AND content_id = $value->id")->result_object();
                                if ($links2) {
                                    $link2 = '/' . $links2[0]->url;
                                } else {
                                    $link2 = "javascript:;";
                                }
                                 ?>
<!--                                  --><?php //if ($key %2 ==0){ ?>
                                <div class="col-12 mb-4 pb-2">
                                    <div class="card blog rounded border-0 shadow overflow-hidden">
                                        <div class="row align-items-center g-0">
                                            <div class="col-md-6">
                                                <img src="/public1/uploads/php/files/subcategoryloq/<?= $value->thePhoto?>" class="img-fluid" alt="">
                                                <div class="overlay bg-dark"></div>
                                                <div class="author">
                                                    <small class="text-light user d-block"><i class="uil uil-user"></i> Calvin Carlo</small>
                                                    <small class="text-light date"><i class="uil uil-calendar-alt"></i> 13th August, 2019</small>
                                                </div>
                                            </div><!--end col-->

                                            <div class="col-md-6">
                                                <div class="card-body content">
                                                    <h5><a href="javascript:void(0)" class="card-title title text-dark"><?= $value->theTitleen?></a></h5>
                                                    <p class="text-muted mb-0">Due to its widespread use as filler text for layouts, non-readability</p>
                                                    <div class="post-meta d-flex justify-content-between mt-3">
                                                        <ul class="list-unstyled mb-0">
                                                            <li class="list-inline-item me-2 mb-0"><a href="javascript:void(0)" class="text-muted like"><i class="uil uil-heart me-1"></i>33</a></li>
                                                            <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted comments"><i class="uil uil-comment me-1"></i>08</a></li>
                                                        </ul>
                                                        <a href="<?= $link2?>" class="text-muted readmore">Read More <i class="uil uil-angle-right-b align-middle"></i></a>
                                                    </div>
                                                </div>
                                            </div><!--end col-->
                                        </div> <!--end row-->
                                    </div><!--end blog post-->
                                </div><!--end col-->
<!--                              --><?php }//}  else { ?>

<!--                                <div class="col-12 mb-4 pb-2">-->
<!--                                <div class="card blog rounded border-0 shadow overflow-hidden">-->
<!--                                    <div class="row align-items-center g-0">-->
<!--                                        <div class="col-md-6 order-2 order-md-1">-->
<!--                                            <div class="card-body content">-->
<!--                                                <h5><a href="javascript:void(0)" class="card-title title text-dark">Design your apps in your own way</a></h5>-->
<!--                                                <p class="text-muted mb-0">Due to its widespread use as filler text for layouts, non-readability</p>-->
<!--                                                <div class="post-meta d-flex justify-content-between mt-3">-->
<!--                                                    <ul class="list-unstyled mb-0">-->
<!--                                                        <li class="list-inline-item me-2 mb-0"><a href="javascript:void(0)" class="text-muted like"><i class="uil uil-heart me-1"></i>33</a></li>-->
<!--                                                        <li class="list-inline-item"><a href="javascript:void(0)" class="text-muted comments"><i class="uil uil-comment me-1"></i>08</a></li>-->
<!--                                                    </ul>-->
<!--                                                    <a href="page-blog-detail.html" class="text-muted readmore">Read More <i class="uil uil-angle-right-b align-middle"></i></a>-->
<!--                                                </div>-->
<!--                                            </div>-->
<!--                                        </div><!--end col-->-->
<!---->
<!--                                        <div class="col-md-6 order-1 order-md-2">-->
<!--                                            <img src="images/work/15.jpg" class="img-fluid" alt="">-->
<!--                                            <div class="overlay bg-dark"></div>-->
<!--                                            <div class="author">-->
<!--                                                <small class="text-light user d-block"><i class="uil uil-user"></i> Calvin Carlo</small>-->
<!--                                                <small class="text-light date"><i class="uil uil-calendar-alt"></i> 13th August, 2019</small>-->
<!--                                            </div>-->
<!--                                        </div>end col-->
<!--                                    </div> <!--end row-->
<!--                                </div><!--end blog post-->
<!--                            </div>-->
<!---->
<!--                            --><?php //} ?>
<!--                            --><?php //}?>
                            <?php }?>

                    </div><!--end row-->
                </div><!--end col-->
                <!-- Blog Post End -->

                <!-- START SIDEBAR -->
                <div class="col-lg-4 col-12 mt-4 mt-lg-0 pt-2 pt-lg-0">
                    <div class="card border-0 sidebar sticky-bar rounded shadow">
                        <div class="card-body">
                            <!-- SEARCH -->
                            <div class="widget">
                                <form role="search" method="get">
                                    <div class="input-group mb-3 border rounded">
                                        <input type="text" id="s" name="s" class="form-control border-0" placeholder="Search Keywords...">
                                        <button type="submit" class="input-group-text bg-transparent border-0" id="searchsubmit"><i class="uil uil-search"></i></button>
                                    </div>
                                </form>
                            </div>
                            <!-- SEARCH -->

                            <!-- Categories -->
                            <div class="widget mb-4 pb-2">
                                <h5 class="widget-title">Categories</h5>
                                <ul class="list-unstyled mt-4 mb-0 blog-categories">
                                  <?php foreach ($categoryloq as $key => $value):
                                       $links2 = $this->db->query("SELECT url FROM links WHERE page = 'categoryloq' AND content_id = $value->id")->result_object();
                                        if ($links2) {
                                            $link2 = '/' . $links2[0]->url;
                                        } else {
                                            $link2 = "javascript:;";
                                        }  ?>

                                         <li><a href="<?=$link2?>"><?=$value->theName?></a> <span class="float-end">( -- )</span></li>
                                       <?php endforeach; ?>


                                </ul>
                            </div>
                            <!-- Categories -->








                            <!-- TAG CLOUDS -->
                            <div class="widget mb-4 pb-2">
                                <h5 class="widget-title">Tags Cloud</h5>
                                <div class="tagcloud mt-4">

                                      <?php foreach ($categoryloq as $key => $value):
                                         $links2 = $this->db->query("SELECT url FROM links WHERE page = 'categoryloq' AND content_id = $value->id")->result_object();
                                        if ($links2) {
                                          $link2 = '/' . $links2[0]->url;
                                        } else {
                                        $link2 = "javascript:;";
                                    }  ?>
                                      <a href="<?=$link2?>" class="rounded"><?=$value->theName?></a>

                                 <?php endforeach; ?>


                                </div>
                            </div>
                            <!-- TAG CLOUDS -->

                            <!-- SOCIAL -->
                            <div class="widget">
                                <h5 class="widget-title">Follow us</h5>
                                <ul class="list-unstyled social-icon mb-0 mt-4">
                                  <?php foreach ($footer3 as $key => $value){ ?>

                                  <li class="list-inline-item"><a href="<?= $value->url?>" class="rounded"><i data-feather="<?= $value->icon?>" class="<?= $value->icon?>"></i></a></li>
                                  <!-- <li class="list-inline-item"><a href="<?= $value->url?>" class="rounded"><i data-feather="<?= $value->icon?>" class="f<?= $value->icon?>"></i></a></li> -->
                                <?php } ?>


                                </ul><!--end icon-->
                            </div>
                            <!-- SOCIAL -->
                        </div>
                    </div>
                </div><!--end col-->
                <!-- END SIDEBAR -->
            </div><!--end row-->
        </div><!--end container-->
    </section>

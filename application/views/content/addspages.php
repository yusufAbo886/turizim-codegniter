<!-- Start About -->

<!-- Start Subheader -->
  <?php foreach ($submenu as $key => $value) {?>
<div class="sub-header p-relative"  style="background-image: url('/public1/uploads/php/files/submenu/<?= $value->thePhoto?>');">
  <!-- <img src="/public1/uploads/php/files/aboutheader/<?= $value->thePhoto?>"  class="aboutheader" alt="..."> -->

    <div class="overlay overlay-bg-black"></div>
    <div class="pattern"></div>
    <div class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12">

                    <div class="sub-header-content p-relative" >
                        <h1 class="text-custom-white lh-default fw-600"><?= $value->theTitle1en?></h1>
                        <ul class="custom">
                            <li>
                                <a href="index.html" class="text-custom-white">Home</a>
                            </li>
                            <li class="text-custom-white active">About Us</li>
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- End Subheader -->
<section class="section-padding bg-light-white about-story">
           <div class="container">
<div class="section-header">
                   <div class="section-heading">
                       <h3 class="text-custom-black fw-700"><?= $value->theTitle1en?></h3>
                       <img src="/public3/assets/images/title-icon.png" class="mb-xl-20" alt="img">
                       <div class="section-description">
                           <p class="text-light-white">
                              <?= $value->theText1en?>
                           </p>
                       </div>
                   </div>
               </div>
               </div>
             </section>

  <?php }?>
  <?php foreach ($add_pages as $key => $value){?>
   <?php if ($key %2 ==0){ ?>

      <section class="section-padding-top about-sec">
          <div class="container">
              <div class="row justify-content-between">


                  <div class="col-xl-6 col-lg-6">
                    <div class="section-header">
                           <div class="section-heading">
                               <h4 class="text-custom-black fw-700"><?= $value->theTitleen?></h4>
                               <img src="public3/assets/images/title-icon.png" class="mb-xl-20" alt="img">

                           </div>

                       </div>
                       <div class="about-wrapper mb-xl-80">
                           <p class="text-custom-black">
                               <?= $value->theTexten?>
                           </p>

                       </div>

                       </div>
                       <div class="col-xl-6 col-lg-6 align-self-end">
                       <div class="doctor-img">
                           <img src="/public1/uploads/php/files/addpages/<?= $value->thePhoto?>" class="img-fluid image-fit" alt="doctor">
                       </div>
                   </div>






              </div>
          </div>
      </section>
<?php } else { ?>


  <section class="why-choose-us-style-2 section-padding bg-light-white">
      <div class="container">

          <div class="row">
              <div class="col-12">
                  <div class="square-tabs">

                      <div class="tab-content padding-20 bg-custom-white">
                          <div class="tab-pane container active" id="teeth-whitening">
                              <div class="tab-inner">
                                  <div class="row">
                                      <div class="col-lg-6">
                                          <div class="img-sec mb-md-40">
                                              <img src="public1/uploads/php/files/addpages/<?= $value->thePhoto?>" class="full-width" alt="img">
                                          </div>
                                      </div>
                                      <div class="col-lg-6 align-self-center">
                                          <div class="content-box">
                                              <h4 class="text-custom-black"><?= $value->theTitleen?></h4>
                                              <p class="text-light-white"> <?= $value->theTexten?></p>

                                          </div>
                                      </div>
                                  </div>
                              </div>
                          </div>



                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </section>


<?php } ?>
  <?php } ?>
  <!-- Start why choose us -->

  <!-- End why choose us -->

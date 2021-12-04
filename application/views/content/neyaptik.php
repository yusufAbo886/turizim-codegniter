<?php foreach ($projectheader as $key => $value) {?>


<section class="bg-half d-table w-100" style="background: url('/public1/uploads/php/files/projectheader/<?= $value->thePhoto?>');">
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


<!-- Start -->
     <section class="section">
         <div class="container">

             <div class="row justify-content-center">
                 <div class="col-lg-10">
                     <div id="grid" class="row">
                        <?php foreach ($projectphoto as $key => $value) {?>
                         <div class="col-md-6 col-12 mt-4 pt-2 picture-item" data-groups='["branding"]'>
                             <div class="card border-0 work-container work-classic">
                                 <div class="card-body p-0">
                                     <a href="portfolio-detail-one.html"><img src="/public1/uploads/php/files/projectphoto/<?= $value->thePhoto?>" class="img-fluid rounded work-image" alt="<?= $value->alt?>"></a>
                                     <div class="content pt-3">
                                         <h5 class="mb-0"><a href="portfolio-detail-one.html" class="text-dark title">Iphone mockup</a></h5>
                                         <h6 class="text-muted tag mb-0">Branding</h6>
                                     </div>
                                 </div>
                             </div>
                         </div><!--end col-->
                         <?php }?>













                     </div><!--end row-->
                 </div>
             </div>


             <!-- PAGINATION END -->
         </div><!--end container-->
     </section><!--end section-->
     <!-- End -->

     <section class="section">
           <div class="container mt-100 mt-60">


               <div class="row justify-content-center">
                   <div class="col-lg-12 mt-4">
                       <div class="tiny-three-item">








                           <?php foreach ($projectslider as $key => $value) {?>
                           <div class="tiny-slide">
                               <div class="d-flex client-testi mt-2">
                                   <img src="/public1/uploads/php/files/projectslider/<?= $value->thePhoto?>" class=" avatar-small client-image rounded shadow" alt="">
                                   <!-- <div class="flex-1 content p-3 shadow rounded bg-white position-relative">

                                       <p class="text-muted mt-2">" Thus, Lorem Ipsum has only limited suitability as a visual filler for German texts. "</p>
                                       <h6 class="text-primary">- Jill Webb <small class="text-muted">Designer</small></h6>
                                   </div> -->
                               </div>
                           </div>
                              <?php }?>


                       </div>
                   </div><!--end col-->
               </div><!--end row-->
           </div><!--end container-->
       </section><!--end section-->
       <!-- End -->


       <!-- Start -->
       <section class="section">
           <div class="container">

               <div id="grid" class="row">




                       <?php foreach ($youtube as $key => $value) {?>
                   <div class="col-lg-4 col-md-6 col-12 mt-4 pt-2 picture-item" data-groups='["branding"]'>
                       <div class="card border-0 work-container work-classic">
                           <div class="card-body p-0">

                                           <?= $value->youtube?>



                           </div>
                       </div>
                   </div><!--end col-->
                   <?php }?>
               </div><!--end row-->

               <!-- PAGINATION START -->
               <!-- PAGINATION END -->
           </div><!--end container-->
       </section><!--end section-->
       <!-- End -->

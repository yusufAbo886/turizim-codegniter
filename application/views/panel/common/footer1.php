
<footer class="first-footer">
    <div class="top-footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <?php foreach ($footer11 as $value){?>
                        <div class="netabout">
                            <a href="/" class="logo">
                                <img  src="<?= $value->thePhoto ?>" alt="netcom">
                            </a>
                            <p><?= $value->theText ?>.</p>

                        </div>
                    <?php }?>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="navigation">
                        <h3>Contact US</h3>
                        <div class="nav-footer">
                            <ul>
                                <?php foreach ($footer22 as $value){?>

                                    <li><a href="mailto:info@hurenkangoedkoper.com?subject = Feedback&body = Message"><?= $value->theEmail1 ?></a></li>
                                    <li><a href="mailto:abc@example.com?subject = Feedback&body = Message"><?= $value->theEmail2 ?></a></li>
                                    <li><a href="https://wa.me/15551234567"><?= $value->thePhone1 ?></a></li>
                                    <li><a href="https://wa.me/15551234567"><?= $value->thePhone2 ?></a></li>
                                <?php }?>
                            </ul>

                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="widget">
                        <h3>Follow US</h3>
                        <div class="twitter-widget contuct">
                            <div class="twitter-area">
                                <?php foreach ($footer33 as $value ){?>

                                    <div class="single-item">

                                        <div class="text">
                                            <h5><i style="padding-right: 7px" class="fas fa-hand-point-right"></i> <a href="<?= $value->url ?>">@<?= $value->theTitle ?></a> .</h5>

                                        </div>
                                    </div>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="contactus">
                        <h3>Our Location</h3>
                        <?php foreach ($footer44 as $value){?>
                            <div class="netabout">

                                <p><?= $value->theAddress ?>.</p>

                            </div>
                        <?php }?>
                    </div>
                    <ul style="border: none;" class="netsocials">
                        <?php foreach ($footer33 as $value ){?>

                            <li ><a href="<?= $value->url ?>"><i style="border: none;" class="fa <?= $value->icon ?>" aria-hidden="true"></i></a></li>
                        <?php }?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="second-footer">
        <div class="container">
            <p>2018 © Copyright - All Rights Reserved.</p>
            <p> <i class="fa fa-heart" aria-hidden="true"></i> </p>
        </div>
    </div>
</footer>








<!-- ARCHIVES JS -->
<script src="/public4/js/jquery.min.js"></script>
<script src="/public4/js/jquery-ui.js"></script>
<script src="/public4/js/tether.min.js"></script>
<script src="/public4/js/moment.js"></script>
<script src="/public4/js/transition.min.js"></script>
<script src="/public4/js/bootstrap.min.js"></script>
<script src="/public4/js/fitvids.js"></script>
<script src="/public4/js/jquery.waypoints.min.js"></script>
<script src="/public4/js/jquery.counterup.min.js"></script>
<script src="/public4/js/imagesloaded.pkgd.min.js"></script>
<script src="/public4/js/isotope.pkgd.min.js"></script>
<script src="/public4/js/smooth-scroll.min.js"></script>
<script src="/public4/js/lightcase.js"></script>
<script src="/public4/js/owl.carousel.js"></script>
<script src="/public4/js/jquery.magnific-popup.min.js"></script>
<script src="/public4/js/ajaxchimp.min.js"></script>
<script src="/public4/js/newsletter.js"></script>
<script src="/public4/js/jquery.form.js"></script>
<script src="/public4/js/jquery.validate.min.js"></script>
<script src="/public4/js/forms-2.js"></script>
<!--<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAqb3fT3SbMSDMggMEK7fJOIkvamccLrjA"></script>-->
<!--  <script src="/public4/js/map4.js"></script>-->

<!-- Slider Revolution scripts -->
<script src="/public4/revolution/js/jquery.themepunch.tools.min.js"></script>
<script src="/public4/revolution/js/jquery.themepunch.revolution.min.js"></script>
<script src="/public4/revolution/js/extensions/revolution.extension.actions.min.js"></script>
<script src="/public4/revolution/js/extensions/revolution.extension.carousel.min.js"></script>
<script src="/public4/revolution/js/extensions/revolution.extension.kenburn.min.js"></script>
<script src="/public4/revolution/js/extensions/revolution.extension.layeranimation.min.js"></script>
<script src="/public4/revolution/js/extensions/revolution.extension.migration.min.js"></script>
<script src="/public4/revolution/js/extensions/revolution.extension.navigation.min.js"></script>
<script src="/public4/revolution/js/extensions/revolution.extension.parallax.min.js"></script>
<script src="/public4/revolution/js/extensions/revolution.extension.slideanims.min.js"></script>
<script src="/public4/revolution/js/extensions/revolution.extension.video.min.js"></script>

<!-- problem  -->

 <!-- <script src="/public2/assets/plugins/global/plugins.bundle.js"></script> -->
<script src="/public2/assets/plugins/custom/datatables/datatables.bundle.js"></script>
<!-- end problem  -->

<script src="/public1/lib/bootstrap/js/bootstrap.min.js"></script>

<script src="/public1/js/admin/jasny-bootstrap.min.js"></script>

<script src="/public1/js/admin/bootbox.min.js"></script>



<script src="/public1/uploads/vendor/jquery.ui.widget.js"></script>

<script src="/public1/uploads/jquery.iframe-transport.js"></script>

<script src="/public1/uploads/jquery.fileupload.js"></script>

<script src="/public1/lib/validation/jquery.validate.js"></script>



<script src="/public1/js/common.js"></script>

<script src="/public1/lib/datePicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

<script src="/public1/lib/datePicker/moment.js" type="text/javascript"></script>

<script src="/public1/lib/datePicker/daterangepicker.js" type="text/javascript"></script>










<!--  <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>-->
<!--  <script src="/public4/jquery-ui-1.11.4/jquery-ui.min.js"></script>-->













<script>

function myFunction(id){
  // var id = $(this).attr("rel");
   $.post("/site/ajax/deleteProdactUser/"+id ,function( result ) {
       // $.post("/panel/ajax/"+url, { id : id }, function( result ) {

       if (result == 1) {

           location.reload();
       }

   });
};
// $(".post_list").on("click",".deletebtn",function(){
//     var data_id = $(this).attr("rel");
//      $.post("/site/ajax/deleteProdactUser/"+data_id ,function( result ) {
//
//      // $(".post_list").html(srp);
//      if (result == 1) {
//
//          location.reload();
//      }
//    });
//
// })
// if(document.getElementById('deletebtn').clicked == true){
//    alert("button was clicked");
   // var id = $(this).attr("data-id");
   //  $.post("/panel/ajax/deleteProdactUser"+id, function( result ) {
   //
   //      if (result == 1) {
   //
   //          location.reload();
   //      }
   //
   //  });
// }
</script>
<script>
    function modalConfirm($elm, mText, mTitle, mCancelLabel, mOkLabel, postCallback) {
        name = $elm.data("name");
        href = $elm.data("href");
        bootbox.dialog({
            message: mText,
            title: mTitle + " - ( " + name + " )",
            buttons: {
                cancel: {
                    label: mCancelLabel,
                    className: "btn-success",
                    callback: function () {
                    }
                },
                ok: {
                    label: mOkLabel,
                    className: "btn-danger",
                    callback: function () {
                        $.post(href, function () {
                            postCallback();
                        });
                    }
                }
            }
        });
    }




    $(document).on("click", ".navbar-toggle", function () {
        $(".sidebar").toggleClass("open");
    });


</script>



</body>
</html>

<div class="inner-pages">
    <section class="headings" style="background: -webkit-linear-gradient(rgba(32, 51, 100, 0.5), rgba(32, 51, 100, 0.5)), url(../public4/images/bg/bg-details.jpeg) no-repeat center center;
         background: linear-gradient(rgba(32, 51, 100, 0.5), rgba(32, 51, 100, 0.5)), url(../public4/images/bg/bg-details.jpeg) no-repeat center center;">
        <div class="text-heading text-center">
            <div class="container">
                <h1>Properties</h1>

            </div>
        </div>
    </section>
    <section class="contact-us">

        <div class="container">









            <div class="row" style="margin-bottom: 4rem">


                <div class="col-lg-7 col-md-12"style="margin-right: 4rem">
                    <h3 class="mb-4">Contact Us</h3>
                    <form id="ontactform"  action="/ajax/contactus"class="form" name="contactform" method="post" novalidate>
                        <div id="success" class="successform">
                            <p class="alert alert-success font-weight-bold" role="alert">Your message was sent successfully!</p>
                        </div>
                        <div id="error" class="errorform">
                            <p>Something went wrong, try refreshing and submitting the form again.</p>
                        </div>
                        <div class="form-group">
                            <input type="text" required class="form-control input-custom input-full" id="firstName" name="firstName" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <input type="text" required class="form-control input-custom input-full"id="lastName"  name="lastName" placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-control input-custom input-full" id="email" name="email" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control textarea-custom input-full" id="message" name="message" required rows="8" placeholder="Message"></textarea>
                        </div>
                        <button type="submit" id="submit-contact" class="btn btn-primary btn-lg">Submit</button>
                    </form>
                </div>

                <div class="col-lg-4 col-md-12 bgc">
                    <div class="call-info">
                        <h3>Contact Details</h3>
                        <p class="mb-5">Please find below contact details and contact us today!</p>
                        <ul>
                            <li>
                                <?php foreach ($footer4 as $value){?>
                                    <div class="info">
                                        <i class="fa fa-map-marker" aria-hidden="true"></i>
                                        <p class="in-p"><?= $value->theAddress ?></p>
                                    </div>
                                <?php }?>
                            </li>
                            <li>
                                <?php foreach ($footer2 as $value){?>
                                    <div class="info">
                                        <i class="fa fa-phone" aria-hidden="true"></i>
                                        <p class="in-p"><?= $value->thePhone1?></p>
                                    </div>
                                <?php }?>
                            </li>
                            <li>
                                <?php foreach ($footer2 as $value){?>
                                    <div class="info">
                                        <i class="fa fa-envelope" aria-hidden="true"></i>
                                        <p class="in-p ti"><?= $value->theEmail1?></p>
                                    </div>
                                <?php }?>
                            </li>
                            <li>
                                <div class="info cll">
                                    <i class="fa fa-clock-o" aria-hidden="true"></i>
                                    <p class="in-p ti">8:00 a.m - 9:00 p.m</p>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

        </div>
    </section>




</div>
<script src="/public/lib/validation/jquery.validate.js"></script>
<script src="/public/js/jquery.form.js"></script>
<script>
    jQuery.validator.addMethod("phone", function (phone_number, element) {
            return this.optional(element) || /^\d{8,}$/.test(phone_number.replace(/[()\s+-]/g, ''));
        },
        "Please enter a valid phone number."
    );
    $(".form").validate({
        highlight: function (element) {
            $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element) {
            $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
        },
        rules: {
            name: {required: true},
            lastName: {required: true},
            email: {required: true, email: true},
            message: {required: true, minlength: 15}
        },
        errorPlacement: function (error, element) {
            error.insertAfter(element);
        },
        submitHandler: function (form) {
            var data = $(this.currentForm).serialize();
            var postURL = $(this.currentForm).attr("action")
            $.post(postURL, data, function (response) {
                if (response == 1) {
                    $(".sendingSuccess").show();
                    $("#name").val('');
                    $("#lastName").val('');
                    $("#email").val('');
                    $("#message").val('');

                    setTimeout(function () {
                        location.reload();
                    }, 2000);

                } else {
                    $(".sendingError").append("<br>" + response).show();
                    setTimeout(function () {
                        $(".sendingError").fadeOut("slow");
                    }, 3000);
                }
                setTimeout(function () {
                    $(".sendingSuccess").fadeOut("slow");
                }, 3000);
            });
        }
    });



</script>


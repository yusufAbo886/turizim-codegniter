<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="en">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--        <meta name="viewport" content="width=device-width, initial-scale=1">-->
        <meta name="description" content="File Upload widget with multiple file selection, drag&amp;drop support, progress bars, validation and preview images, audio and video for jQuery. Supports cross-domain, chunked and resumable file uploads and client-side image resizing. Works with any server-side platform (PHP, Python, Ruby on Rails, Java, Node.js, Go etc.) that supports standard HTML form file uploads.">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="">
        <title>Take Off - CMS</title>

        <!-- Bootstrap Core CSS -->
        <link href="/public/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/public/css/admin/jasny-bootstrap.min.css" rel="stylesheet" />
        <link href="/public/css/admin/admin.css" rel="stylesheet" />

        <link rel="stylesheet" href="/public/uploads/css/jquery.fileupload.css" />
        <script src="/public/js/jquery.js"></script>
        <script src="/public/lib/bootstrap/js/bootstrap.min.js"></script>
        <script src="/public/lib/ckeditor/ckeditor.js"></script>
        <script src="/public/lib/validation/jquery.validate.js"></script>
        <script src="/public/js/common.js"></script>

        <link href="/public/css/admin/dataTables.bootstrap.css" rel="stylesheet" />

        <script src="/public/js/admin/jquery.dataTables.min.js"></script>
        <!-- Bootbox-->
        <script src="/public/js/admin/bootbox.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"/>

        <link href="https://fonts.googleapis.com/css?family=Cairo&amp;subset=arabic" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet"/>

        <script src="/public/js/admin/jasny-bootstrap.min.js"></script>
        <script src="/public/uploads/vendor/jquery.ui.widget.js"></script>
        <script src="/public/uploads/jquery.iframe-transport.js"></script>
        <script src="/public/uploads/jquery.fileupload.js"></script>
        <script src="/public/js/admin/bootbox.min.js"></script>

        <!--              standart datepicker-->
        <link href="/public/lib/datePicker/css/bootstrap-datepicker3.min.css" rel="stylesheet" type="text/css"/>
        <script src="/public/lib/datePicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

        <link href="/public/lib/datePicker/daterangepicker.css" rel="stylesheet" type="text/css"/>
        <script src="/public/lib/datePicker/moment.js" type="text/javascript"></script>
        <script src="/public/lib/datePicker/daterangepicker.js" type="text/javascript"></script>


        <script src="/public/lib/ckeditor/ckeditor.js" type="text/javascript"></script>

        <!--Fav icoan-->
        <link rel="shortcut icon" href="/public/uploads/php/files/logos/thumbnail/<?= $theLogo[0]->theValue ?>" type="image/x-icon"/>
        <link rel="icon" href="/public/uploads/php/files/logos/thumbnail/<?= $theLogo[0]->theValue ?>" type="image/x-icon"/>

        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
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
    </head>
    <body>
        <div id="wrapper">
            <nav class="navbar navbar-primary navbar-static-top" role="navigation" style="margin-bottom: 0;background-color:<?= $theColor[1]->theValue ?>;">
                <div class="navbar-header navbar-left pull-left">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand hidden-xs" href="/admin/"><img src="/public/uploads/php/files/logos/thumbnail/<?= $theLogo[0]->theValue ?>" alt="" class="img-responsive"/></a>

                </div>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="glyphicon glyphicon-user userIcon"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li>
                                <a href="/admin/logout/"><i class="glyphicon glyphicon-log-out"></i> Logout</a>
                            </li>
                        </ul>
                    </li>
                </ul>
                <div class="clearfix"></div>

                <!-- /.navbar-static-side -->
            </nav>

            <div class="navbar-default sidebar" role="navigation" style="background-color:<?= $theColor[1]->theValue ?>;">
                <div class="sidebar-nav navbar-collapse collapse" aria-expanded="false" >
                    <ul class="nav" id="side-menu">
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="users" href="/admin/users"><i class="fa fa-user-circle-o" aria-hidden="true"></i> Users</a>
                        </li>
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="homeSlider" href="/admin/homeSlider"><i class="fa fa-sliders" aria-hidden="true"></i> Home Slider</a>
                        </li>
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="aboutUs" href="/admin/aboutUs"><i class="fa fa-comment" aria-hidden="true"></i> About Us</a>
                        </li>
<!--                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="towns" href="/admin/towns"><i class="fa fa-building" aria-hidden="true"></i>Towns</a>
                        </li>-->
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="categories" href="/admin/categories"><i class="fa fa-bars" aria-hidden="true"></i> <?= $this->lang->line("touristServices") ?></a>
                        </li>
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="categories4" href="/admin/plans4"><i class="fa fa-ellipsis-v" aria-hidden="true"></i> <?= $this->lang->line("touristServices2") ?></a>
                        </li>
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="realCategories" href="/admin/real_categories"><i class="fa fa-bars" aria-hidden="true"></i> <?= $this->lang->line("realServices") ?></a>
                        </li>
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="medicalCategories" href="/admin/plans3"><i class="fa fa-ellipsis-v" aria-hidden="true"></i> <?= $this->lang->line("medicalTourism") ?></a>
                        </li>
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="blog" href="/admin/blog"><i class="fa fa-bars" aria-hidden="true"></i> Blog </a>
                        </li>
<!--                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="gallery" href="/admin/tags"><i class="fa fa-photo" aria-hidden="true"></i> Gallery & Tags</a>
                        </li> -->
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="photos" href="/admin/photos"><i class="fa fa-photo" aria-hidden="true"></i> Photos On Each Page</a>
                        </li>
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="contactUs" href="/admin/contactUs"><i class="fa fa-phone-square" aria-hidden="true"></i> Contact Us</a>
                        </li>
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="socialMedia" href="/admin/socialMedia"><i class="fa fa-facebook" aria-hidden="true"></i> Social Media</a>
                        </li>
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="contactUsForm" href="/admin/contactUsForm"><i class="fa fa-bars" aria-hidden="true"></i> Contact Us Form</a>
                        </li>
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="orders" href="/admin/orders"><i class="fa fa-list" aria-hidden="true"></i> Order Form</a>
                        </li>
<!--                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;"  class="courseForm" href="/admin/courseForm"><i class="fa fa-bars" aria-hidden="true"></i> Course Form</a>
                        </li>-->
<!--                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;" class="commonQuestions" href="/admin/commonQuestions"><i class="fa fa-question" aria-hidden="true"></i> Common Questions (FAQ) </a>
                        </li>
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;" class="homePage" href="/admin/homePage"><i class="fa fa-bars" aria-hidden="true"></i> Number on HomePage </a>
                        </li> -->
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;" class="subscribers" href="/admin/subscribers"><i class="fa fa-users" aria-hidden="true"></i> Subscribers </a>
                        </li>
                        <li>
                            <a style="background-color:<?= $theColor[1]->theValue ?>; color:<?= $theColor[0]->theValue ?>;" class="setting" href="/admin/setting"><i class="fa fa-sliders" aria-hidden="true"></i> Setting</a>
                        </li>

                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>


            <div id="page-wrapper">
<script>

    $(document).ready(function () {
        $(document).ready(myfunction);
        $(window).on('resize', myfunction);
        function myfunction() {
            var windowsh = $(window).height() - 150;
            $("#page-wrapper").css("min-height", windowsh);
        }
    });

</script>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <title> Login - CMS</title>

        <!--Fav icoan-->
        <link rel="shortcut icon" href="/public/uploads/php/files/logos/thumbnail/<?= $theLogo[0]->theValue ?>" type="image/x-icon"/>
        <link rel="icon" href="/public/uploads/php/files/logos/thumbnail/<?= $theLogo[0]->theValue ?>" type="image/x-icon"/>

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css"/>
        <link href="https://fonts.googleapis.com/css?family=Amaranth" rel="stylesheet"/>

        <link href="/public/lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
        <link href="/public/css/admin/admin.css" rel="stylesheet" />
        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>

        <div class="fullPage">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 col-md-offset-4 sectionLogin">
                        <div class="login-panel panel panel-default">
                            <div class="panel-heading" style="text-align: center;">
                                <img class="img-responsive animated" src="/public/uploads/php/files/logos/<?= $theLogo[0]->theValue ?>" />
                            </div>
                            <?php if ($status == 1) { ?>
                                <div class="alert alert-danger" role="alert">
                                    Please check username and password.
                                </div>
                            <?php } ?>
                            <div class="panel-body">
                                <?php echo form_open(); ?>
                                <div class="form-group">
                                    <input class="form-control one animated" placeholder="username" name="username" type="text" autofocus />
                                </div>
                                <div class="form-group">
                                    <input class="form-control two animated" placeholder="password" name="password" type="password" value="" />
                                </div>
                                <button type="submit" class="btn btn-lg btn-primary btn-block animated">Login</button>

                                <?php echo form_close(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <script src="/public/js/jquery.js"></script>
        <script src="/public/lib/bootstrap/js/bootstrap.min.js"></script>


        <script>


            $(document).ready(function () {


                setTimeout(function () {
                    $(".sectionLogin").addClass("animate");
                }, 1000);

                setTimeout(function () {
                    $(".sectionLogin img").addClass("bounceInDown");
                }, 2200);

                setTimeout(function () {
                    $(".sectionLogin input.one").addClass("zoomInUp");
                }, 2700);

                setTimeout(function () {
                    $(".sectionLogin input.two").addClass("zoomInUp");
                }, 3000);

                setTimeout(function () {
                    $("button.btn-block").addClass("zoomInUp");
                }, 3300);




                $(document).ready(myfunction);
                $(window).on('resize', myfunction);

                function myfunction() {
                    var windowsh = $(window).height();
                    $(".fullPage").css("height", windowsh);
                }




                var background = '<?= $theColor[1]->theValue ?>';
                var color = '<?= $theColor[0]->theValue ?>';

                $(".btn-primary").css("background-color", "" + background + "");
                $(".btn-primary").css("color", "" + color + "");
                $(".btn-primary").css("border-color", "" + color + "");


                $(document).on("focus", ".form-control", function () {
                    $(".form-control").css("border-color", "#ccc");
                    $(".form-control").css("-webkit-box-shadow", "inset 0 1px 1px rgba(0,0,0,.075)");
                    $(".form-control").css("box-shadow", "inset 0 1px 1px rgba(0,0,0,.075)");
                    $(this).css("border-color", background);
                    $(this).css("-webkit-box-shadow", "inset 0 1px 1px " + background + ", 0 0 8px " + background + "");
                    $(this).css("box-shadow", "inset 0 1px 1px " + background + ", 0 0 8px " + background + "");
                });

                $(document).on("focusout", ".form-control", function () {
                    $(".form-control").css("border-color", "#ccc");
                    $(".form-control").css("-webkit-box-shadow", "inset 0 1px 1px rgba(0,0,0,.075)");
                    $(".form-control").css("box-shadow", "inset 0 1px 1px rgba(0,0,0,.075)");
                });



            });


        </script>


    </body>
</html>

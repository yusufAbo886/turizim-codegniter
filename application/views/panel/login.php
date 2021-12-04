



<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Yinka Enoch Adedokun">
    <title>Admin Panel</title>
    <link rel="shortcut icon" href="/public4/images/con_only.png" />
    <link rel="shortcut icon" type="/public4/images/con_only.png" href="/public4/images/con_only.png">
</head>
<style>
    body{
        background-image: url("/public/source/610cf7270fdc0.jpg");
        background-position: center; /* Center the image */
        background-repeat: no-repeat; /* Do not repeat the image */
        background-size: cover;
        background-color: #cccccc; /* Used if the image is unavailable */
    }


    .main-content{
        /*width: 50%;*/
        border-radius: 20px;
        /*box-shadow: 0 5px 5px rgba(0,0,0,.4);*/
        /*margin: 5em auto;*/

        display: flex;
        /*position: absolute;*/
        /*left: 50%;*/
        /*top: 50%;*/
        /*-webkit-transform: translate(-50%, -50%);*/
        /*transform: translate(-50%, -50%);*/

        position: absolute;
        left: 55%;
        top: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);

    }
    .company__info{
        background-color: #0098ef;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        color: #fff;


    }
    /*input[type=radio], input[type=checkbox] {*/
    /*    padding-top: 10px;*/
    /*}*/
    /*#remember_me{*/

    /*}*/
    .fa-android{
        font-size:3em;
    }
    @media screen and (max-width: 640px) {
        .main-content{width: 90%;}
        .company__info{
            display: none;
        }
        .login_form{
            border-top-left-radius:20px;
            border-bottom-left-radius:20px;
        }
    }
    @media screen and (min-width: 642px) and (max-width:800px){
        .main-content{width: 70%;}
    }
    .row > h2{
        color:#0098ef;
        font-family: Arial, sans-serif;
        font-weight: 600;
    }
    .login_form{
        background-color: #fff;
        border-top-right-radius:20px;
        border-bottom-right-radius:20px;
        border-top:1px solid #ccc;
        border-right:1px solid #ccc;
    }
    form{
        padding: 0 2em;
    }
    .form__input{
        width: 100%;
        border:0px solid transparent;
        border-radius: 0;
        border-bottom: 1px solid #aaa;
        padding: 1em .5em .5em;
        padding-left: 2em;
        outline:none;
        margin:1.5em auto;
        transition: all .5s ease;
    }
    .form__input:focus{
        border-bottom-color: #0098ef;
        box-shadow: 0 0 5px rgba(0,80,80,.4);
        border-radius: 4px;
    }
    .btn{
        transition: all .5s ease;
        width: 70%;
        height: 40px;
        border-radius: 30px;
        color:#0098ef;
        font-weight: 600;
        background-color: #fff;
        border: 1px solid #0098ef;
        margin-top: 1.5em;
        margin-bottom: 1em;
        margin-left: 1.5em;

    }
    .btn:hover, .btn:focus{
        background-color:#0098ef;
        color:#fff;
    }
</style>
<body>
<!-- Main Content -->

<div class="container-fluid">
    <div class="row main-content bg-success text-center">
        <div class="col-md-4 text-center company__info" style="width: 30%;">
            <span class="company__logo" ><img style="width: 90%;margin-left:5%; " src="/public4/images/logo_white_large.png"  ></span>
            <link rel="shortcut icon" type="/public4/images/con_only.png" href="/public4/images/con_only.png">
<!--            <h4 class="company_title">Your Company Logo</h4>-->
        </div>
        <div class="col-md-8 col-xs-12 col-sm-12 login_form ">
            <div class="container-fluid">
                <div class="row">
                    <h2 style="text-align: center">Admin Panel</h2>
                </div>
                <?php if ($status == 1) { ?>
                    <div class="alert alert-danger" role="alert">
                        Please check username and password.
                    </div>
                <?php } ?>
                <div class="row">
                    <?php echo form_open(); ?>
                        <div class="row">
                            <input type="text" name="username" id="username" class="form__input" placeholder="Username">
                        </div>
                        <div class="row">
                            <!-- <span class="fa fa-lock"></span> -->
                            <input type="password" name="password" id="password" class="form__input" placeholder="Password">
                        </div>
<!--                        <div class="row">-->
<!--                            <input  style="width: 11px; " type="checkbox" name="remember_me" id="remember_me" class="" >-->
<!--                            <label style="font-family: Arial, sans-serif; font-size: 12px;"for="remember_me">Remember Me</label>-->
<!--                        </div>-->
                        <div class="row ">
<!--                            <div class="justify-content-center">-->
                            <input type="submit" value="Login" class="btn" >
<!--                        </div>-->
                        </div>
                    <?php echo form_close(); ?>
                </div>
<!--                <div class="row">-->
<!--                    <p>Don't have an account? <a href="#">Register Here</a></p>-->
<!--                </div>-->
            </div>
        </div>
    </div>

</div>
<!-- Footer -->
<div class="footer" style="  position: fixed;bottom: 0px; width: 100%;" >
    <p style="color: white"> Developed by <a style="color: white"href="https://cross4solution.com/">cross4solution.com.</a></p>
</div>
</body>


</html>

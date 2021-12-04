</div>
<!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->

<script>

    $(document).ready(function () {
        $(document).ready(myfunction);
        $(window).on('resize', myfunction);
        function myfunction() {
            var windowsh = $(window).height() - 150;
            $("#page-wrapper").css("min-height", windowsh);
        }



        var background = '<?= $theColor[1]->theValue ?>';
        var color = '<?= $theColor[0]->theValue ?>';

        $(".sidebar-nav>ul>li>a.active").css("background-color", "" + color + "");
        $(".sidebar-nav>ul>li>a.active").css("color", "" + background + "");
        $(".mainPage .textMain").css("color", "" + background + "");
        $(".page-header").css("color", "" + background + "");
        $(".btn-success").css("background-color", "" + background + "");
        $(".btn-success").css("border-color", "" + background + "");
        $(".btn-success").css("color", "" + color + "");
        $(".navbar-primary").css("border-color", "" + color + "");
        $(".btn-primary").css("background-color", "" + color + "");
        $(".btn-primary").css("color", "" + background + "");
        $(".btn-primary").css("border-color", "" + background + "");
        $(".userIcon").css("color", "" + background + "");


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
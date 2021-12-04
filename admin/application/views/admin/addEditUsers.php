<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $pageTitle ?></h1>
    </div>
</div>
<div class="row">

    <div class="col-md-4">
        <form action="/admin/ajax/addEditUsers/0" class="form" id="validation" method="post" >
            <input type="hidden" value="<?= $id ?>" name="id" />
            <div class="form-group">
                <label>Username</label>
                <input class="form-control" type="text" id="username" name="username" placeholder="username" />
            </div>       
            <div class="form-group">
                <label>Password</label>
                <input class="form-control" type="password" id="thePassword" name="thePassword" placeholder="Password" />
            </div>
            <div class="form-group">
                <button id="saveBtn" class="btn btn-primary pull-right" type="submit">Save</button>
            </div>
        </form>
    </div>

</div>
<script src="/public/lib/validation/jquery.validate.js"></script>

<script>
    $(".form").each(function () {
        $(this).validate({
            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            ignore: [],
            rules: {
                'username': {required: true},
                'thePassword': {required: true}
            },
            errorPlacement: function (error, element) {
                error.insertAfter(element);
            },
            submitHandler: function (form) {

                data = $(this.currentForm).serialize();
                postURL = $(this.currentForm).attr("action")
                $.post(postURL, data, function (response) {
                    if (response == 1) {
                        $('#username').val('');
                        $('#thePassword').val('');

                        $("#saveBtn").prop('disabled', true);
                        setTimeout(function () {
                            $("#saveBtn").prop('disabled', false);
                        }, 3000);

                        common.showAlert("The job done successfully", "success", 3);
                        window.open("/admin/users/", "_self");
                    } else {
                        common.showAlert("Error <br>" + response, "danger", 0);
                    }
                });
            }
        });
    });

    function fillTheForm(frm, data) {
        $.each(data, function (key, value) {
            var $ctrl = $('[name=' + key + ']', frm);
            switch ($ctrl.attr("type"))
            {
                case "text" :
                case "hidden":
                    $ctrl.val(value)
                    break;
                case "radio" :
                case "checkbox":
                    $ctrl.each(function () {
                        if ($(this).attr('value') == value) {
                            $(this).attr("checked", value);
                        }
                    });
                    break;
                default:
                    if (!$ctrl.length)
                    {
                        var array = $.map(value, function (v, i) {
                            return [v];
                        });
                        if (array.length > $("[name='" + key + "[]']", frm).length)
                        {
                            addCount = array.length - $("[name='" + key + "[]']", frm).length;
                            for (var i = 0; i < addCount; i++) {
                                $("[name='" + key + "[]']", frm).parents(".exercise-type-div").find(".addNew").trigger("click");
                            }
                        }
                        $("[name='" + key + "[]']", frm).each(function (index) {
                            $(this).val(array[index]);
                        });
                    } else {
                        $ctrl.val(value);
                    }
            }
            $ctrl.change();
        });
    }
<?php if ($id && $id != 0) { ?>
        var Vdata =<?= $values ?>;
        fillTheForm($('.form'), Vdata);
<?php } ?>


    $(".nav>li>a.users").addClass("active");

</script>
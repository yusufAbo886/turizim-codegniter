
<div class="card card-custom gutter-b example example-compact">
    <div class="card-header">
        <h3 class="card-title"><?= $pageTitle ?></h3>
        <div class="card-toolbar">
            <div class="example-tools justify-content-center">
                <span class="example-toggle" data-toggle="tooltip" title="View code"></span>
            </div>
        </div>
    </div>
    <!--begin::Form-->
    <form action="/panel/ajax/addEditAboutcard" class="form" id="validation" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <div class="form-group">
                <input  type="hidden" class="form-control form-control-solid" value="<?= $id ?>" name="id" required/>
            </div>


            <div class="form-group">
                <label>The Title:</label>
                <input  class="form-control form-control-solid" id="input2" name="theTitle" placeholder="Enter title" required />
                <span class="form-text text-muted">Please enter your full Title</span>
            </div>
            <div class="form-group">
                <label>The Text:</label>
                <input  class="form-control form-control-solid" id="input2" name="theText" placeholder="Enter text" required />
                <span class="form-text text-muted">Please enter your full text</span>
            </div>

            <div class="form-group">
                <label>the Icone:</label>
                <input  class="form-control form-control-solid" id="input2" name="icon" placeholder="Enter Icon" required />
                <span class="form-text text-muted">Please enter your full alt</span>
            </div>




            <!--begin: Code-->



            <!--end: Code-->
        </div>
        <div class="card-footer">
            <button id="saveBtn" class="btn btn-primary pull-left" type="submit">Submit</button>
        </div>
    </form>
    <!--end::Form-->
</div>


</div>
<script src="/public/lib/validation/jquery.validate.js"></script>
<script src="/public/js/jquery.form.js"></script>

<script>



    $(".form").ajaxForm({
        beforeSubmit: function (arr, $form, options) {
            $activeForm = $form;
            if (!$form.valid())
                return false;
        },
        complete: function (xhr) {
            var response = xhr.responseText;
            if (response == 1) {

                $('.fileinput').fileinput('clear');
                $("#saveBtn").prop('disabled', true);
                $('#input2').val('');
                $('#input4').val('');
                setTimeout(function () {
                    $("#saveBtn").prop('disabled', false);
                }, 3000);

                common.showAlert("The job done successfully", "success", 3);
                window.open("/panel/aboutcard/", "_self");
            } else {
                common.showAlert("Error <br>" + response, "danger", 0);
            }
        }
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

</script>

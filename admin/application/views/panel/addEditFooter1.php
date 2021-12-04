
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
    <form action="/panel/ajax/addEditFooter1" class="form" id="validation" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <div class="form-group">
                <input  type="hidden" class="form-control form-control-solid" value="<?= $id ?>" name="id" required/>
            </div>



                <div class="form-group">
                    <label>the Text:</label>
                    <input id="input4" name="theText"  class="form-control form-control-solid" placeholder="Enter text" required/>
                    <span class="form-text text-muted">you need the text</span>
                </div>



            <!--begin: Code-->

            <div class="form-group">

                <h2 class="titleSelectPhoto"> the photo </h2>
                <div class="col-md-12">
                    <div class="col-md-9" >
                        <input type="text" type="hidden" name="file" id="fieldID" class="form-control"
                            <?php if($thePhoto){ echo "value='".$thePhoto."'"; }else{echo 'value=""';} ?> placeholder="URL" required >
                    </div>
                    <div class="col-md-3">
                        <a  href="javascript:open_popup('/public/lib/responsivefilemanager/filemanager/dialog.php?type=1&popup=1&multiple=0&field_id=fieldID')" class="btn btn-primary" type="button">
                            select photo...(W:800px - H:425px)
                        </a>
                    </div>
                    <?php
                    if ($thePhoto != NULL) { ?>
                        <br><h3 style="margin-top:50px;">current photo</h3>
                        <img width='300px' src="<?= $thePhoto ?>">
                    <?php  }  ?>
                </div>
                <br>
            </div>
            <script type="text/javascript">
                function open_popup(url)
                {
                    var w = 880;
                    var h = 570;
                    var l = Math.floor((screen.width-w)/2);
                    var t = Math.floor((screen.height-h)/2);
                    var win = window.open(url, 'ResponsiveFilemanager', "scrollbars=1,width=" + w + ",height=" + h + ",top=" + t + ",left=" + l);
                }

            </script>

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
                window.open("/panel/footer1/", "_self");
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

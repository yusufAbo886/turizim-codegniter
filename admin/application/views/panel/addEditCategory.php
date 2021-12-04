

            <!--begin::Card-->

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

                                  <form action="/panel/ajax/addEditCategory" class="form" id="validation" method="post" enctype="multipart/form-data">

                                    <div class="card-body">

                                      <div class="form-group">

                                        <input  type="hidden" class="form-control form-control-solid" value="<?= $id ?>" name="id"/>

                                      </div>



                                            <div class="form-group">

                                              <label>category:</label>

                                              <input  class="form-control form-control-solid" id="input2" name="theName" placeholder="Enter category" />

                                              <span class="form-text text-muted">Please enter your full category</span>

                                            </div>

                                            <div class="form-group">

                                              <label>Url:</label>

                                              <input  class="form-control form-control-solid" id="input2" name="url" placeholder="Enter url"  required/>

                                              <span class="form-text text-muted">Please enter your full url</span>

                                            </div>



                                            <div class="card-footer">

                                              <button id="saveBtn" class="btn btn-primary pull-left" type="submit">Submit</button>

                                            </div>

                                          </form>

                                  <!--end::Form-->

                                </div>

                                <!--end::Card-->







<script src="/public/lib/validation/jquery.validate.js"></script>

<script src="/public/js/jquery.form.js"></script>



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

                                'langId': {required: true},



                                <?php if ($id == 0) { ?>

                                        'file': {required: true},

                                <?php } ?>

                            },

                            errorPlacement: function (error, element) {

                                error.insertAfter(element);

                            }

                        });

                    });





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

                                window.open("/panel/category/", "_self");

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


<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $pageTitle ?></h1>
    </div>
</div>
<div class="row">

    <div class="col-md-4">
        <form action="/admin/ajax/editAboutUs" class="form" id="validation" method="post" enctype="multipart/form-data">
            <input type="hidden" value="<?= $id ?>" name="id" />
            <div class="form-group">
                <label>Select Language...</label>
                <select id="langId" name="langId" class="form-control">
                        <option value="">select Language...</option>
                    <?php foreach ($lang as $key => $value) { ?>
                        <option value="<?=$value->laId?>"><?=$value->theName?></option>
                    <?php } ?>
                </select>    
            </div>
            <div class="form-group">
                <label>The Details</label>
                <textarea id="theText" name="theText" class="form-control"></textarea>
            </div>
             <?php if($id ==1){ ?>
            
            <div class="form-group">
                <h3>Page Title</h3>
                <input id="PageTitle" name="PageTitle" class="form-control" placeholder="Page Title"/>
            </div>            
            
            <div class="form-group">
                <h3>Page Description</h3>
                <textarea id="pageDesc" name="pageDesc" class="form-control"> </textarea>
            </div>
            
            <div class="form-group">
                <h3>Page Trace Code</h3>
                <textarea id="traceCode" name="traceCode" class="form-control"> </textarea>
            </div>
           
            <div class="form-group">

                <h3 class="titleSelectPhoto">The photo<br><br><span style="color: #c70600; font-size: 15px;">! يرجى التقيد بقياس الصور للحصول على أفضل نتيجة</span></h3>
                <div class="col-md-12">
                    <div class="row">
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>Select photo...(W:600px - H:1200px)</span>
                            <input id="fileupload" type="file" name="files[]" />
                        </span>

                        <div class="clearfix"><br></div>

                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>

                        <div id="files" class="files">

                        </div>
                        <div class="clearfix"><br></div>

                        <input id="file" type="hidden" name="file" value="" />

                        <?php
                        if ($thePhoto != NULL) {
                            ?>
                            <h2>Current Photo</h2>
                            <img src="/public/uploads/php/files/aboutUs/<?= $thePhoto ?>">
                            <?php
                        }
                        ?>
                    </div>
                </div>

                <script>
                    $(document).ready(function () {
                        $(function () {
                            'use strict';
                            $('#progress').hide();
                            var url = "/public/uploads/php/?pageType=aboutUs";
                            $('#fileupload').fileupload({
                                url: url,
                                dataType: 'json',
                                done: function (e, data) {
                                    $.each(data.result.files, function (index, file) {
                                        //                $("#files").append("<div class='hover'><img src='/public//uploads/php/files/thumbnail/"+file.name+"' /><i data="+file.name+" class='glyphicon glyphicon-remove deleteImage'></i></div>");
                                        $("#files").append("<div class='photoPreview'><img src='/public/uploads/php/files/aboutUs/" + file.name + "' /></div>");

                                        if ($("#file").val() == "")
                                        {
                                            $("#file").val(file.name);
                                        } else {
                                            $("#file").val($("#file").val() + "|" + file.name);
                                        }
                                    });
                                },
                                progressall: function (e, data) {
                                    var progress = parseInt(data.loaded / data.total * 100, 10);
                                    $('#progress .progress-bar').css(
                                            'width',
                                            progress + '%'
                                            ).html(progress + '%');
                                }
                            }).bind('fileuploadstart', function (e) {
                                $('#progress').show();
                            }).bind('fileuploadstop', function (e) {
                                $('#saveBtn').show();
                                $('#progress .progress-bar').html("All files has been uploaded.");
                            });
                        });
                    });

                </script>
            </div>
            <?php } ?>
            
            <div class="form-group">
                <button id="saveBtn" class="btn btn-primary pull-left" type="submit">Save</button>
            </div>
        </form>
    </div>

</div>
<script src="/public/lib/validation/jquery.validate.js"></script>
<script src="/public/js/jquery.form.js"></script>

<script>

                    $(".nav>li>a.aboutUs").addClass("active");                   
                    
                    CKEDITOR.replace("theText", {
                        height: '280px',
                        skin: 'bootstrapck',                        
                        removePlugins: 'elementspath',
                        resize_enabled: false
                    });


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
                                'langId' : {required:true},
                                'theText': {
                                    required: function () {
                                        CKEDITOR.instances.theText.updateElement();
                                    }
                                },

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
                                CKEDITOR.instances.theText.setData('');
                                setTimeout(function () {
                                    $("#saveBtn").prop('disabled', false);
                                }, 3000);

                                common.showAlert("The job done successfully", "success", 3);
                                window.open("/admin/aboutUs/", "_self");
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
                        var Vdata =<?= $values ?>;
                        fillTheForm($('.form'), Vdata);

</script>

<div class="inner-pages">
    <section class="headings" style="background: -webkit-linear-gradient(rgba(32, 51, 100, 0.5), rgba(32, 51, 100, 0.5)), url(/public4/images/bg/bg-details.jpeg) no-repeat center center;
         background: linear-gradient(rgba(32, 51, 100, 0.5), rgba(32, 51, 100, 0.5)), url(/public4/images/bg/bg-details.jpeg) no-repeat center center;">
        <div class="text-heading text-center">
            <div class="container">
                <h1>Send your property</h1>

            </div>
        </div>
    </section>
<!--    <img src="/public4/images/bg/bg-details.jpeg">-->



        <div class="container">






            <style>

            </style>
            <form action="/site/ajax/addEditProdactUser" class="form" id="validation" method="post" enctype="multipart/form-data">
                <div class="row">



                    <div class="single-add-property">
                        <h3>property Media</h3>
                        <div class="col-lg-3 col-md-12" >
                            <div class="form-group">

                                <div class="cc">
                                    <div class="dd" >
                                                  <span class="btn btn-success fileinput-button" >
                                                      <i class="glyphicon glyphicon-plus"></i>
                                                      <span style="">Select photo</span>
                                                      <input id="fileupload" type="file" name="files[]" />
                                                  </span>

                                        <div class="clearfix"><br></div>


                                        <div id="progress" class="progress"  >
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>


                                        <div id="files" class="files">

                                        </div>
                                        <div class="clearfix"><br></div>

                                        <input id="file" type="hidden" name="file" value="" required/>

                                        <?php
                                        if ($thePhoto != NULL) {
                                            ?>
                                            <h4>Current Photo</h4>
                                            <img src="/admin/public1/uploads/php/files/prodact_user/thumbnail/<?= $thePhoto ?>">
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
                                            var url = "/admin/public1/uploads/php/?pageType=prodact_user";
                                            $('#fileupload').fileupload({
                                                url: url,
                                                dataType: 'json',
                                                done: function (e, data) {
                                                    $.each(data.result.files, function (index, file) {
                                                        //                $("#files").append("<div class='hover'><img src='/public//uploads/php/files/thumbnail/"+file.name+"' /><i data="+file.name+" class='glyphicon glyphicon-remove deleteImage'></i></div>");
                                                        $("#files").append("<div class='photoPreview' ><img  style='height:75px'src='/admin/public1/uploads/php/files/prodact_user/thumbnail/" + file.name + "' /></div>");

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
                                                $('#progress .progress-bar').html(" uploaded.");
                                            });
                                        });
                                    });

                                </script>
                            </div >
                        </div>

                        <div class="col-lg-3 col-md-12" >
                            <div class="form-group">

                                <div class="cbb">
<!--                                    <div class="dd"style="width: 50%">-->
                                    <div class="dd">
                       <span class="btn btn-success fileinput-button">
                           <i class="glyphicon glyphicon-plus"></i>
                           <span>Select photo</span>
                           <input id="fileupload2" type="file" name="files[]"/>
                       </span>

                                        <div class="clearfix"><br></div>

                                        <div id="progress2" class="progress">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>

                                        <div id="files2" class="files">

                                        </div>
                                        <div class="clearfix"><br></div>

                                        <input id="file2" type="hidden" name="file1" value="" required />

                                        <?php
                                        if ($thePhoto1 != NULL) {
                                            ?>
                                            <h4>Current Photo2</h4>
                                            <img src="/admin/public1/uploads/php/files/prodact_user1/thumbnail/<?= $thePhoto1 ?>">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        $(function () {
                                            'use strict';
                                            $('#progress2').hide();
                                            var url = "/admin/public1/uploads/php/?pageType=prodact_user1";
                                            $('#fileupload2').fileupload({
                                                url: url,
                                                dataType: 'json',
                                                done: function (e, data) {
                                                    $.each(data.result.files, function (index, file) {
                                                        //                $("#files").append("<div class='hover'><img src='/public//uploads/php/files/thumbnail/"+file.name+"' /><i data="+file.name+" class='glyphicon glyphicon-remove deleteImage'></i></div>");
                                                        $("#files2").append("<div class='photoPreview2'><img style='height:75px;' src='/admin/public1/uploads/php/files/prodact_user1/thumbnail/" + file.name + "' /></div>");

                                                        if ($("#file2").val() == "")
                                                        {
                                                            $("#file2").val(file.name);
                                                        } else {
                                                            $("#file2").val($("#file2").val() + "|" + file.name);
                                                        }
                                                    });
                                                },
                                                progressall: function (e, data) {
                                                    var progress = parseInt(data.loaded / data.total * 100, 10);
                                                    $('#progress2 .progress-bar').css(
                                                        'width',
                                                        progress + '%'
                                                    ).html(progress + '%');
                                                }
                                            }).bind('fileuploadstart', function (e) {
                                                $('#progress2').show();
                                            }).bind('fileuploadstop', function (e) {
                                                $('#saveBtn').show();
                                                $('#progress2 .progress-bar').html(" uploaded.");
                                            });
                                        });
                                    });

                                </script>
                            </div>

                        </div>







                        <div class="col-lg-3 col-md-12">
                            <div class="form-group">

                                <div class="cbb">
                                    <div class="dd">
                       <span class="btn btn-success fileinput-button">
                           <i class="glyphicon glyphicon-plus"></i>
                           <span>Select photo</span>
                           <input id="fileupload4" type="file" name="files[]" />
                       </span>

                                        <div class="clearfix"><br></div>

                                        <div id="progress4" class="progress">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>

                                        <div id="files4" class="files">

                                        </div>
                                        <div class="clearfix"><br></div>

                                        <input id="file4" type="hidden" name="file3" value="" required />

                                        <?php
                                        if ($thePhoto3 != NULL) {
                                            ?>
                                            <h4>Current Photo4</h4>
                                            <img src="/admin/public1/uploads/php/files/prodact_user3/thumbnail/<?= $thePhoto3 ?>">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        $(function () {
                                            'use strict';
                                            $('#progress4').hide();
                                            var url = "/admin/public1/uploads/php/?pageType=prodact_user3";
                                            $('#fileupload4').fileupload({
                                                url: url,
                                                dataType: 'json',
                                                done: function (e, data) {
                                                    $.each(data.result.files, function (index, file) {
                                                        //                $("#files").append("<div class='hover'><img src='/public//uploads/php/files/thumbnail/"+file.name+"' /><i data="+file.name+" class='glyphicon glyphicon-remove deleteImage'></i></div>");
                                                        $("#files4").append("<div class='photoPreview2'><img style='height:75px;' src='/admin/public1/uploads/php/files/prodact_user3/thumbnail/" + file.name + "' /></div>");

                                                        if ($("#file4").val() == "")
                                                        {
                                                            $("#file4").val(file.name);
                                                        } else {
                                                            $("#file4").val($("#file4").val() + "|" + file.name);
                                                        }
                                                    });
                                                },
                                                progressall: function (e, data) {
                                                    var progress = parseInt(data.loaded / data.total * 100, 10);
                                                    $('#progress4 .progress-bar').css(
                                                        'width',
                                                        progress + '%'
                                                    ).html(progress + '%');
                                                }
                                            }).bind('fileuploadstart', function (e) {
                                                $('#progress4').show();
                                            }).bind('fileuploadstop', function (e) {
                                                $('#saveBtn').show();
                                                $('#progress4 .progress-bar').html("uploaded.");
                                            });
                                        });
                                    });

                                </script>
                            </div>
                        </div>

                        <div class="col-lg-3 col-md-12">
                            <div class="form-group">

                                <div class="cbb">
                                    <div class="dd">
                       <span class="btn btn-success fileinput-button">
                           <i class="glyphicon glyphicon-plus"></i>
                           <span>Select photo</span>
                           <input id="fileupload5"   type="file" name="files[]" />
                       </span>

                                        <div class="clearfix"><br></div>

                                        <div id="progress5" class="progress">
                                            <div class="progress-bar progress-bar-success"></div>
                                        </div>

                                        <div id="files5" class="files">

                                        </div>
                                        <div class="clearfix"><br></div>

                                        <input id="file5" type="hidden" name="file4" value="" required/>

                                        <?php
                                        if ($thePhoto4 != NULL) {
                                            ?>
                                            <h4>Current Photo5</h4>
                                            <img src="/admin/public1/uploads/php/files/prodact_user4/thumbnail/<?= $thePhoto4 ?>">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                </div>

                                <script>
                                    $(document).ready(function () {
                                        $(function () {
                                            'use strict';
                                            $('#progress5').hide();
                                            var url = "/admin/public1/uploads/php/?pageType=prodact_user4";
                                            $('#fileupload5').fileupload({
                                                url: url,
                                                dataType: 'json',
                                                done: function (e, data) {
                                                    $.each(data.result.files, function (index, file) {
                                                        //                $("#files").append("<div class='hover'><img src='/public//uploads/php/files/thumbnail/"+file.name+"' /><i data="+file.name+" class='glyphicon glyphicon-remove deleteImage'></i></div>");
                                                        $("#files5").append("<div class='photoPreview2'><img style='height:75px;' src='/admin/public1/uploads/php/files/prodact_user4/thumbnail/" + file.name + "' /></div>");

                                                        if ($("#file5").val() == "")
                                                        {
                                                            $("#file5").val(file.name);
                                                        } else {
                                                            $("#file5").val($("#file5").val() + "|" + file.name);
                                                        }
                                                    });
                                                },
                                                progressall: function (e, data) {
                                                    var progress = parseInt(data.loaded / data.total * 100, 10);
                                                    $('#progress5 .progress-bar').css(
                                                        'width',
                                                        progress + '%'
                                                    ).html(progress + '%');
                                                }
                                            }).bind('fileuploadstart', function (e) {
                                                $('#progress5').show();
                                            }).bind('fileuploadstop', function (e) {
                                                $('#saveBtn').show();
                                                $('#progress5 .progress-bar').html(" uploaded.");
                                            });
                                        });
                                    });

                                </script>
                            </div>
                        </div>


                    </div>
                </div>

                <div class="row" style="margin-bottom: 4rem;">


                    <div class="col-lg-7 col-md-12"style="margin-right: 4rem">
                        <h3 class="mb-4"> Property Detail </h3>
                        <div id="success" class="successform">
                            <p class="alert alert-success font-weight-bold" role="alert">Your message was sent successfully!</p>
                        </div>
                        <div class="row">
                            <div class="col-lg-6 col-md-12">

                                <label for="pet-select">Choose a City:</label>



                                <select id="category_id" name="category_id" class="form-control"  style="height: 40px">

                                    <option  value="">--Please choose an option--</option>

                                    <?php foreach ($cities as  $value){ ?>

                                        <option value="<?=$value->id?>"><?= $value->theName ?></option>



                                    <?php } ?>



                                </select>


                            </div>
                            <div class="col-lg-6 col-md-12">

                                <div class="form-group">
                                    <label>Location:</label>
                                    <input id="locate" style="height: 40px"type="text" class="form-control input-custom input-full" name="theLocation" placeholder="Address">
                                </div>
                            </div>
                        </div>

                        <div class="form-group">

                            <input  type="hidden" class="form-control form-control-solid" value="<?= $id ?>" name="id"/>

                        </div>




                        <div class="row">
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label> Title :</label>
                                    <input  style="height: 40px" type="text" required class="form-control input-custom input-full" name="theTitle" placeholder=" Title">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label>Property Type :</label>
                                    <select id="theType" name="theType" class="form-control"  style="height: 40px">

                                        <option  value="studio">Studio</option>

                                        <option value="apartment">Apartment</option>
                                        <option value="family house">Family house</option>
                                    </select>
                                    <!--                                <input type="text" required class="form-control input-custom input-full" name="theType" placeholder="the Type">-->
                                </div>

                            </div>

                            <div class="col-lg-4 col-md-12">
                                <div class="form-group ">
                                    <label> Room:</label>
                                    <select id="theRoom" name="theRoom" class="form-control"  style="height: 40px">

                                        <option  value="studio">(1+0)</option>

                                        <option value="1+1">(1+1)</option>
                                        <option value="2+1">(2+1)</option>
                                        <option value="3+1">(3+1)</option>
                                        <option value="4+">(4+)</option>
                                    </select>
                                    <!--                                <input type="text" class="form-control input-custom input-full" name="theRoom" placeholder="the Room">-->
                                </div>
                            </div>
                        </div>



                        <div class="row">
                            <div class="col-lg-2 col-md-11">
                                <input style="width: 17px; height: 17px;" type="checkbox" id="parking" name="parking" value="parking">
                                <label for="vehicle1"> Parking</label><br>


                            </div>
                            <div class="col-lg-2 col-md-12">
                                <input style="width: 17px; height: 17px;" type="checkbox" id="balcony" name="balcony" value="balcony">
                                <label style="font-size: 15px"for="vehicle1">Balcony</label><br>


                            </div>
                            <div class="col-lg-2 col-md-12">
                                <input style="width: 17px; height: 17px;" type="checkbox" id="pool" name="pool" value="pool">
                                <label style="font-size: 15px" for="vehicle1"> Pool</label><br>


                            </div>

                            <div class="col-lg-2 col-md-12">
                                <input style="width: 17px; height: 17px;" type="checkbox" id="garden" name="garden" value="garden">
                                <label style="font-size: 15px" for="vehicle1"> Garden</label><br>


                            </div>
                            <div class="col-lg-2 col-md-12">
                                <input style="width: 17px; height: 17px;"  type="checkbox" id="cable" name="cable" value="cable">
                                <label  style="font-size: 15px"  for="vehicle1"> Cable TV</label><br>


                            </div>

                        </div>





                        <div class="row">
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label> Property Owner:</label>
                                    <input style="height: 40px" type="text" class="form-control input-custom input-full" name="theNameHome" placeholder="Name">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-12">
                                <div class="form-group">
                                    <label> Phone :</label>
                                    <input  style="height: 40px" type="text" class="form-control input-custom input-full" name="theBath" placeholder=" +31 6 36 10 44 47">
                                </div>


                            </div>
                            <div class="col-lg-4 col-md-12">

                                <div class="form-group" id="input_container">

                                    <label> Price:</label>
                                    <input style="height: 40px" type="number"id="input" class="form-control input-custom input-full" name="thePrice" placeholder="€ ">

                                </div>
                            </div>

                        </div>
















<!--                        <a style="margin-top: 30px;margin-left: 486px;" class="btn btn-danger btn-lg" href="/add_submit">My Posts</a>-->

                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div class="form-group" >
                            <label>Description :</label>
                            <textarea class="form-control textarea-custom input-full" id="ccomment" name="theText" required rows="10" placeholder="Gelegen in Utrecht ligt deze bijzondere en opvallende woning. Deze woning heeft een woonoppervlakte van 12m2 en is voorzien van 2 kamer(s)."></textarea>
                        </div>

                        <?php  if (isset($this->session->name)){?>
                            <button type="submit" id="saveBtn" class="btn btn-primary btn-lg">Submit</button>

                        <?php }else{?>
                            <button type="submit" id="saveBtn" class="btn btn-primary btn-lg" disabled>Submit</button>

                        <?php }?>
                    </div>

                </div>





            </form>

        </div>

</div>
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
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
                window.open("/add_submit", "_self");
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
<script>


    var searchInput = 'locate';

    $(document).ready(function () {
        var autocomplete;
        autocomplete = new google.maps.places.Autocomplete((document.getElementById(searchInput)), {
            componentRestrictions:{country:["NL"]},
            types: ['geocode'],
        });

        google.maps.event.addListener(autocomplete, 'place_changed', function () {
            var near_place = autocomplete.getPlace();
            document.getElementById('loc_lat').value = near_place.geometry.location.lat();
            document.getElementById('loc_long').value = near_place.geometry.location.lng();

            document.getElementById('latitude_view').innerHTML = near_place.geometry.location.lat();
            document.getElementById('longitude_view').innerHTML = near_place.geometry.location.lng();
        });
    });
</script>


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
    <form action="/panel/ajax/addEditProdactss" class="form" id="validation" method="post" enctype="multipart/form-data">
        <div class="card-body">
            <div class="form-group">
                <input  type="hidden" class="form-control form-control-solid" value="<?= $id ?>" name="id" required/>
            </div>

            <label for="pet-select">Choose a Category:</label>



            <select id="category_id" name="category_id" class="form-control" >

                <option  value="">--Please choose an option--</option>

                <?php foreach ($cities as  $value){ ?>

                    <option value="<?=$value->id?>"><?= $value->theName ?></option>



                <?php } ?>



            </select>



            <div class="form-group">
                <label>The Title:</label>
                <input  class="form-control form-control-solid" id="input2" name="theTitle" placeholder="Enter title"required />
                <span class="form-text text-muted">Please enter your full Title</span>
            </div>
            <div class="form-group">
                <label>The Type:</label>
                <input  class="form-control form-control-solid" id="input2" name="theType" placeholder="Enter title"required />
                <span class="form-text text-muted">Please enter your full Title</span>
            </div>
            <div class="form-group">
                <label>Room:</label>
                <input  class="form-control form-control-solid" id="input2" name="theRoom" placeholder="Enter title"required />
                <span class="form-text text-muted">Please enter your full Title</span>
            </div>
            <div class="form-group">
                <label>Price:</label>
                <input type="number" class="form-control form-control-solid" id="input2" name="thePrice" placeholder="Enter title"required />
                <span class="form-text text-muted">Please enter your full Title</span>
            </div>
            <div class="form-group">
                <label>Property Owner:</label>
                <input  class="form-control form-control-solid" id="input2" name="theNameHome" placeholder="Enter title"required />
                <span class="form-text text-muted">Please enter your full Title</span>
            </div>
            <div class="form-group">
                <label>phone number:</label>
                <input  class="form-control form-control-solid" id="input2" name="theBath" placeholder="Enter title"required />
                <span class="form-text text-muted">Please enter your full Title</span>
            </div>
            <div class="form-group">
                <label>the Location::</label>
                <input  class="form-control form-control-solid" id="input2" name="theLocation" placeholder="Enter title"required />
                <span class="form-text text-muted">Please enter your full Title</span>
            </div>
            <div class="form-group">
                <label>The descrption:</label>
                <textarea id="theText"  rows="7" name="theText" class="form-control" required></textarea>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <input type="checkbox" id="parking" name="parking" value="parking">
                    <label for="vehicle1"> Parking</label><br>


                </div>
                <div class="col-lg-3 col-md-12">
                    <input type="checkbox" id="balcony" name="balcony" value="balcony">
                    <label for="vehicle1">Balcony</label><br>


                </div>
                <div class="col-lg-3 col-md-12">
                    <input type="checkbox" id="pool" name="pool" value="pool">
                    <label for="vehicle1"> Pool</label><br>


                </div>
                <div class="col-lg-3 col-md-12">
                    <input type="checkbox" id="cable" name="cable" value="cable">
                    <label for="vehicle1"> Cable TV</label><br>


                </div>
                <div class="col-lg-3 col-md-12">
                    <input type="checkbox" id="garden" name="garden" value="garden">
                    <label for="vehicle1"> Garden</label><br>


                </div>
                </div>
        <div class="card-footer">
            <button id="saveBtn" class="btn btn-primary pull-left" type="submit">Submit</button>
        </div>
    </form>
    <!--end::Form-->
</div>


</div>
<!--<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>-->
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
                window.open("/panel/prodactUser/", "_self");
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

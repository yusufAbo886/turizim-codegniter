<div class="row">
    <div class="col-lg-12">
        <h1 class="textMain"><?= $pageTitle ?></h1>
    </div>
</div>
<div class="row">

    <div class="col-md-4">
        <form action="/admin/ajax/addEditContactUs" class="form" id="validation" method="post" enctype="multipart/form-data">
            <input type="hidden" value="<?= $id ?>" name="id" />

            <div class="form-group">
                <h3>Company Name</h3>
                <input id="companyName" name="companyName" class="form-control" placeholder="Company Name"/>
            </div>
            
            <div class="form-group">
                <h3>Email Address</h3>
                <input id="emailAddress" name="emailAddress" class="form-control" placeholder="E-mail"/>
            </div>
            <div class="form-group">
                <h3>Email Address 2</h3>
                <input id="emailAddress2" name="emailAddress2" class="form-control" placeholder="E-mail 2"/>
            </div>
            
            <div class="form-group">
                <h3>Phone Number</h3>
                <input id="phoneNumber" name="phoneNumber" class="form-control" placeholder="Phone Number"/>
            </div>
            <div class="form-group">
                <h3>Phone Number 2</h3>
                <input id="phoneNumber2" name="phoneNumber2" class="form-control" placeholder="Phone Number 2"/>
            </div>
            <div class="form-group">
                <h3>Phone Number 3</h3>
                <input id="phoneNumber3" name="phoneNumber3" class="form-control" placeholder="Phone Number 3"/>
            </div>
            <div class="form-group">
                <h3>Phone Number 4</h3>
                <input id="phoneNumber4" name="phoneNumber4" class="form-control" placeholder="Phone Number 4"/>
            </div>

            <div class="form-group">
                <h3>English Details</h3>
                <textarea id="enDetails" name="enDetails" class="form-control"></textarea>
            </div>
            
            <div class="form-group">
                <h3>Arabic Details</h3>
                <textarea id="arDetails" name="arDetails" class="form-control"></textarea>
            </div>
            
            <div class="form-group">
                <h3>English Page Title</h3>
                <input id="enPageTitle" name="enPageTitle" class="form-control" placeholder="English Page Title"/>
            </div>
            
            <div class="form-group">
                <h3>Arabic Page Title</h3>
                <input id="arPageTitle" name="arPageTitle" class="form-control" placeholder="Arabic Page Title"/>
            </div>
            
            <div class="form-group">
                <h3>Page Description</h3>
                <textarea id="pageDesc" name="pageDesc" class="form-control"> </textarea>
            </div>
            
            <div class="form-group">
                <h3>Page Trace Code</h3>
                <textarea id="traceCode" name="traceCode" class="form-control"> </textarea>
            </div>

               
            <script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.4.8/angular.min.js"></script>
            <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCekozEl1Pc8BleRyxno73x5els2MymTEc"></script>
        <script src="/public/js/locationpicker.jquery.js" type="text/javascript"></script>
        <script src="/public/js/angularLocationpicker.jquery.js" type="text/javascript"></script>
        
         <br>
            <div class="form-horizontal" style="width: 550px" ng-app="locationpickerApp" ng-controller="locationpickerController">
                <!--Map by element. Also it can be attribute-->
                <locationpicker options="locationpickerOptions"></locationpicker>
            </div>



            <div class="form-group">
                <label>The latitude</label>
                <input id="latitude" name="latitude" class="form-control"/>
            </div>

            <div class="form-group">
                <label>The longitude</label>
                <input id="longitude" name="longitude" class="form-control"/>
            </div>

                <script>
                    angular.module('locationpickerApp', ['angular-jquery-locationpicker'])
                            .controller('locationpickerController', [
                                '$scope',
                                function ($scope) {
                                    $scope.locationpickerOptions = {
                                        location: {
                                            latitude: <?php if($latitude){echo $latitude;}else{echo '41.04491727001667';}?>,
                                            longitude: <?php if($longitude){echo $longitude;}else{echo '28.9825439453125';}?>
                                        },
                                        inputBinding: {
                                            latitudeInput: $('#latitude'),
                                            longitudeInput: $('#longitude')
                                        },
                                        radius: 100
//                                        enableAutocomplete: true
                                    };
                                }
                            ]);
                </script>

                


            <div class="form-group">
                <button id="saveBtn" class="btn btn-primary pull-left" type="submit">Save</button>
            </div>
        </form>
    </div>

</div>
<script src="/public/lib/validation/jquery.validate.js"></script>
<script src="/public/js/jquery.form.js"></script>

<script>

      $(".nav>li>a.contactUs").addClass("active");

      CKEDITOR.replace("enDetails", {
          height: '280px',
          skin: 'bootstrapck',
          removePlugins: 'elementspath',
          resize_enabled: false
      });

      CKEDITOR.replace("arDetails", {
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
                  'companyName' : {required: true},
                  'emailAddress': {required: true, email: true},
                  'phoneNumber': {required: true},
                  'enDetails': {
                      required: function () {
                          CKEDITOR.instances.enDetails.updateElement();
                      }
                  },
                  'arDetails': {
                      required: function () {
                          CKEDITOR.instances.arDetails.updateElement();
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
                  $("#companyName").val('');
                  $('#emailAddress').val('');
                  $('#emailAddress2').val('');
                  $('#phoneNumber').val('');
                  $('#phoneNumber2').val('');
                  CKEDITOR.instances.enDetails.setData('');
                  CKEDITOR.instances.arDetails.setData('');
              setTimeout(function () {
                      $("#saveBtn").prop('disabled', false);
                  }, 3000);

                  common.showAlert("The job done successfully", "success", 3);
                  window.open("/admin/contactUs/", "_self");
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

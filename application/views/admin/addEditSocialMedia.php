<div class="row">
    <div class="col-lg-12">
        <h1 class="textMain"><?= $pageTitle ?></h1>
    </div>
</div>
<div class="row">

    <div class="col-md-4">
        <form action="/admin/ajax/addEditSocialMedia" class="form" id="validation" method="post" enctype="multipart/form-data">
            <input type="hidden" value="<?= $id ?>" name="id" />

            <div class="form-group">
                <h3>Facebook </h3>
                <input id="facebook" name="facebook" class="form-control" placeholder="Facebook"/>
            </div>
            
            <div class="form-group">
                <h3>Instagram</h3>
                <input id="instagram" name="instagram" class="form-control" placeholder="Instagram"/>
            </div>
            
            <div class="form-group">
                <h3>Twitter</h3>
                <input id="twitter" name="twitter" class="form-control" placeholder="Twitter"/>
            </div>
            
            <div class="form-group">
                <h3>Linkedin</h3>
                <input id="snapchat" name="snapchat" class="form-control" placeholder="Linkedin"/>
            </div>
            
<!--            <div class="form-group">
                <h3>Viber</h3>
                <input id="messanger" name="messanger" class="form-control" placeholder="Viber"/>
            </div>
-->            
            <div class="form-group">
                <h3>Whatsapp AR</h3>
                <textarea id="whatsapp" name="whatsapp" class="form-control"></textarea>
            </div>
            
            <div class="form-group">
                <h3>Whatsapp EN</h3>
                <textarea id="whatsapp2" name="whatsapp2" class="form-control"></textarea>
            </div>           
            
            <div class="form-group">
                <button id="saveBtn" class="btn btn-primary pull-left" type="submit">Save</button>
            </div>
        </form>
    </div>

</div>
<script src="/public/lib/validation/jquery.validate.js"></script>
<script src="/public/js/jquery.form.js"></script>

<script>

      $(".nav>li>a.socialMedia").addClass("active");
      
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
                  $('#facebook').val('');
                  $('#instagram').val('');
                  $('#twitter').val('');
                  $('#snapchat').val('');
              setTimeout(function () {
                      $("#saveBtn").prop('disabled', false);
                  }, 3000);

                  common.showAlert("The job done successfully", "success", 3);
                  window.open("/admin/socialMedia/", "_self");
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

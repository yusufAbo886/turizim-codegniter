





<!--Data table-->
<script src="/public/lib/dataTable/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/public/lib/dataTable/js/dataTable.bootstrap.min.js" type="text/javascript"></script>
<link href="/public/lib/dataTable/js/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>

<div class="inner-pages">
    <section class="headings" style="background: -webkit-linear-gradient(rgba(32, 51, 100, 0.5), rgba(32, 51, 100, 0.5)), url(../public4/images/bg/bg-details.jpeg) no-repeat center center;
         background: linear-gradient(rgba(32, 51, 100, 0.5), rgba(32, 51, 100, 0.5)), url(../public4/images/bg/bg-details.jpeg) no-repeat center center;">
        <div class="text-heading text-center">
            <div class="container">
                <h1>Send your property</h1>

            </div>
        </div>
    </section>

</div>
<br>
<br>
<br>
<div class="container">
    <div class="card card-custom">

        <div class="card-body theDataTable">

            <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">
                <thead class="cf">

                <tr>
                    <th>Title</th>
                    <th>city</th>
                    <th>situation</th>

                    <th style="width:16%;">Actions</th>
                </tr>
                </thead>
                <tbody>





                </tbody>
            </table>

        </div>
    </div>

</div>
<br>
<br>
<!--end::Card-->
<script src="/public4/js/jquery.form.js"></script>
<!-- <script src="/public2/assets/plugins/global/plugins.bundle.js"></script> -->
<!-- <script src="/public2/assets/plugins/custom/datatables/datatables.bundle.js"></script> -->


<script>




    $(document).ready(function () {
      function modalConfirm($elm, mTitle, mCancelLabel, mOkLabel, postCallback) {
          name = $elm.data("name");
          href = $elm.data("href");
          bootbox.dialog({


              buttons: {
                  cancel: {
                      label: mCancelLabel,
                      className: "btn-success",
                      callback: function () {
                      }
                  },
                  ok: {
                      label: mOkLabel,
                      className: "btn-danger",
                      callback: function () {
                          $.post(href, function () {
                              postCallback();
                          });
                      }
                  }
              }
          });
      }

        var theVal = 0;

        $(".langId").on("change", function(){
            theVal =  $('.langId').val();
            dtBuilder();
        });



        var dTableVar;
        function dtBuilder() {
            var options = {
                ajaxUrl: "/site/ajax/getProdactUser",
                innerFunc: function () {
                    $(".deleteButton").click(function () {

                        modalConfirm($(this),  mTitle, mCancelLabel, mOkLabel, function () {
                            $(".paginate_button.active").trigger("click");
                            dtBuilder();
                        });
                    });
                }
            };
            var dtOpt = {
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": options.ajaxUrl,
                "sPaginationType": "full_numbers",
                //"aaSorting": [],
                "bSort": false,
                //"sDom": '',
                //"lengthMenu": [[100, -1], [100, "All"]],
                "fnDrawCallback": function () {
                    if (options.innerFunc)
                        options.innerFunc.call();
                },
                "fnServerData": function (sSource, aoData, fnCallback, oSettings) {
                    aoData.push( { "name": "langId", "value":theVal } );
                    oSettings.jqXHR = $.ajax({
                        "dataType": 'json',
                        "type": "POST",
                        "url": sSource,
                        "data": aoData,
                        "success": fnCallback
                    });
                }
            };
            if (dTableVar)
                dTableVar.fnDestroy();

            dTableVar = $("#kt_datatable").dataTable(dtOpt);
            $("#searchTable").keyup(function () {
                var val = $(this).val();
                dTableVar.fnFilter(val);
            });
        }

        dtBuilder();
        $(".dtFilters select, .dtFilters input").change(function () {
            dtBuilder();
        });


    });

</script>

<!--Data table-->

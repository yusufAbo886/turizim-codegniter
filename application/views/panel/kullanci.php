

<!--Data table-->

<script src="/public/lib/dataTable/js/jquery.dataTables.min.js" type="text/javascript"></script>

<script src="/public/lib/dataTable/js/dataTable.bootstrap.min.js" type="text/javascript"></script>

<link href="/public/lib/dataTable/js/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>







<div class="card card-custom">

    <div class="card-header">

        <div class="card-title">

                    <span class="card-icon">

                      <i class="flaticon2-heart-rate-monitor text-primary"></i>

                    </span>

            <h3 class="card-label">Users</h3>

        </div>







    </div>

    <div class="card-body theDataTable">

        <!--begin: Datatable-->

        <table class="table table-bordered table-hover table-checkable" id="kt_datatable" style="margin-top: 13px !important">

            <thead class="cf">



            <tr>

                <th>name</th>
                <th>Email</th>


            </tr>

            </thead>

            <tbody>











            </tbody>

        </table>

        <!--end: Datatable-->

    </div>

</div>

<!--end::Card-->





<script>



    $(document).ready(function () {

        var theVal = 0;



        $(".langId").on("change", function(){

            theVal =  $('.langId').val();

            dtBuilder();

        });



        // $(".nav>li>a.cards").addClass("active");



        var dTableVar;

        function dtBuilder() {

            var options = {

                ajaxUrl: "/panel/ajax/getKullanci",

                innerFunc: function () {

                    $(".deleteButton").click(function () {

                        mText = "Are you sure you want to delete this slider!! ?";

                        mTitle = "Delete";

                        mCancelLabel = "Cancel";

                        mOkLabel = "Delete";



                    });

                }

            };

            var dtOpt = {

                "bProcessing": true,

                "bServerSide": true,

                "sAjaxSource": options.ajaxUrl,

                "sPaginationType": "full_numbers",



                "bSort": false,



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


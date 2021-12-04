<script src="/public/lib/dataTable/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/public/lib/dataTable/js/dataTable.bootstrap.min.js" type="text/javascript"></script>
<link href="/public/lib/dataTable/js/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>

<section class="mainPage">
    <h1 class="textMain">
        Medical Tourism :
    </h1>

    <div class="addingBar addBtn">
        <div class="btn-group" role="group" aria-label="...">
            <a href="/admin/add_edit_plans3/" class="btn btn-primary right">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Add New Sub
            </a>
        </div>
    </div>

    <div class="detailsCont">

        <div class="col-md-12 theDataTable">
            <div class="row">
                <div id="no-more-tables">

                    <table id="dataTable" class="col-md-12 table-bordered table-striped table-condensed cf">
                        <thead class="cf">
                            <tr>
<!--                                <th style="width:5%">The Code</th>-->
                                <th style="width:12%">The Photo</th>
                                <th style="width:12%">The Language</th>
                                <th style="width:22%">The Title</th>
                                <th style="width:30%">The Text</th>
<!--                                <th style="width:8%">Course Event</th>-->
<!--                                <th style="width:5%">On HomePage</th>-->
                                <th style="width:5%;">Action</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>


<script>

    $(document).ready(function () {

        $(".nav>li>a.medicalCategories").addClass("active");
        var theVal = 0;
        $(".langId").on("change", function () {
            theVal = $('.langId').val();
            dtBuilder();
        });
        var dTableVar;
        function dtBuilder() {
            var options = {
                ajaxUrl: "/admin/ajax/getPlans3/",
                innerFunc: function () {
                    $(".deleteButton").click(function () {
                        mText = "Are you sure you want to delete this plan!! ?";
                        mTitle = "Delete";
                        mCancelLabel = "Cancel";
                        mOkLabel = "Delete";
                        modalConfirm($(this), mText, mTitle, mCancelLabel, mOkLabel, function () {
                            $(".paginate_button.active").trigger("click");
                            dtBuilder();
                        });
                    });
                    
                     $(".publishButton").click(function () {
                        mText = "Are you sure you want to Activr this Plan On Home Page !! ?";
                        mTitle = "Active This Plan";
                        mCancelLabel = "Cancel";
                        mOkLabel = "Yes";
                        modalConfirm($(this), mText, mTitle, mCancelLabel, mOkLabel, function () {
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
                    aoData.push({"name": "langId", "value": theVal});
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

            dTableVar = $("#dataTable").dataTable(dtOpt);
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

<script src="/public/lib/dataTable/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/public/lib/dataTable/js/dataTable.bootstrap.min.js" type="text/javascript"></script>
<link href="/public/lib/dataTable/js/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>

<section class="mainPage">
    <h1 class="textMain">
      Contact Us Form
    </h1>


    <div class="detailsCont">

        <div class="col-md-12 theDataTable">
            <div class="row">
                <div id="no-more-tables">

                    <table id="dataTable" class="col-md-12 table-bordered table-striped table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th>The Name</th>
                                <th>Entity</th>
                                <th>Job Position</th>
                                <th>Phone Number</th>
                                <th>Email Address</th>
                                <th>Department</th>
                                <th>Courses Name</th>
                                <th>Course Country</th>
                                <th>Course Date</th>
                                <th style="width: 20%">The Message</th>
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

       $(".nav>li>a.courseForm").addClass("active");

        var dTableVar;
        function dtBuilder() {
            var options = {
                ajaxUrl: "/admin/ajax/getCourseForm",
                innerFunc: function () {
                    $(".deleteButton").click(function () {
                        mText = "Are you sure you want to delete this !! ?";
                        mTitle = "Delete";
                        mCancelLabel = "Cancel";
                        mOkLabel = "Delete";
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

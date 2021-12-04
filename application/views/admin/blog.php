<script src="/public/lib/dataTable/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/public/lib/dataTable/js/dataTable.bootstrap.min.js" type="text/javascript"></script>
<link href="/public/lib/dataTable/js/dataTables.bootstrap.css" rel="stylesheet" type="text/css"/>

<section class="mainPage">
    <h1 class="textMain">
      Blog
    </h1>

    <div class="addingBar addBtn">
        <div class="btn-group" role="group" aria-label="...">
            <a href="/admin/add_edit_blog/" class="btn btn-primary right">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Add
            </a>
        </div>
    </div>
            <div class="form-group col-md-3">
                <select id="langId" name="langId" class="langId form-control">
                        <option value="">select Language...</option>
                    <?php foreach ($lang as $key => $value) { ?>
                        <option value="<?=$value->laId?>"><?=$value->theName?></option>
                    <?php } ?>
                </select>    
            </div>
    <div class="detailsCont">

        <div class="col-md-12 theDataTable">
            <div class="row">
                <div id="no-more-tables">

                    <table id="dataTable" class="col-md-12 table-bordered table-striped table-condensed cf">
                        <thead class="cf">
                            <tr>
                                <th>The Photo</th>
                                <th style="width:12%">the Language</th>
                                <th>the Title</th>
                                <th>The Text</th>
                                <th>Date Time</th>
                                <th>Action</th>
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

       $(".nav>li>a.blog").addClass("active");
        var theVal = 0;
        
        $(".langId").on("change", function(){
            theVal =  $('.langId').val();
           dtBuilder();
        });
        var dTableVar;
        function dtBuilder() {
            var options = {
                ajaxUrl: "/admin/ajax/getBlog",
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

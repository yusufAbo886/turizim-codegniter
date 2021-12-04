<!-- </div>  -->

</div>



</div>

<!--end::Entry-->

<div id="kt_quick_user" class="offcanvas offcanvas-right p-10">

    <!--begin::Header-->

    <div class="offcanvas-header d-flex align-items-center justify-content-between pb-5">

        <h3 class="font-weight-bold m-0">User Profile

            <small class="text-muted font-size-sm ml-2">12 messages</small></h3>

        <a href="#" class="btn btn-xs btn-icon btn-light btn-hover-primary" id="kt_quick_user_close">

            <i class="ki ki-close icon-xs text-muted"></i>

        </a>

    </div>





    <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>



    <script src="/public2/assets/plugins/global/plugins.bundle.js"></script>

    <!--begin::Page Scripts(used by this page)-->
    <!--    <script src="/public2/assets/js/pages/widgets.js"></script>-->
    <script src="/public2/assets/plugins/custom/fullcalendar/fullcalendar.bundle.js"></script>
    <!--end::Page Scripts-->


    <script src="/public2/assets/plugins/custom/prismjs/prismjs.bundle.js"></script>

    <script src="/public2/assets/js/scripts.bundle.js"></script>

    <script src="/public2/assets/plugins/custom/datatables/datatables.bundle.js"></script>



    <script src="/public/lib/bootstrap/js/bootstrap.min.js"></script>

    <script src="/public/js/admin/jasny-bootstrap.min.js"></script>

    <script src="/public/js/admin/bootbox.min.js"></script>



    <script src="/public/uploads/vendor/jquery.ui.widget.js"></script>

    <script src="/public/uploads/jquery.iframe-transport.js"></script>

    <script src="/public/uploads/jquery.fileupload.js"></script>

    <script src="/public/lib/validation/jquery.validate.js"></script>

    <!--        <script src="/public/lib/ckeditor/ckeditor.js" type="text/javascript"></script>-->
    <!--begin::Page Vendors(used by this page)-->


    <!--end::Page Scripts-->

    <script src="/public/js/common.js"></script>
    <!--       <script src="/public/ckeditor.js"></script>-->

    <script src="/public/lib/datePicker/js/bootstrap-datepicker.min.js" type="text/javascript"></script>

    <script src="/public/lib/datePicker/moment.js" type="text/javascript"></script>

    <script src="/public/lib/datePicker/daterangepicker.js" type="text/javascript"></script>










    <script>




        function deleteBTN(id, url) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won t be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Yes, delete it!"

            }).then(function (result) {
                if(result.isConfirmed == true){
                    $.post("/panel/ajax/"+url, { id : id }, function( result ) {

                        if (result == 1) {
                            Swal.fire(
                                "Deleted!",
                                "Your file has been deleted.",
                                "success"
                            )
                            location.reload();
                        }
                      
                    });
                }
            });
        }















    </script>



    </body>

    <!--end::Body-->

    </html>


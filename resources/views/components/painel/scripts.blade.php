<script src="{{ asset('js/scripts.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/datatables.net@1.10.24/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/datatables.net-responsive-bs4@2.2.7/js/responsive.bootstrap4.min.js"></script>
<link rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/datatables.net-responsive-bs4@2.2.7/css/responsive.bootstrap4.min.css">
<script>$.fn.dataTable.ext.errMode = 'none';</script>

<!-- Bootstrap core JavaScript-->
<script src="{{ asset('/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{ asset('/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{ asset('/js/sb-admin-2.min.js')}}"></script>

<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js"></script>

<!-- SelectPicker -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<!-- Latest compiled and minified JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>
<!-- (Optional) Latest compiled and minified JavaScript translation files -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/i18n/defaults-*.min.js"></script>

<!-- SWEET ALERT-->
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="sweetalert2.all.min.js"></script>
<script>
    $(document).ready(function () {
        $('.selectpicker').selectpicker('setStyle', 'bg-white border', 'add');
        $('#accordionSidebar a').on('click', function (e) {
            console.log(e.currentTarget.id);
            $(this).tab('show')
        })
    });
</script>

<script>

    function changeLogo() {
        var x = document.getElementById("myLogo");
        if (x.style.display == "none") {
            x.style.display = "block";
        }
    }


</script>
<!-- Your application script -->
<script>
    const LOADER_ID = "page_loader";

    function displayLoader() {
        $("body").append(`
                <div id="${LOADER_ID}" style="display: none">
                    <div class="spinner-border text-light" style="position: fixed; top: 50%; right: 50%;" role="status">
                        <span class="sr-only">Carregando...</span>
                    </div>
                </div>
            `);
        $(`#${LOADER_ID}`).fadeIn();
    }

    function destroyLoader() {
        $(`#${LOADER_ID}`).remove();
    }

    window.onbeforeunload = function () {
        displayLoader();
    }
</script>

@yield('scripts')

</html>

<footer class="main-footer">
    <strong>Copyright &copy; 2017- {{ date("Y") }} <a href="https://greefitech.com" target="_blank" style="text-decoration:none">Greefi Technologies Tiruchengode</a>.</strong> All rights reserved.
</footer>
</div>
<script src="{{ asset('/assets/js/app.min.js') }}"></script>
<script src="{{ asset('/assets/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/jszip.min.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/date-dd-MMM-yyyy.js') }}"></script>
<script src="{{ asset('/assets/js/datatable/jquery-ui.js') }}"></script>
<script src="{{ asset('/assets/js/validation.js') }}"></script>

<script src="{{ asset('/assets/js/select2.min.js') }}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js" type="text/javascript"></script>

<script src="{{ asset('/js/entry.js') }}"></script>
<script src="{{ asset('/js/expense.js') }}"></script>
<script src="{{ asset('/js/income.js') }}"></script>
<script src="//unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script src="https://adminlte.io/themes/AdminLTE/bower_components/PACE/pace.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/searchbuilder/1.0.0/js/dataTables.searchBuilder.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/rowgroup/1.1.2/js/dataTables.rowGroup.min.js"></script>

<script>
	$(document).ajaxStart(function() { Pace.restart(); });
    $(document).ready( function () {
        $('.DataTable').DataTable({
            "aaSorting": [],
            select: true,
            dom: 'Qfrtip',
            responsive: true
        });
        $('.select2').select2();

        //Menu Filter on navbar
	    $(".menuFilter").keyup(function () {
	        var filter = $(this).val(),
	            count = 0;
	        $("li").each(function () {
	            if (filter == "") {
	                $(this).css("visibility", "visible");
	                $(this).fadeIn();
	            } else if ($(this).text().search(new RegExp(filter, "i")) < 0) {
	                $(this).css("visibility", "hidden");
	                $(this).fadeOut();
	            } else {
	                $(this).css("visibility", "visible");
	                $(this).fadeIn();
	            }
	        });
	    });
	});
</script>
@yield('script')
<footer class="main-footer">
    <strong>Copyright &copy; 2017- <?php echo date("Y"); ?> <a href="https://greefitech.com" target="_blank">Greefi Technologies Tiruchengode</a>.</strong> All rights reserved.
</footer>
</div>
<script src="{{ url('/assets/js/app.min.js') }}"></script>
<script src="{{ url('/assets/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ url('/assets/js/datatable/jquery.dataTables.min.js') }}"></script>
<script src="{{ url('/assets/js/datatable/dataTables.responsive.min.js') }}"></script>
<script src="{{ url('/assets/js/datatable/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ url('/assets/js/datatable/dataTables.buttons.min.js') }}"></script>
<script src="{{ url('/assets/js/datatable/jszip.min.js') }}"></script>
<script src="{{ url('/assets/js/datatable/pdfmake.min.js') }}"></script>
<script src="{{ url('/assets/js/datatable/vfs_fonts.js') }}"></script>
<script src="{{ url('/assets/js/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ url('/assets/js/datatable/buttons.print.min.js') }}"></script>
<script src="{{ url('/assets/js/datatable/date-dd-MMM-yyyy.js') }}"></script>
<script src="{{ url('/assets/js/datatable/jquery-ui.js') }}"></script>
<script src="{{ url('/assets/js/validation.js') }}"></script>

<script src="{{ asset('/assets/js/select2.min.js') }}"></script>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js" type="text/javascript"></script>

<script src="{{ url('/js/entry.js') }}"></script>
<script src="{{ url('/js/expense.js') }}"></script>
<script src="{{ url('/js/income.js') }}"></script>

<script>
    $(document).ready( function () {
        $('.DataTable').DataTable({
            "aaSorting": []
        });
        $('.select2').select2();
    });
</script>

@yield('script')
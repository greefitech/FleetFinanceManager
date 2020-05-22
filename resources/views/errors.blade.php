<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.css">
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
    toastr.options.closeButton = true;
</script>
@if(count($errors))
   {{--  <div class="form-group">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4><i class="icon fa fa-ban"></i>Alert!</h4>
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    </div> --}}

    @foreach($errors->all() as $error)
          <script>
            toastr.error('{{ $error }}');
        </script>
    @endforeach
        
@endif

@if(Session::has('success'))
    <script>
        toastr.success('{{ Session::get('success')[1] }}', '{{ Session::get('success')[0] }}');
    </script>
@endif

@if(Session::has('danger'))
    <script>
        toastr.error('{{ Session::get('danger') }}!');
    </script>
@endif

@if(Session::has('sorry'))
    <script>
        toastr.warning('{{ Session::get('sorry') }}!');
    </script>
@endif


@if(count($errors))
    <div class="form-group">
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <h4><i class="icon fa fa-ban"></i>Alert!</h4>
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
        </div>
    </div>
@endif

@if(Session::has('success'))

    <div class="alert alert-success alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-check"></i> {{ Session::get('success')[0] }}</h4>
            {{ Session::get('success')[1] }}
    </div>
@endif

@if(Session::has('danger'))
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert">×</button>
        {{ Session::get('danger') }}
    </div>
@endif

@if(Session::has('sorry'))
    <div class="alert alert-warning alert-dismissible">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        <h4><i class="icon fa fa-warning"></i> Sorry !</h4>
        {{ Session::get('sorry') }}
    </div>
@endif
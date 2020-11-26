@section('BreadCrumb')
<h4>{{ @$MenuTitle }}</h4>
<ol class="breadcrumb">
    <li><a href="{{ url('client/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
    @stack('BreadCrumbMenu')
</ol>
@endsection

<div class="box box-{{ @$Color?$Color:env('TABPANELCOLOR') }}">
    @if(@$Title || @$Button)
        <div class="box-header with-border">
            <h4 class="box-title">{{ @$Title }}</h4>
            <div class="box-tools pull-right">
               {{ @$Button }}
            </div>
        </div>
    @endif
    <div class="box-body">
        {{ $slot }}
    </div>
</div>

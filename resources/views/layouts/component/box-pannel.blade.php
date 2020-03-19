@section('BreadCrumb')
    <section class="content-header">
        <h4>{{ @$Title }} <small>{{ @$Description }}</small></h4>
        <ol class="breadcrumb">
	        <li><a href="{{ url('/home') }}"><i class="fa fa-dashboard"></i> Home</a></li>
	        <li class="active">{{ @$Title }}</li>

        </ol>
    </section>
@endsection

<div class="box box-{{ @$Color?$Color:env('TABPANELCOLOR') }}">
    @if(@$MenuTitle || @$Button)
        <div class="box-header with-border">
            <h4 class="box-title">{{ @$MenuTitle }}</h4>
            <div class="box-tools pull-right">
               {{ @$Button }}
            </div>
        </div>
    @endif
    <div class="box-body">
        {{ $slot }}
    </div>
</div>


{{--  @foreach($title as $titles)
                <li {{ $loop->last?'class=active':'' }}><a href="1">{{ $titles }}</a></li>
            @endforeach --}}

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

<div class="box box-{{ @$Color?$Color:env('TABPANELCOLORPANNEL') }}">
     @if(@$MenuTitle)
        <div class="box-header with-border">
            <h4 class="box-title">{{ @$MenuTitle }}</h4>
        </div>
    @endif
    <div class="box-header">
        <h4>
            {{ @$Button }}
        </h4>
    </div>
    <div class="box-body">
        {{ $slot }}
    </div>
</div>
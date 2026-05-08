@php
    $color ??= null;
@endphp
<div class="title-wrapper row g-3">
    <div class="col-md-12 text-center">
        <h3 class="title text-center {{isset($white) ? 'text-white' : ''}}">{!! $title !!}</h3>
    </div>
    @if (!empty($subtitle ?? ""))
        <div class="col-md-12">
            <div class="subtitle fs-5 fw-bold {{isset($white) ? 'text-white' : ''}}">
                {!! $subtitle !!}
            </div>
        </div>
    @endif
</div>
@php
    $color ??= null;
@endphp
<div class="title-wrapper row g-3"
    @isset($color)
        style="color: {{ $color }};"
    @endisset
>
    <div class="col-md-12 text-center">
        <h3 class="title text-center">{!! $title !!}</h3>
    </div>
    @if (!empty($subtitle ?? ""))
        <div class="col-md-12">
            <div class="subtitle fs-5 fw-bold">
                {!! $subtitle !!}
            </div>
        </div>
    @endif
</div>
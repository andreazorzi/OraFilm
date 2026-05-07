@php
    $color = $color ?? "#acacac";
    
    if(isset($randomcolor)){
        $color = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
    }
@endphp
{{-- <div class="col-md-4 mb-4">
    <a href="{{route($route ?? "backoffice.index")}}" class="no-link">
        <div class="bookmark text-center rounded" style="background-color: #f8f8f8; --bookmark-color: {{$color}}">
            <div class="bookmark-head p-2 rounded-top" style="background-color: color-mix(in srgb, var(--bookmark-color), transparent 66%); border: 2.5px solid var(--bookmark-color);">
                {{$title ?? ""}}
            </div>
            <div class="bookmark-body p-4 rounded-bottom border-top-0" style="border: 2.5px solid var(--bookmark-color);">
                <i class="{{$icon ?? ""}} fs-1"></i>
            </div>
        </div>
    </a>
</div> --}}
<div class="col-md-3">
    <a href="{{route($route ?? "backoffice.index")}}" class="no-link">
        <div class="bookmark card shadow rounded-4 border border-2" style="--bookmark-color: {{$color}};">
            <div class="card-body text-center">
                <div class="icon mx-auto rounded-4">
                    <div class="ratio ratio-1x1"></div>
                    <i class="{{$icon ?? ""}} position-absolute top-50 start-50 translate-middle fs-3"></i>
                </div>
                <div class="title mt-3 mb-0">{{$title ?? ""}}</div>
            </div>
        </div>
    </a>
</div>
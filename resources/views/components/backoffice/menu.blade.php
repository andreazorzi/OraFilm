@php
    $routes = RouteController::menu_routes();
    $current_group = null;
@endphp
<div class="menu offcanvas offcanvas-start p-3" data-bs-scroll="true" tabindex="-1" id="menu" aria-labelledby="menuLabel" style="--bs-offcanvas-width: 320px;">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="menuLabel">Menu</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pt-0">
        <hr class="mt-0">
        <div class="row g-2">
            @foreach ($routes as $route)
                @if($route["group"] != $current_group)
                    @isset($current_group)
                        </div></div>
                    @endisset
                    @php
                        $current_group = $route["group"];
                    @endphp
                    @isset($current_group)
                        @php
                            $group = config("routes.groups.$current_group");
                            $open = $current_group == (Route::current()->defaults["headers"]["menu-group"] ?? null);
                        @endphp
                        <div class="page-link col-md-12 {{$open ? "open" : ""}}" data-submenu="submenu-{{$current_group}}">
                            <div class="p-3">
                                <i class="fa-solid {{$group["icon"]}} fa-fw"></i>
                                {{$group["title"]}}
                                <i class="menu-chevron fa-solid fa-chevron-down float-right"></i>
                            </div>
                        </div>
                        <div class="submenu col-md-12 {{$open ? "" : "d-none"}}" data-submenu="submenu-{{$current_group}}">
                            <div class="row g-2">
                    @endisset
                @endif
                
                {{-- Menu item --}}
                @php
                    $page_name = Str::replace("backoffice.", "", $route["route"]);
                    $page = config("routes.pages.$page_name");
                @endphp
                <a href="{{route($route["route"])}}" class="page-link col-md-12 {{!is_null($current_group) ? "ps-5" : ""}} {{Route::current()->getName() == $route["route"] ? "active" : ""}}">
                    <div class="p-3">
                        <i class="{{$route["icon"]}} fa-fw"></i>
                        {{$route["title"]}}
                    </div>
                </a>
            @endforeach
            @isset($current_group)
                </div></div>
            @endisset
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Submenu buttons
        $(".menu .page-link[data-submenu]").on("click", function(){
            let is_open = $(this).hasClass("open");
            let submenu = $(this).attr("data-submenu");
            
            $('.submenu[data-submenu="'+submenu+'"]').toggleClass("d-none", is_open);
            $(this).toggleClass("open", !is_open);
        });
    });
</script>
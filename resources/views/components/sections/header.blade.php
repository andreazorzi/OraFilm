@if (app()->isDownForMaintenance())
    <x-maintenance-banner />
@endif
<header class="sticky-top top-0 start-0 z-3 p-3 fs-5 w-100">
    <div class="row g-3">
        <div class="col">
            <div class="ps-1">
                <a href="{{RouteController::route("index")}}">
                    <img src="{{asset("images/logo-white.png")}}" class="logo">
                </a>
            </div>
        </div>
    </div>
</header>
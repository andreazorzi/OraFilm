@if (app()->isDownForMaintenance())
    <x-maintenance-banner />
@endif
<header class="{{ isset($fixed) ? "fixed-top" : "sticky-top" }} top-0 start-0 z-3 p-3 fs-5 w-100">
    <div class="row g-3 gx-4">
        <div class="col">
            <div class="ps-1">
                <a href="{{RouteController::route("index")}}">
                    <img src="{{asset("images/logo-white.png")}}" class="logo">
                </a>
            </div>
        </div>
        @foreach (["production", "brand-film", "locations", "about-us"] as $link)
            <div class="col-auto align-self-center d-none d-md-block">
                <a href="{{RouteController::route("index")}}#@tolgee("pages.index.$link.anchor", force_plain_text: true)" class="no-link text-uppercase">
                    @tolgee("widgets.menu.$link")
                </a>
            </div>
        @endforeach
        <div class="col-auto align-self-center d-md-none">
            <i class="fa-solid fa-bars fs-3" role="button" data-bs-toggle="offcanvas" data-bs-target="#menu"></i>
        </div>
    </div>
</header>

<script>
    function checkHeader() {
        $("header").toggleClass("header-dark", $(window).scrollTop() > {{$dark ?? -1}});
        $("body").css("--header-height", $("header").outerHeight() + "px");
    }
    
    document.addEventListener("DOMContentLoaded", function() {
        checkHeader();
        
        $(window).on("scroll", checkHeader);
        $(window).on("resize", checkHeader);
    });
</script>
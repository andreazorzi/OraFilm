<div class="menu offcanvas offcanvas-start" tabindex="-1" id="menu" aria-labelledby="menuLabel">
    <div class="offcanvas-header">
        <div class="w-100">
            <div>
                <div class="row g-3 justify-content-end">
                    <div class="col-auto">
                        <div id="menu-close" class="ratio ratio-1x1 rounded-circle m-auto" style="width: 50px;" data-bs-dismiss="offcanvas" aria-label="Close">
                            <img src="{{asset("images/assets/x-mark.svg")}}" class="p-3" role="button">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="offcanvas-body pt-5 overflow-x-hidden">
        <div class="accordion" id="service-details">
            @foreach (["production", "brand-film", "locations", "about-us"] as $link)
                <div class="accordion-item border-0 mb-2" data-bs-dismiss="offcanvas" aria-label="Close">
                    <a href="{{RouteController::route("index")}}#@tolgee("pages.index.$link.anchor", force_plain_text: true)" class="accordion-header no-link">
                        <button class="accordion-button accordion-menu collapsed bg-white text-black border-bottom z-0 py-3 fs-3" type="button" data-bs-toggle="collapse" data-bs-target="#detail-contact-form" aria-expanded="true" aria-controls="detail-contact-form">
                            @tolgee("widgets.menu.$link")
                        </button>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
<div class="main-photo">
    <div class="row g-0 h-100 mx-auto">
        <div class="col-md-12 align-self-center">
            <div class="row g-3 justify-content-center m-auto">
                <div class="col-md-6 text-center">
                    <img src="{{asset("images/logo-negative.png")}}" class="logo w-75">
                </div>
                <div class="col-md-10 text-center">
                    <div class="px-3">
                        <h1 class="title mt-3 fs-2 mb-3">@tolgee("pages.index.main-photo.title")</h1>
                        <span class="text fs-5">@tolgee("pages.index.main-photo.text")</span>
                        <div class="row gy-3 gx-5 fs-5 mt-3 justify-content-center">
                            <div class="col-md-6">
                                <button class="btn-outline-white btn-zoom" onclick="scrollToElement(document.querySelector(`#@tolgee('pages.index.your-project.anchor', force_plain_text: true)`))">
                                    @tolgee("pages.index.main-photo.your_project")
                                </button>
                            </div>
                            <div class="col-md-6">
                                <button class="btn-outline-white btn-zoom" onclick="scrollToElement(document.querySelector(`#@tolgee('pages.index.services.anchor', force_plain_text: true)`))">
                                    @tolgee("pages.index.main-photo.our_services")
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="scroll-indicator">
        <svg viewBox="0 0 24 24" fill="none" stroke-width="2">
            <path d="M7 13l5 5 5-5M7 6l5 5 5-5"></path>
        </svg>
    </div>
</div>
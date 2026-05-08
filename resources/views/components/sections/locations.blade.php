<div id="@tolgee("pages.index.locations.anchor", force_plain_text: true)" class="locations row g-3 justify-content-center bg-white">
    <div class="col-lg-8">
        <div class="px-5 py-5">
            <x-sections.title :title="tolgee('pages.index.locations.title')" :subtitle="tolgee('pages.index.locations.subtitle')" />
            <div class="row g-3 mt-3">
                <div class="col-md-12">
                    <div class="text-column">
                        @tolgee("pages.index.locations.text")
                    </div>
                </div>
                <div class="col-md-12 text-center">
                    <button class="btn-orange btn-zoom">
                        @tolgee("pages.index.locations.suggest_your_location")
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
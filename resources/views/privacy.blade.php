<!DOCTYPE html>
<html lang="{{App::getLocale()}}" class="h-100">
    {{-- Head --}}
    <x-sections.head :page="$page"/>
    <body class="container-fluid p-0 overflow-x-hidden" hx-headers='{"X-CSRF-TOKEN": "{{csrf_token()}}"}' hx-ext="ajax-header" hx-vals='{"language": "{{App::getLocale()}}"}' hx-disabled-elt="this">
        {{-- Header --}}
        <x-sections.header />
        
        <div id="sections" class="row g-0 justify-content-center h-100 mt-5">
            <div class="content col-md-12 overflow-hidden">
                <div class="row g-3 justify-content-center">
                    <div class="col-md-10">
                        {{-- Paragraph --}}
                        <x-sections.title :title="tolgee('privacies.privacy.title')" :subtitle="tolgee('privacies.privacy.subtitle', ['website' => request()->host()])" />
                    </div>
                </div>
                
                {{-- Privacy --}}
                <div class="row g-0 gy-5 justify-content-center mb-5">
                    <div class="col-lg-8 p-4 px-md-5 text-start">
                        @tolgee('privacies.privacy.privacy', [
                            "website" => request()->host(),
                            "business_name" => config("orafilm.business_name"),
                            "business_address" => config("orafilm.business_address"),
                            "business_privacy_email" => config("orafilm.business_privacy_email"),
                            "business_pec" => config("orafilm.business_pec"),
                            "business_phone" => config("orafilm.business_phone"),
                            "dpo_email" => config("orafilm.dpo_email"),
                        ])
                    </div>
                </div>
                
                {{-- Footer --}}
                <x-sections.footer />
            </div>
        </div>
        
        {{-- Menu --}}
        <x-sections.menu />
        
        {{-- Scripts --}}
        <x-script />
        <x-turnstile.scripts />
        <script>
            
        </script>
    </body>
</html>
<!DOCTYPE html>
<html lang="{{App::getLocale()}}" class="h-100">
    {{-- Head --}}
    <x-sections.head :page="$page"/>
    <body class="container-fluid p-0 overflow-x-hidden" hx-headers='{"X-CSRF-TOKEN": "{{csrf_token()}}"}' hx-ext="ajax-header" hx-vals='{"language": "{{App::getLocale()}}"}'>
        {{-- Header --}}
        <x-sections.header dark="100" fixed />
        
        <div id="sections" class="row g-0 justify-content-center h-100">
            <div class="content col-md-12 overflow-hidden">
                {{-- Main photo --}}
                <x-sections.main-photo />
                
                {{-- Production --}}
                <x-sections.production />
                
                {{-- Brand Film --}}
                <x-sections.brand-film />
                
                {{-- Locations --}}
                <x-sections.locations />
                
                {{-- Your Project --}}
                <x-sections.your-project />
                
                {{-- About Us --}}
                <x-sections.about-us />
                
                {{-- Footer --}}
                <x-sections.footer />
            </div>
        </div>
        
        {{-- Menu --}}
        <x-sections.menu />
        
        {{-- Scripts --}}
        <x-script />
        <script>
            
        </script>
    </body>
</html>
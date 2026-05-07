<!DOCTYPE html>
<html>
    {{-- Head --}}
    <x-backoffice.head title="Home" />
    
    <body class="container-fluid" hx-headers='{"X-CSRF-TOKEN": "{{csrf_token()}}"}' hx-ext="ajax-header" hx-disabled-elt="this" hx-target="#request-response">
        {{-- Header --}}
        <x-backoffice.header />

        <div id="container">
            <x-backoffice.title title="Home"/>
            
            <x-backoffice.bookmarks-menu />
        </div>
        
        {{-- Footer --}}
        {{-- <x-backoffice.footer /> --}}
                
        {{-- Menu --}}
        <x-backoffice.menu />
        
        {{-- Ajax responses --}}
        <div id="request-response"></div>
        
        {{-- Scripts --}}
        <x-script />
        <script>
            
        </script>
    </body>
</html>
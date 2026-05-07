<!DOCTYPE html>
<html>
    {{-- Head --}}
    <x-backoffice.head title="Users" />
    
    <body class="container-fluid" hx-headers='{"X-CSRF-TOKEN": "{{csrf_token()}}"}' hx-ext="ajax-header" hx-disabled-elt="this" hx-target="#request-response">
        {{-- Header --}}
        <x-backoffice.header />

        <div id="container">
            <x-backoffice.title title="Gestione Utenti" subtitle="Aggiungi e modifica gli utenti"/>
        
            {{-- Search Table --}}
            <x-search-table::table :model="new App\Models\User()" showadvancefilters="offcanvas" />
        </div>
        
        {{-- Footer --}}
        {{-- <x-backoffice.footer /> --}}
                
        {{-- Menu --}}
        <x-backoffice.menu />
        
        {{-- Modal --}}
        <x-modal />
        
        {{-- Ajax responses --}}
        <div id="request-response"></div>
        
        {{-- Scripts --}}
        <x-script />
        <script>
            
        </script>
    </body>
</html>
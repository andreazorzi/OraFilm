<!DOCTYPE html>
<html>
    {{-- Head --}}
    <x-backoffice.head title="Logs" />
    
    <body class="container-fluid" hx-headers='{"X-CSRF-TOKEN": "{{csrf_token()}}"}' hx-ext="ajax-header" hx-disabled-elt="this" hx-target="#request-response">
        {{-- Header --}}
        <x-backoffice.header />

        <div id="container">
            <x-backoffice.title title="Logs" />
        
            {{-- Search Table --}}
            <div class="row g-3 pb-3">
                <div class="col-md-12 text-end">
                    <button class="btn btn-warning" hx-delete="{{route("logs.clear")}}" hx-target="#request-response" hx-confirm="Cancellare tutti i logs?">
                        Reset
                    </button>
                </div>
                <div class="col-md-12">
                    <div class="card">
                        <div id="logs" class="card-body overflow-auto">
                            @php
                                $logs = nl2br(Storage::disk("logs")->get("laravel.log"))
                                    |> (fn($text) => preg_replace('/(\[\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\])/i', '<br><span class="text-primary fw-bold">$1</span>', $text))
                                    |> (fn($text) => preg_replace('/(\w+.ERROR)/i', '<span class="text-danger">$1</span>', $text))
                                    |> (fn($text) => preg_replace('/(#\d+[^\n]+)/i', '<span class="text-muted fst-italic">$1</span>', $text))
                                    |> (fn($text) => preg_replace('/(\[stacktrace\])/i', '<span class="text-muted fw-bold">$1</span>', $text))
                                    |> (fn($text) => preg_replace('/(((?:select|insert|update|delete)[^{]*)\) (\{"|at))/i', '<span class="text-success">$2</span>) $3', $text))
                                ;
                            @endphp
                            {!! $logs !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
                
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
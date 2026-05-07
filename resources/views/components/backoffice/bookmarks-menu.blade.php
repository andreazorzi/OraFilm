@php
    $routes = RouteController::menu_routes();
@endphp
<div class="row mt-0 g-3 justify-content-center">
    <div class="col-lg-8">
        <div id="bookmarks" class="row g-3 justify-content-center">
            @foreach ($routes as $route)
                <x-backoffice.bookmark :title="$route['title']" :route="$route['route']" :color="$route['color']" :icon="$route['icon']"/>
            @endforeach
        </div>
    </div>
</div>
<!DOCTYPE html>
<html lang="it">
    <x-backoffice.head title="Login" />

    <body class="container-fluid login-container vh-100" hx-headers='{"X-CSRF-TOKEN": "{{csrf_token()}}"}' hx-ext="ajax-header" hx-disabled-elt="this">
        @if (app()->isDownForMaintenance())
            <header class="row fixed-top h-auto">
                <x-maintenance-banner />
            </header>
        @endif
        <div class="row h-100 justify-content-center">
            <div class="col-md-12 align-self-center text-center" style="max-width: 450px;">
                <div class="col-md-12 p-4 align-self-center text-center" style="margin-top: -100px;">
                    <img class="w-75 mx-auto" src="{{asset("images/logo.png")}}">
                </div>
                <div class="col-md-12 align-self-center text-center">
                    <div class="card shadow rounded-4">
                        <div class="card-body p3">
                            <h2 class="mb-4">Login</h2>
                            @if (config("auth.web_login"))
                                <form action="{{route("auth.web.login")}}" method="post">
                                    <input type="text" id="username" name="username" class="form-control mb-3" placeholder="Username" value="{{request()->old("username")}}">
                                    <input type="password" id="password" name="password" class="form-control mb-3" placeholder="Password">
                                    
                                    @csrf
                                    
                                    <button class="btn btn-primary w-100">
                                        Accedi
                                    </button>
                                    
                                    {{-- TODO: Add forgot password --}}
                                    {{-- @if(!empty(request()->old("username")))
                                        <div class="mt-3">
                                            <u role="button" hx-post="{{route("user.send-reset-password-user", [request()->old("username")])}}">
                                                Hai dimenticato la password?
                                            </u>
                                        </div>
                                    @endif --}}
                                </form>
                                @if (!is_null(config("services.authentik.base_url")))
                                    <hr class="my-4">
                                @endif
                            @endif
                            @if (!is_null(config("services.authentik.base_url")))
                                <a href="{{route("auth.authentik.login")}}" class="btn btn-authentik w-100">
                                    <img src="{{asset("images/authentik.png")}}" class="d-inline-block align-middle me-2" style="height: 15px;">
                                    <span class="align-middle">Authentik</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        {{-- HTMX Response --}}
        <div id="request-response"></div>
        
        {{-- Scripts--}}
        <x-script />
        @if(isset($errors) && $errors->any())
            <x-laravel-advanced-model::alert status="danger" :message="implode('\n', $errors->all())"/>
        @endif
    </body>
</html>

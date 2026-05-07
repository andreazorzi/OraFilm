@php
    use App\Models\User;
@endphp
<header class="row sticky-top shadow-sm">
    @if (app()->isDownForMaintenance())
        <x-maintenance-banner />
    @endif
    <div class="col-auto py-2 px-3 align-self-center">
        <i id="menu-button" class="fa-solid fa-bars fs-4" data-bs-toggle="offcanvas" data-bs-target="#menu" aria-controls="menu"></i>
    </div>
    <div class="col py-2 px-1 align-self-center h-100">
        <a href="{{route("backoffice.index")}}" class="text-body fw-bold text-decoration-none">
            <img src="{{asset("images/favicon.png")}}" class="logo me-2">
            <h2 class="d-inline-block align-middle m-0 fw-bold">{{config("app.name")}}</h2>
        </a>
    </div>
    <div id="user-box" class="dropdown col-auto align-self-center position-relative">
        <div data-bs-toggle="dropdown" aria-expanded="false">
            <h5 class="d-none d-sm-inline-block align-middle m-0 fs-6">{{User::current()->name}}</h5>
            <img src="{{User::current()?->getAvatar() ?? ""}}" class="avatar ms-2 shadow-sm">
        </div>
        
        <ul class="dropdown-menu p-0 mt-3 overflow-hidden">
            @if (!empty(session("auth.impersonate")))
                <li>
                    <div class="dropdown-item py-2" hx-post="{{route("users.impersonate.stop")}}" hx-target="body" hx-swap="beforeend">
                        <i class="fa-solid fa-xmark fa-fw me-2"></i>
                        Stop impersonate
                    </div>
                </li>
            @endif
            <li>
                <a class="dropdown-item py-2" href="{{route("auth.web.logout")}}">
                    <i class="fa-solid fa-arrow-right-from-bracket fa-fw me-2"></i>
                    Logout
                </a>
            </li>
        </ul>
    </div>
</header>
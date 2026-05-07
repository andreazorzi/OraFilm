@php
    $user ??= null;
@endphp
<div class="modal-header">
    <h1 class="modal-title fs-5" id="modalLabel">Gestione Utente</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row g-3">
        @isset($user)
            <div class="col-md-6">
                <img src="{{$user->getAvatar()}}" class="rounded-circle">
            </div>
        @endisset
        <div class="col-md-6 {{empty($user) ? "order-3" : ""}}">
            <label>Attivo</label>
            <select id="user-enabled" name="enabled">
                <option value="0" @selected(!($user->enabled ?? 1)) data-text="danger">Disattivo</option>
                <option value="1" @selected($user->enabled ?? 1) data-text="success">Attivo</option>
            </select>
        </div>
        <div class="col-md-6">
            <label>Username</label>
            <input type="text" class="form-control" id="user-username" {!! empty($user) ? 'name="username"' : "" !!} value="{{$user->username ?? ""}}" oninput="this.value = this.value.toLowerCase().replace(/[^\w_\.]+/g, '')" @readonly(!empty($user->username))>
        </div>
        <div class="col-md-6 order-5">
            <label>Nome</label>
            <input type="text" class="form-control" id="user-name" name="name" value="{{$user->name ?? ""}}">
        </div>
        <div class="col-md-{{isset($user) ? "12" : "6"}} order-5">
            <label>Email</label>
            <input type="text" class="form-control" id="user-email" name="email" value="{{$user->email ?? ""}}">
        </div>
        
        @if(empty($user))
            <div class="col-md-6 order-5">
                <input type="hidden" name="send_password" value="0">
                <input type="checkbox" id="user-send_password" name="send_password" value="1" @checked(config("app.env") != "local")>
                <label for="user-send_password" role="button">Invia link reset password</label>
            </div>
        @elseif(!empty($user) && $user->type != "authentik")
            @php
                $reset_link = $user->password_reset()->orderByDesc("expiration")->first();
            @endphp
            <div class="col-md-12 order-5">
                @if (!is_null($reset_link))
                    <label>Ultimo password reset link inviato:</label>
                    <span class="text-{{time() < strtotime($reset_link->expiration) ? "success" : "danger"}}">
                        {{date("d/m/Y H:i:s", strtotime($reset_link->expiration." - 1 day"))}}
                    </span>
                    <i class="fa-solid fa-clipboard ms-2" onclick="navigator.clipboard.writeText('{{$reset_link->getUrl()}}'); Toastify({ text: 'Link copiato!', escapeMarkup: false, duration: '1500', close: true, className: 'success', gravity: 'bottom', position: 'center' }).showToast();" role="button"></i>
                @endif
            </div>
            <div class="col-md-12 text-center order-5">
                <button class="btn btn-warning btn-sm" hx-post="{{route("users.send-reset-password", [$user])}}" hx-target="#request-response">
                    Resetta Password
                </button>
            </div>
        @endif
    </div>
</div>
<div class="modal-footer">
    <div class="row w-100 justify-content-end">
        @isset($user)
            <div class="col-md-6 p-0">
                <button id="user-delete" type="button" class="btn btn-danger"
                    hx-delete="{{route("users.destroy", [$user])}}" hx-target="#request-response" hx-confirm="Eliminare l'utente {{$user->username}}?" hx-params="none">
                    Elimina
                </button>
            </div>
        @endisset
        <div class="col-md-6 p-0 text-end">
            @csrf
            <button id="user-save" type="button" class="btn btn-primary"
                @isset($user)
                    hx-put="{{route("users.update", [$user])}}"
                @else
                    hx-post="{{route("users.store")}}"
                @endisset
                hx-target="#request-response">
                Salva
            </button>
        </div>
    </div>
</div>

<script>
    user_enabled = new SelectSearch("#user-enabled", {
        custom_class: {
            placeholder: "form-select mw-100"
        },
        render(element){
            return "<span class='text-"+element.getAttribute("data-text")+"'>" + element.textContent + "</span> "
        }
    });
    
    modal.show();
</script>

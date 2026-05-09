@php
    $data = [];
    
    if(config("app.env") == "local"){
        $data = [
            "first_name" => "Mario",
            "last_name" => "Rossi",
            "email" => "test@test.it",
            "phone" => "3333333333",
            "request" => fake()->paragraph(5),
        ];
    }
@endphp
<div class="modal-header">
    <h1 class="modal-title fs-5 text-coral" id="modalLabel">@tolgee('pages.index.your-project.title')</h1>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="row g-3">
        <div class="col-md-6">
            <label class="text-coral fw-bold text-capitalize" for="your-project-first_name">{{__('validation.attributes.first_name')}}</label>
            <input type="text" class="form-control" id="your-project-first_name" name="first_name" value="{{$data["first_name"] ?? ""}}">
        </div>
        <div class="col-md-6">
            <label class="text-coral fw-bold text-capitalize" for="your-project-last_name">{{__('validation.attributes.last_name')}}</label>
            <input type="text" class="form-control" id="your-project-last_name" name="last_name" value="{{$data["last_name"] ?? ""}}">
        </div>
        <div class="col-md-6">
            <label class="text-coral fw-bold text-capitalize" for="your-project-email">{{__('validation.attributes.email')}}</label>
            <input type="email" class="form-control" id="your-project-email" name="email" value="{{$data["email"] ?? ""}}">
        </div>
        <div class="col-md-6">
            <label class="text-coral fw-bold text-capitalize" for="your-project-phone">{{__('validation.attributes.phone')}}</label>
            <input type="text" class="form-control" id="your-project-phone" value="{{$data["phone"] ?? ""}}">
        </div>
        <div class="col-md-12">
            <label class="text-coral fw-bold text-capitalize" for="your-project-request">{{__('validation.attributes.request')}}</label>
            <textarea class="form-control" id="your-project-request" name="request" rows="7">{{$data["request"] ?? ""}}</textarea>
        </div>
        <div class="col-md-12">
            <div class="row g-2">
                <div class="col-auto">
                    <input type="hidden" name="privacy" value="0">
                    <input type="checkbox" name="privacy" id="privacy" class="form-check-input me-2" value="1">
                </div>
                <div class="col">
                    <label for="privacy" class="form-check-label" role="button">
                        @tolgee("widgets.contact-form.privacy", ["url" => RouteController::route("privacy-contacts", App::getLocale())]) 
                    </label>
                </div>
            </div>
        </div>
        <div class="col-md-12 text-center">
            <x-turnstile />
        </div>
        <div class="col-md-12 text-center">
            <button class="btn-orange btn-zoom" hx-post="{{route("send-project-request")}}" hx-target="#request-response" hx-vals='js:{"phone": yout_project_phone.getNumber()}'>
                @tolgee('widgets.actions.send')
            </button>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        yout_project_phone = intlTelInput(document.querySelector("#your-project-phone"), {
            loadUtils: loadIntlTelInputUtils,
            initialCountry: "it",
            countryOrder: ["it", "de", "gb"],
            autoPlaceholder: "off",
            separateDialCode: true,
            strictMode: true,
            containerClass: "w-100",
            i18n: tel_{{App::getLocale()}},
        });
    });
</script>
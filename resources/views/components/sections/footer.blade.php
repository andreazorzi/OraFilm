<footer class="row g-0 justify-content-center bg-orange">
    <div class="col-md-12">
        <div class="row gy-4 mt-0 justify-content-center">
            <div class="col-5 d-md-none order-2">
                <hr>
            </div>
            <div class="col-md-4 order-2 align-self-center">
                <div class="p-md-4 text-center">
                    <h6>{{ config('app.name') }}</h6>
                    <div class="mt-2">Via Rossi 1, 37011 Bardolino (VR)</div>
                    <div class="mt-2">
                        <a href="tel:+393331234567" class="no-link">
                            <i class="fa-solid fa-phone fa-fw me-2"></i>
                            <u>+39 333 123 4567</u>
                        </a>
                    </div>
                    <div class="mt-2">
                        <a href="mailto:{{ config('mail.from.address') }}" class="no-link">
                            <i class="fa-solid fa-envelope fa-fw me-2"></i>
                            <u>{{ config('mail.from.address') }}</u>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 order-1 order-md-2 align-self-center text-center">
                <img src="{{asset("images/logo-white.png")}}" class="w-100" style="max-width: 200px;">
            </div>
            <div class="col-5 d-md-none order-2">
                <hr>
            </div>
            <div class="col-md-4 order-2 align-self-center">
                <div class="row g-3 justify-content-center fs-4 text-center">
                    <div class="col-md-12">
                        @tolgee("widgets.footer.socials")
                    </div>
                    <div class="col-auto">
                        <i class="fa-brands fa-facebook"></i>
                    </div>
                    <div class="col-auto">
                        <i class="fa-brands fa-square-instagram"></i>
                    </div>
                    <div class="col-auto">
                        <i class="fa-brands fa-youtube"></i>
                    </div>
                    <div class="col-auto">
                        <i class="fa-brands fa-linkedin"></i>
                    </div>
                </div>
            </div>
            <div class="col-11 d-md-none order-2">
                <hr class="mb-0">
            </div>
        </div>
    </div>
    <div class="col-lg-8 col-xl-6 order-3">
        <div class="p-4 text-center">
            &copy; {{ date('Y') }} {{ config('app.name') }}
        </div>
    </div>
</footer>

<div id="request-response"></div>
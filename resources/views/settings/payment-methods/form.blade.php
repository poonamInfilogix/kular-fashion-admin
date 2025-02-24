<div class="row">
    <div class="col-md-3">
        <div class="nav flex-column nav-pills" id="paymentMethodSettings" role="tablist" aria-orientation="vertical">
            <a @class(['nav-link mb-2', 'active' => old('method', (session('method') ?? 'apple_pay'))==='apple_pay']) data-bs-toggle="pill" href="#apple-pay" role="tab">Apple Pay</a>
            <a @class(['nav-link', 'active' => old('method', session('method'))==='clearpay']) data-bs-toggle="pill" href="#clearpay" role="tab">Clearpay</a>
            <a @class(['nav-link', 'active' => old('method', session('method'))==='opayo']) data-bs-toggle="pill" href="#opayo" role="tab">Opayo</a>
            <a @class(['nav-link', 'active' => old('method', session('method'))==='gift_voucher']) data-bs-toggle="pill" href="#gift-voucher" role="tab">Gift Voucher</a>
            <a @class(['nav-link', 'active' => old('method', session('method'))==='klarna']) data-bs-toggle="pill" href="#klarna" role="tab">Klarna</a>
            <a @class(['nav-link', 'active' => old('method', session('method'))==='credit_card']) data-bs-toggle="pill" href="#credit-card" role="tab">Credit/ Debit Card</a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content text-muted mt-4 mt-md-0" id="paymentMethodSettingsContent">
            <div @class(['tab-pane fade', 'show active' => old('method', (session('method') ?? 'apple_pay'))==='apple_pay']) id="apple-pay" role="tabpanel">
                @include('settings.payment-methods.partials.apple-pay')
            </div>
            <div @class(['tab-pane fade', 'show active' => old('method', session('method'))==='clearpay']) id="clearpay" role="tabpanel">
                @include('settings.payment-methods.partials.clearpay')
            </div>
            <div @class(['tab-pane fade', 'show active' => old('method', session('method'))==='opayo']) id="opayo" role="tabpanel">
                @include('settings.payment-methods.partials.opayo')
            </div>
            <div @class(['tab-pane fade', 'show active' => old('method', session('method'))==='gift_voucher']) id="gift-voucher" role="tabpanel">
                @include('settings.payment-methods.partials.gift-voucher')
            </div>
            <div @class(['tab-pane fade', 'show active' => old('method', session('method'))==='klarna']) id="klarna" role="tabpanel">
                @include('settings.payment-methods.partials.klarna')
            </div>
            <div @class(['tab-pane fade', 'show active' => old('method', session('method'))==='credit_card']) id="credit-card" role="tabpanel">
                @include('settings.payment-methods.partials.credit-card')
            </div>
        </div>
    </div>
</div>

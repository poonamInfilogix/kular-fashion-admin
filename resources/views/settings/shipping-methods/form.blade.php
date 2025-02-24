<div class="row">
    <div class="col-md-3">
        <div class="nav flex-column nav-pills" id="shippingMethodSettings" role="tablist" aria-orientation="vertical">
            <a @class(["nav-link mb-2", 'active' => old('method', (session('method') ?? 'royal_mail'))==='royal_mail']) data-bs-toggle="pill" href="#royal-mail" role="tab">Royal Mail</a>
            <a @class(["nav-link", 'active' => old('method', session('method'))==='dpd']) data-bs-toggle="pill" href="#dpd" role="tab">DPD</a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content text-muted mt-4 mt-md-0" id="shippingMethodSettingsContent">
            <div @class(['tab-pane fade', 'show active' => old('method', (session('method') ?? 'royal_mail'))==='royal_mail']) id="royal-mail" role="tabpanel">
                @include('settings.shipping-methods.partials.royal-mail')
            </div>
            <div @class(['tab-pane fade', 'show active' => old('method', session('method'))==='dpd']) id="dpd" role="tabpanel">
                @include('settings.shipping-methods.partials.dpd')
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-3">
        <div class="nav flex-column nav-pills" id="shippingMethodSettings" role="tablist" aria-orientation="vertical">
            <a @class(["nav-link mb-2", 'active' => old('method', (session('method') ?? 'royal_mail'))==='royal_mail']) id="royal-mail-tab" data-bs-toggle="pill" href="#royal-mail" role="tab"
                aria-controls="v-pills-home" aria-selected="true">Royal Mail</a>
            <a @class(["nav-link", 'active' => old('method', session('method'))==='dpd']) id="dpd-method-tab" data-bs-toggle="pill" href="#dpd-method" role="tab"
                aria-controls="dpd-method" aria-selected="false">DPD</a>
        </div>
    </div>
    <div class="col-md-9">
        <div class="tab-content text-muted mt-4 mt-md-0" id="shippingMethodSettingsContent">
            <div @class(["tab-pane fade", 'show active' => old('method', (session('method') ?? 'royal_mail'))==='royal_mail']) id="royal-mail" role="tabpanel" aria-labelledby="royal-mail-tab">
                @include('settings.shipping-methods.partials.royal-mail')
            </div>
            <div @class(["tab-pane fade", 'show active' => old('method', session('method'))==='dpd']) id="dpd-method" role="tabpanel" aria-labelledby="dpd-method-tab">
                @include('settings.shipping-methods.partials.dpd')
            </div>
        </div>
    </div>
</div>

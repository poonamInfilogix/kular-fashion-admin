@extends('layouts.app')

@section('title', 'Payment Method Settings')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xl-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('payment-settings.store') }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                        <div class="mb-3">
                                            <x-form-input type="file" name="site_logo" class="form-control"
                                                label="Site Logo" />

                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if (setting('site_logo'))
                                                        <img src="{{ asset(setting('site_logo')) }}" id="preview-site_logo"
                                                            class="img-preview img-fluid mt-2">
                                                    @else
                                                        <img src="" id="preview-site_logo"
                                                            class="img-fluid mt-2 w-150" hidden>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                        <div class="mb-3">
                                            <x-form-input type="file" name="web_favicon" id="web_favicon"
                                                class="form-control" label="Favicon" />

                                            <div class="row">
                                                <div class="col-md-6">
                                                    @if (setting('web_favicon'))
                                                        <img src="{{ asset(setting('web_favicon')) }}"
                                                            id="preview-web_favicon" class="img-preview img-fluid mt-2">
                                                    @else
                                                        <img src="" id="preview-web_favicon"
                                                            class="img-fluid mt-2 w-150" hidden>
                                                    @endif

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                        <div class="mb-3">
                                            <x-form-input name="website_title" value="{{ setting('website_title') }}"
                                                label="Website title" placeholder="Enter websitE title" required="true" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                        <div class="mb-3">
                                            <x-form-input name="web_contact_no" value="{{ setting('web_contact_no') }}"
                                                label="Web contact number" placeholder="Enter web contact number"
                                                required="true" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                        <div class="mb-3">
                                            <x-form-input name="web_contact_email"
                                                value="{{ setting('web_contact_email') }}" label="Web contact email"
                                                placeholder="Enter web contact email" required="true" />
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-md">Save</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-include-plugins :plugins="['imagePreview']"></x-include-plugins>
@endsection

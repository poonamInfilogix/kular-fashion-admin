@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">General Settings</h4>
                    </div>
                </div>
            </div>
            <!-- end page title -->
            <div class="row">
                <div class="col-xl-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <form class="form-horizontal" action="{{ route('general-settings.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                        <div class="mb-3">
                                            <label for="season" class="form-label">Default Season</label>
                                            <select name="default_season" id="default_season" class="form-control{{ $errors->has('default_season') ? ' is-invalid' : '' }}">
                                                <option value="Summer" @selected(setting('default_season') === 'Summer')>Summer</option>
                                                <option value="Winter" @selected(setting('default_season') === 'Winter')>Winter</option>
                                                <option value="Autumn" @selected(setting('default_season') === 'Autumn')>Autumn</option>
                                                <option value="Spring" @selected(setting('default_season') === 'Spring')>Spring</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4 col-lg-4 col-xl-3">
                                        <div class="mb-3">
                                            <label for="season" class="form-label">1 Euro = *.** pound</label>
                                            <input type="text" class="form-control">
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
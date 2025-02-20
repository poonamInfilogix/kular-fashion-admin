@extends('layouts.app')

@section('title', 'Add new tax')
@section('header-button')
    <a href="{{ route('tax-settings.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Go Back</a>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('tax-settings.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @include('settings.tax-settings.form')
                            </form>    
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
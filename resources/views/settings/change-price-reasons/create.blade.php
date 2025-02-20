@extends('layouts.app')

@section('title', 'Add Change Price Reason')
@section('header-button')
<a href="{{ route('change-price-reasons.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Go Back</a>
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
                            <form action="{{ route('change-price-reasons.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @include('settings.change-price-reasons.form')
                            </form>    
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
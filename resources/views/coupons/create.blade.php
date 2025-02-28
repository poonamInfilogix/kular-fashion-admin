@extends('layouts.app')

@section('title', 'Create a Coupon and Discounts')
@section('header-button')
    <a href="{{ route('coupons.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Go Back</a>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <form action="{{ route('coupons.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('coupons.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

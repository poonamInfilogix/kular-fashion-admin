@extends('layouts.app')

@section('title', 'Create a Coupon and Discounts')
@section('header-button')
    <a href="{{ route('coupon-discounts.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Go Back</a>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <form action="{{ route('coupon-discounts.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @include('coupon-discounts.form')
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

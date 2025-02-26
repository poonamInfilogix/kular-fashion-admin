@extends('layouts.app')

@section('title', 'Create a Coupon and Discounts')
@section('header-button')
<a href="{{ route('coupons-discount.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to Coupon and Discounts</a>
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
                            <form action="{{ route('coupons-discount.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @include('coupons-discount.form')
                            </form>    
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
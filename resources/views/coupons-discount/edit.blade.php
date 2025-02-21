@extends('layouts.app')

@section('title', 'Update Coupon')
@section('header-button')
<a href="{{ route('coupons-discount.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to Coupons</a>
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
                            <form action="{{ route('coupons-discount.update', $coupon->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('coupons-discount.form')
                            </form>    
                        </div>    
                    </div>
                </div> 
            </div> 
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'Update Size')
@section('header-button')
<a href="{{ route('sizes.index',  $sizeScaleId) }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to sizes</a>
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
                            <form action="{{ route('sizes.update', ['sizeScaleId' => $sizeScaleId, 'size' => $size->id]) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('size-scales.sizes.form')
                            </form>    
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
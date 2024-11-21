@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Edit variations for article {{ $product->article_code }}</h4>

                        <div class="page-title-right">
                            <a href="{{ route('products.create.step-2') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to Step 2</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />   
                    <div class="card">
                        <div class="card-body">  
                            <form action="{{ route('products.update', $product->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('products.steps.quantity-form')

                                <button type="button" class="btn btn-secondary me-2" id="add-variant-btn">Add new variant</button>
                                <button class="btn btn-primary">Save</button>
                            </form>    
                            
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('products.steps.quantity-form-script')
@endsection
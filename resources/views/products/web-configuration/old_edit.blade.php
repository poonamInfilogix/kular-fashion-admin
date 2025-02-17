@extends('layouts.app')

@section('title', 'Edit Web Configration')
@section('header-button')
    <a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back asto products</a>
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
                            <form action="{{ route('products.update.web-configuration', $product->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('products.web-configuration.form')

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light">Save
                                        Changes</button>
                                    <button type="button" class="btn btn-secondary waves-effect waves-light">Cancel</button>
                                </div>
                                {{-- <button type="button" class="btn btn-secondary me-2" id="add-variant-btn">Add new variant</button> --}}
                                {{-- <button class="btn btn-primary">Save</button> --}}
                              
                            </form>    
                            
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

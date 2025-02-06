@extends('layouts.app')

@section('title', 'Update Supplier')
@section('header-button')
<a href="{{ route('suppliers.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to all Suppliers</a>
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
                            <form action="{{ route('suppliers.update', $supplier->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('suppliers.form')
                            </form>    
                        </div>    
                    </div>
                </div>
            </div> 
        </div>
    </div>
@endsection
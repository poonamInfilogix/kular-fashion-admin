@extends('layouts.app')

@section('title', 'Create a new Color')
@section('header-button')
<a href="{{ route('colors.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to colors</a>
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
                            <form action="{{ route('colors.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @include('colors.form')
                            </form>    
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@extends('layouts.app')

@section('title', 'Create a new Collection')
@section('header-button')
<a href="{{ route('collections.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to colors</a>
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
                            <form action="{{ route('collections.store') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @include('collections.form')
                            </form>    
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
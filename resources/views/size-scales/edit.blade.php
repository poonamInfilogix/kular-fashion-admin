@extends('layouts.app')

@section('title', 'Update Size Scales')
@section('header-button')
    @if (Auth::user()->can('create size scales'))
        <a href="{{ route('size-scales.create') }}" class="btn btn-primary">Add New Size Scale</a>
    @endif
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
                            <form action="{{ route('size-scales.update', $sizeScale->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('size-scales.form')
                            </form>    
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
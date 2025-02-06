@extends('layouts.app')

@section('title', 'Update Tags')
@section('header-button')
<a href="{{ route('tags.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to all tags</a>
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
                            <form action="{{ route('tags.update', $tag->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('tags.form')
                            </form>    
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
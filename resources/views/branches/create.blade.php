@extends('layouts.app')

@section('title', 'Add Branch')
@section('header-button')
    <a href="{{ route('branches.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Go Back</a>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="session('message')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('branches.store') }}" method="POST">
                                @csrf
                                @include('branches.form')
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
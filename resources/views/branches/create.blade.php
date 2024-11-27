@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Create Branch</h4>
                        <div class="page-title-right">
                            <a href="{{ route('users.index') }}" class="btn btn-primary">Back</a>
                        </div>
                    </div>
                </div>
            </div>
            <!-- end page title -->

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
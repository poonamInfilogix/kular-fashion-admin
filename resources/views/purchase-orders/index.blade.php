@extends('layouts.app')

@section('title', 'Purchase Orders')
@section('header-button')
    <a href="{{ route('purchase-orders.create') }}" class="btn btn-primary"><i class="bx bx-plus"></i> Create a new Order</a>
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
                            <table id="datatable" class="table table-bordered table-striped dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="p-1">#</th>
                                        <th class="p-1">Order ID</th>
                                        <th class="p-1">Supplier Order Number</th>
                                        <th class="p-1">Supplier Name</th>
                                        <th class="p-1">Order Date</th>
                                        <th class="p-1">Delivery Date</th>
                                        @canany(['edit role', 'delete role'])
                                            <th class="p-1">Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <x-include-plugins :plugins="['dataTable']"></x-include-plugins>
@endsection

@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Products</h4>

                        <div class="page-title-right">
                            <a href="{{ route('products.create') }}" class="btn btn-primary">Add New Product</a>
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
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Article Code</th>
                                        <th>Manufacture Code</th>
                                        <th>Department</th>
                                        <th>Product Type</th>
                                        <th>Brand</th>
                                        <th>In date</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($products as $key => $product)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $product->article_code }}</td>
                                            <td>{{ $product->manufacture_code }}</td>
                                            <td>{{ optional($product->department)->name }}</td>
                                            <td>{{ optional($product->productType)->product_type_name }}</td>
                                            <td>{{ optional($product->brand)->brand_name }}</td>
                                            <td>{{ $product->in_date}}</td>
                                            <td><img src="{{ asset($product->image) }}" width="50" height="50" 
                                                onerror="this.onerror=null; this.src='{{ asset(setting('default_product_image')) }}';" >
                                            </td>
                                            <td>
                                                <input type="checkbox" id="{{ $product->id }}"  class="update-status" data-id="{{ $product->id }}" switch="success"  data-on="Active" data-off="Inactive" {{ $product->status === 'Active' ? 'checked' : '' }} data-endpoint="{{ route('product-status')}}"/>
                                                <label for="{{ $product->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                            </td>
                                            <td class="action-buttons">
                                                <a href="{{ route('products.edit', $product->id)}}" class="btn btn-primary btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                                <button data-source="Product" data-endpoint="{{ route('products.destroy', $product->id)}}"
                                                    class="delete-btn btn btn-danger btn-sm edit">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>
    <x-include-plugins :plugins="['dataTable', 'update-status' ]"></x-include-plugins>
@endsection
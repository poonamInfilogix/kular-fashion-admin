@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Brands</h4>

                        <div class="page-title-right">
                            <a href="{{ route('brands.create') }}" class="btn btn-primary">Add New Brand</a>
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
                                        <th>brand Name</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($brands as $key => $brand)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $brand->brand_name }}</td>
                                            <td><img src="{{ asset($brand->image) }}" width="50" height="50" 
                                                onerror="this.onerror=null; this.src='{{ asset(setting('default_brand_image')) }}';" >
                                            </td>
                                            <td>
                                                <input type="checkbox" id="{{ $brand->id }}"  class="update-status" data-id="{{ $brand->id }}" switch="success"  data-on="Active" data-off="Inactive" {{ $brand->status === 'Active' ? 'checked' : '' }} data-endpoint="{{ route('brands-status')}}"/>
                                                <label for="{{ $brand->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                            </td>
                                            <td class="action-buttons">
                                                <a href="{{ route('brands.edit', $brand->id)}}" class="btn btn-primary btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                                <button data-source="Brand" data-endpoint="{{ route('brands.destroy', $brand->id)}}"
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
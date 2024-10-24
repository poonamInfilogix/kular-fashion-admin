@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Categories</h4>

                        <div class="page-title-right">
                            <a href="{{ route('categories.create') }}" class="btn btn-primary">Add New Category</a>
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
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($categories as $key => $category)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $category->name }}</td>
                                        <td>{{ $category->description }}</td>
                                        <td>
                                            <input type="checkbox" id="{{ $category->id }}"  class="update-status" data-id="{{ $category->id }}" switch="success"  data-on="Active" data-off="Inactive" {{ $category->status === 'Active' ? 'checked' : '' }} data-endpoint="{{ route('update-status')}}"/>
                                            <label for="{{ $category->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                        </td>
                                        <td class="action-buttons">
                                            <a href="{{ route('categories.edit', $category->id)}}" class="btn btn-primary btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                            <button data-source="Category" data-endpoint="{{ route('categories.destroy', $category->id)}}"
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
    <x-include-plugins :plugins="['dataTable', 'update-status']"></x-include-plugins>
@endsection
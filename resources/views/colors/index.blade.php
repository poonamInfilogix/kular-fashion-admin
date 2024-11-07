@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Colors</h4>

                        <div class="page-title-right">
                            <a href="{{ route('colors.create') }}" class="btn btn-primary">Add New Color</a>
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
                                        <th>Color Name</th>
                                        <th>Color Short Code</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($colors as $key => $color)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ ucwords($color->color_name) }}</td>
                                            <td>{{ $color->color_code }}</td>
                                            <td>
                                                <input type="checkbox" id="{{ $color->id }}"  class="update-status" data-id="{{ $color->id }}" switch="success"  data-on="Active" data-off="Inactive" {{ $color->status === 'Active' ? 'checked' : '' }} data-endpoint="{{ route('color-status')}}"/>
                                                <label for="{{ $color->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                            </td>
                                            <td class="action-buttons">
                                                <a href="{{ route('colors.edit', $color->id)}}" class="btn btn-primary btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                                <button data-source="Color" data-endpoint="{{ route('colors.destroy', $color->id)}}"
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
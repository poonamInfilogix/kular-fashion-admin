@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Sizes for {{ optional($sizeScale)->size_scale }}</h4>
                        <div class="page-title-right">
                            <a href="{{ route('size-scales.index') }}" class="btn btn-primary"> <i class="bx bx-arrow-back"></i> Back to size scales</a>
                            <a href="{{ route('sizes.create', $sizeScale->id) }}" class="btn btn-primary">Add New Size</a>
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
                                        <th>Size Scale</th>
                                        <th>Size</th>
                                        <th>New Code</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sizes as $key => $size)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ optional($size->sizeScale)->size_scale }}</td>
                                            <td>{{ ucwords($size->size) }}</td>
                                            <td>{{ $size->new_code }}</td>
                                            <td>
                                                <input type="checkbox" id="{{ $size->id }}"  class="update-status" data-id="{{ $size->id }}" switch="success"  data-on="Active" data-off="Inactive" {{ $size->status === 'Active' ? 'checked' : '' }} data-endpoint="{{ route('size-status')}}"/>
                                                <label for="{{ $size->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                            </td>
                                            <td class="action-buttons">
                                                <a href="{{ route('sizes.edit', ['sizeScaleId' => $size->size_scale_id, 'size' => $size->id]) }}" class="btn btn-primary btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                                <button data-source="Size"  data-endpoint="{{ route('sizes.destroy', ['sizeScaleId' => $size->size_scale_id, 'size' => $size->id]) }}"
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
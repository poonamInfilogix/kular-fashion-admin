@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Size Scales</h4>

                        <div class="page-title-right">
                            @if(Auth::user()->can('create size_scales'))
                            <a href="{{ route('size-scales.create') }}" class="btn btn-primary">Add New Size Scale</a>
                            @endif
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
                                        <th>Total Sizes</th>
                                        <th>Status</th>
                                        @canany(['view size','edit size_scales', 'delete size_scales'])
                                        <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sizeScales as $key => $sizeScale)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ ucwords($sizeScale->size_scale) }}</td>
                                            <td>{{ $sizeScale->sizes_count }}</td>
                                            <td>
                                                <input type="checkbox" id="{{ $sizeScale->id }}"  class="update-status" data-id="{{ $sizeScale->id }}" switch="success"  data-on="Active" data-off="Inactive" {{ $sizeScale->status === 'Active' ? 'checked' : '' }} data-endpoint="{{ route('size-scale-status')}}"/>
                                                <label for="{{ $sizeScale->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                            </td>
                                            @canany(['view size', 'edit size_scales', 'delete size_scales'])
                                            <td class="action-buttons">
                                                @if(Auth::user()->can('view size'))
                                                <a href="{{ route('sizes.index', $sizeScale->id) }}" class="btn btn-primary btn-sm">Manage Size</a>
                                                @endif
                                                @if(Auth::user()->can('create size_scales'))
                                                <a href="{{ route('size-scales.edit', $sizeScale->id)}}" class="btn btn-primary btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                                @endif
                                                @if(Auth::user()->can('delete size_scales'))
                                                <button data-source="Size Scale" data-endpoint="{{ route('size-scales.destroy', $sizeScale->id)}}"
                                                    class="delete-btn btn btn-danger btn-sm edit">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                                @endif
                                            </td>
                                            @endcanany
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-include-plugins :plugins="['dataTable', 'update-status']"></x-include-plugins>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
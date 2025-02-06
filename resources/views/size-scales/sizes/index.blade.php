@extends('layouts.app')

@section('title', 'Sizes for ' . optional($sizeScale)->size_scale)
@section('header-button')
    <a href="{{ route('size-scales.index') }}" class="btn btn-primary"> <i class="bx bx-arrow-back"></i> Back to size
        scales</a>
    @if (Auth::user()->can('create size'))
        <a href="{{ route('sizes.create', $sizeScale->id) }}" class="btn btn-primary">Add New Size</a>
    @endif
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
                            <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Size Scale</th>
                                        <th>Size</th>
                                        <th>New Code</th>
                                        <th>Status</th>
                                        @canany(['edit size', 'delete size'])
                                            <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($sizes as $key => $size)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ optional($size->sizeScale)->size_scale }}</td>
                                            <td>{{ ucwords($size->size) }}</td>
                                            <td>{{ $size->new_code }}</td>
                                            <td>
                                                <input type="checkbox" id="{{ $size->id }}" class="update-status"
                                                    data-id="{{ $size->id }}" switch="success" data-on="Active"
                                                    data-off="Inactive" {{ $size->status === 'Active' ? 'checked' : '' }}
                                                    data-endpoint="{{ route('size-status') }}" />
                                                <label class="mb-0" for="{{ $size->id }}" data-on-label="Active"
                                                    data-off-label="Inactive"></label>
                                            </td>
                                            @canany(['edit size', 'delete size'])
                                                <td>
                                                    @if (Auth::user()->can('edit size'))
                                                        <a href="{{ route('sizes.edit', ['sizeScaleId' => $size->size_scale_id, 'size' => $size->id]) }}"
                                                            class="btn btn-primary btn-sm edit py-0 px-1"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if (Auth::user()->can('delete size'))
                                                        <button data-source="Size"
                                                            data-endpoint="{{ route('sizes.destroy', ['sizeScaleId' => $size->size_scale_id, 'size' => $size->id]) }}"
                                                            class="delete-btn btn btn-danger btn-sm edit py-0 px-1">
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
            $('#datatable').DataTable({
                drawCallback: function(settings) {
                    $('#datatable th, #datatable td').addClass('p-0');
                }
            });
        });
    </script>
@endsection

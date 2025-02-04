@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Product Type</h4>

                        <div class="page-title-right">
                            @if(Auth::user()->can('create product_types'))
                            <a href="{{ route('product-types.create') }}" class="btn btn-primary">Add New Product Type</a>
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
                            <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Product Type</th>
                                        <th>Department</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        @canany(['edit product_types', 'delete product_types'])
                                        <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($productTypes as $key => $productType)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $productType->product_type_name }}</td>
                                            <td>
                                                @foreach($productType->productTypeDepartments as $departments)
                                                    {{ $departments->departments->name }}
                                                    @if(!$loop->last), @endif
                                                @endforeach
                                            </td>
                                            <td><img src="{{ asset($productType->image) }}" width="50" height="30" 
                                                onerror="this.onerror=null; this.src='{{ asset(setting('default_product_type_image')) }}';" >
                                            </td>
                                            <td>
                                                <input type="checkbox" id="{{ $productType->id }}"  class="update-status" data-id="{{ $productType->id }}" switch="success"  data-on="Active" data-off="Inactive" {{ $productType->status === 'Active' ? 'checked' : '' }} data-endpoint="{{ route('product-types-status')}}"/>
                                                <label class="mb-0" for="{{ $productType->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                            </td>
                                            @canany(['edit product_types', 'delete product_types'])
                                            <td>
                                                @if(Auth::user()->can('edit product_types'))
                                                <a href="{{ route('product-types.edit', $productType->id)}}" class="btn btn-primary btn-sm edit py-0 px-1"><i class="fas fa-pencil-alt"></i></a>
                                                @endif
                                                @if(Auth::user()->can('delete product_types'))
                                                <button data-source="Product Type" data-endpoint="{{ route('product-types.destroy', $productType->id)}}"
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
                columnDefs: [
                    { type: 'string', targets: 1 } 
                ],
                order: [[1, 'asc']],
                drawCallback: function(settings) {
                    $('#datatable th, #datatable td').addClass('p-0');
                }
            });
        });
    </script>
@endsection
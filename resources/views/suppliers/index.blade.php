@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Suppliers</h4>

                        <div class="page-title-right">
                            @if(Auth::user()->can('create suppliers'))
                            <a href="{{ route('suppliers.create') }}" class="btn btn-primary">Add New Supplier</a>
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
                                        <th>Short Code</th>
                                        <th>Supplier Name</th>
                                        <th>Supplier Ref</th>
                                        <th>Email</th>
                                        <th>Telephone</th>
                                        <th>Status</th>
                                        @canany(['edit suppliers', 'delete suppliers'])
                                        <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($suppliers as $key => $supplier)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $supplier->short_code }}</td>
                                            <td>{{ $supplier->supplier_name }}</td>
                                            <td>{{ $supplier->supplier_ref }}</td>
                                            <td>{{ $supplier->email }}</td>
                                            <td>{{ $supplier->telephone }}</td>
                                            <td>
                                                <input type="checkbox" id="{{ $supplier->id }}"  class="update-status" data-id="{{ $supplier->id }}" switch="success"  data-on="Active" data-off="Inactive" {{ $supplier->status === 'Active' ? 'checked' : '' }} data-endpoint="{{ route('supplier-status')}}"/>
                                                <label for="{{ $supplier->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                            </td>
                                            @canany(['edit suppliers', 'delete suppliers'])
                                            <td class="action-buttons">
                                                @if(Auth::user()->can('edit suppliers'))
                                                <a href="{{ route('suppliers.edit', $supplier->id)}}" class="btn btn-primary btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                                @endif
                                                @if(Auth::user()->can('delete suppliers'))
                                                <button data-source="Supplier" data-endpoint="{{ route('suppliers.destroy', $supplier->id)}}"
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
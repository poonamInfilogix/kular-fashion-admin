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
                            <a href="{{ url('download-brand-sample') }}"
                                class="btn btn-primary primary-btn btn-md me-2"><i class="bx bx-download"></i> Download Brands Sample </a>
                            <div class="d-inline-block me-2">
                                <form id="importForm" action="{{ route('import.brands') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <label for="fileInput" class="btn btn-primary primary-btn btn-md mb-0">
                                        <i class="bx bx-cloud-download"></i> Import Brands
                                        <input type="file" id="fileInput" name="file" accept=".csv, .xlsx" style="display:none;">
                                    </label>
                                </form>
                            </div>
                            <a href="{{ route('brands.create') }}" class="btn btn-primary"><i class="bx bx-plus"></i> Add New Brand</a>
                        </div>

                    </div>
                    
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />
                    @if (session('import_errors'))
                        <div class="alert alert-danger">
                            <ul>
                                @foreach (session('import_errors') as $error)
                                    <li>{{ $error['message'] }}</li> <!-- Assuming each error has a 'message' key -->
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Brand Name</th>
                                        <th>Image</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($brands as $key => $brand)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $brand->name }}</td>
                                            <td><img src="{{ asset($brand->image) }}" width="50" height="50" 
                                                onerror="this.onerror=null; this.src='{{ asset(setting('default_brand_image')) }}';" >
                                            </td>
                                            <td>
                                                <input type="checkbox" id="{{ $brand->id }}"  class="update-status" data-id="{{ $brand->id }}" switch="success"  data-on="Active" data-off="Inactive" {{ $brand->status === 'Active' ? 'checked' : '' }} data-endpoint="{{ route('brand-status')}}"/>
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
    <script>
            $(document).ready(function() {
                $('#importButton').on('click', function() {
                    $('#fileInput').click();
                });

                $('#fileInput').on('change', function(event) {
                    var file = $(this).prop('files')[0];
                    if (file) {
                        var fileType = file.type;
                        if (fileType === 'text/csv' || fileType === 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet') {
                            $('#importForm').submit();
                        } else {
                            alert('Please select a valid CSV or XLSX file.');
                        }
                    }
                });
            });
        </script>
@endsection
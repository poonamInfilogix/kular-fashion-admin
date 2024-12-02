@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Products</h4>

                        <div class="page-title-right">
                            <a href="{{ route('export.csv') }}" class="btn btn-primary primary-btn btn-md me-1"><i class="bx bx-download"></i> Download Product Configuration File</a>
                            
                            <a href="{{ route('products.create') }}" class="btn btn-primary">
                                <i class="bx bx-plus fs-16"></i>
                                Add New Product
                            </a>
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
                            <table id="product-table" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Article Code</th>
                                        <th>Manufacture Code</th>
                                        <th>Department</th>
                                        <th>Product Type</th>
                                        <th>Brand</th>
                                    </tr>
                                </thead>

                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <x-include-plugins :plugins="['dataTable', 'update-status']"></x-include-plugins>
    <script type="text/javascript">
        $(document).ready(function() {
            var table = $('#product-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('get.products') }}',
                    data: function (d) {
                        d.page = Math.floor(d.start / d.length) + 1;
                    }
                },
                columns: [
                    { title: "Article Code", data: 'article_code' },
                    { title: "Manufacture Code", data: 'manufacture_code' },
                    { title: "Department", data: 'department.name' },
                    { title: "Brand", data: 'brand.name' },
                    { title: "Product Type",data: 'product_type.product_type_name' },
                    { 
                        title: "Actions", 
                        data: null, 
                        render: function (data, type, row) { 
                        return ` <a href="{{ route('products.show', ':id') }}" class="btn btn-secondary btn-sm"> 
                                    <i class="fas fa-eye"></i> 
                                </a> 
                                <a href="{{ route('products.edit', ':id') }}" class="btn btn-primary btn-sm edit"> 
                                    <i class="fas fa-pencil-alt"></i> 
                                </a> 
                                <button data-source="product" data-endpoint="{{ route('products.destroy', ':id') }}" class="delete-btn btn btn-danger btn-sm"> <i class="fas fa-trash-alt"></i> </button>
                            `.replace(/:id/g, row.id); 
                        } 
                    }
                ],
                order: [[0, 'desc']]
            });
        });
    </script>
@endsection


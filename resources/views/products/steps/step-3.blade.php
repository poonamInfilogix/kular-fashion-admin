@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Step 3</h4>

                        <div class="page-title-right">
                            <a href="{{ route('products.create.step-2') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to Step 2</a>
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
                            <form action="{{ route('products.create.step-3') }}" method="post" enctype="multipart/form-data">
                                @csrf

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Size</th>
                                            @foreach($sizes as $size)
                                                <th>{{ $size->size }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($savedColors as $color)
                                            <tr>
                                                <th>{{ $color['color_name'] }} ({{ $color['color_code'] }})</th>
                                                @foreach($sizes as $key => $size)
                                                    <td><input type="number" name="quantity[{{ $color['id'] }}][{{ $size->id }}]" value="0" class="form-control"></td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <th>MRP</th>
                                            @foreach($sizes as $size)
                                                <td><input type="number" name="mrp[{{ $size->id }}]" value="{{ $savingProduct->mrp }}" class="form-control"></td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                                <button type="button" class="btn btn-secondary" id="add-variant-btn">Add new variant</button>
                                <button class="btn btn-primary">Submit</button>
                            </form>    
                            
                        </div>    
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>

    <div class="modal fade" id="addVariantModal" tabindex="-1" aria-labelledby="addVariantModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addVariantModalLabel">Add New Variant</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addVariantForm">
                        <div class="mb-3">
                            <label for="supplier_color_code" class="form-label">Supplier Color Code</label>
                            <input type="text" id="supplier_color_code" class="form-control" placeholder="Enter Supplier Color Code" required>
                            <div id="supplierColorCodeError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="color_select" class="form-label">Select Color</label>
                            <select id="color_select" class="form-control" required>
                                <option value="" disabled selected>Select Color</option>
                                @foreach($colors as $color)
                                    <option value="{{ $color->id }}">{{ $color->color_name }} ({{ $color->color_code }})</option>
                                @endforeach
                            </select>
                            <div id="colorSelectError" class="text-danger"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" id="saveVariantBtn" class="btn btn-primary">Save Variant</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            $(function(){
                $('#add-variant-btn').click(function() {
                    $('#addVariantModal').modal('show');
                });
            })
            $(document).ready(function() {
                $('#saveVariantBtn').on('click', function() {
                    $('#supplierColorCodeError').text('');
                    $('#colorSelectError').text('');

                    let supplierColorCode = $('#supplier_color_code').val().trim();
                    let selectedColor = $('#color_select').val();

                    if (!supplierColorCode) {
                        $('#supplierColorCodeError').text('Please enter the Supplier Color Code.');
                    }
                    if (!selectedColor) {
                        $('#colorSelectError').text('Please select a color.');
                    }

                    if (supplierColorCode && selectedColor) {
                        $.ajax({
                            url: '/add-variant',
                            method: 'POST',
                            data: {
                                supplier_color_code: supplierColorCode,
                                color_id: selectedColor,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(data) {
                                alert('Variant saved successfully!');
                                $('#addVariantModal').modal('hide');
                            },
                            error: function() {
                                alert('An error occurred while saving the variant.');
                            }
                        });
                    }
                });
            });
        </script>
    @endpush

@endsection
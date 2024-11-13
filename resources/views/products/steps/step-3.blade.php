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
                                        <tr id="sizeHeader">
                                            <th>Size</th>
                                            @foreach($sizes as $size)
                                                <th data-size-id="{{$size->id}}">{{ $size->size }}</th>
                                            @endforeach

                                            <th @class(['actionColumn', 'd-none' => count($savedColors)<= 1])>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php 
                                            if(isset($savingProduct->variantData)){
                                                $quantityData = $savingProduct->variantData->quantity;
                                            }
                                        @endphp
                                        @foreach($savedColors as $color)
                                            <tr data-id="rm-{{$color['id']}}">
                                                <th>{{ $color['color_name'] }} ({{ $color['color_code'] }})</th>
                                                @foreach($sizes as $key => $size)
                                                    <td><input type="number" name="quantity[{{ $color['id'] }}][{{ $size->id }}]" value="{{ isset($quantityData) ? $quantityData[$color['id']] : old('example', '0') }}" class="form-control"></td>
                                                @endforeach
                                                
                                                <td @class(['actionColumn', 'd-none' => count($savedColors)<= 1])>
                                                    <a href="{{ route('products.remove-variant', $color['id']) }}" class="btn btn-danger">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </a>
                                                </td>
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
                $('#saveVariantBtn').on('click', function () {
                    $('#supplierColorCodeError').text('');
                    $('#colorSelectError').text('');

                    let formData = {
                        supplier_color_code: $('#supplier_color_code').val(),
                        color_select: $('#color_select').val(),
                        _token: '{{ csrf_token() }}' 
                    };

                    $.post('/add-variant', formData)
                        .done(function (response) {
                            if (response.success) {
                                $('#addVariantModal').modal('hide'); 
                                $('#addVariantForm')[0].reset();
                                $('.actionColumn').removeClass('d-none');

                                let $tbody = $('table tbody');
                                let $sizeHeader = $('#sizeHeader');

                                let sizes = $sizeHeader.find('th')
                                    .slice(1, -1)  // Skip the first "Size" header and remove the last header
                                    .map(function() { return $(this).attr('data-size-id'); })
                                    .get();

                                let $newRow = $('<tr></tr>');
                                let $newTh = $('<th></th>').text(`${response.data.color_name} (${response.data.color_code})`);
                                $newRow.append($newTh);

                                $.each(sizes, function(index, size) {
                                    let $newTd = $('<td></td>');
                                    $newTd.html(`<input type="number" name="quantity[${response.data.color_id}][${size}]" value="0" class="form-control">`);
                                    $newRow.append($newTd);
                                });

                                // Add delete button as the last cell
                                let $deleteTd = $('<td></td>');
                                $deleteTd.html(`
                                    <a href="{{ route('products.remove-variant','') }}/${response.data.color_id}" class="btn btn-danger"> 
                                        <i class="fas fa-trash-alt"></i>
                                    </a>
                                `);
                                $newRow.append($deleteTd);

                                // Insert the new row at the second position or append if only one row exists
                                if ($tbody.children().length > 1) {
                                    $tbody.children().eq(1).before($newRow);
                                } else {
                                    $tbody.append($newRow);
                                }
                            }
                        })
                        .fail(function (xhr) {
                            let errors = xhr.responseJSON.errors;
                            if (errors.supplier_color_code) {
                                $('#supplierColorCodeError').text(errors.supplier_color_code[0]);
                            }
                            if (errors.color_select) {
                                $('#colorSelectError').text(errors.color_select[0]);
                            }
                        });
                });
            });
        </script>
    @endpush

@endsection
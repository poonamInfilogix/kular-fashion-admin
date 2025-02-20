@extends('layouts.app')

@section('title', 'Step 2')
@section('header-button')
    <a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to products</a>
@endsection

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="mb-2 d-flex gap-1">
                                <h5 class="card-title">Article Code: </h5>
                                <p class="card-text"> {{ $savingProduct->article_code }}</p>
                            </div>    
                        </div>
                        @if($savingProduct->short_description)
                        <div class="col-sm-6 col-md-6">
                            <div class="mb-2 d-flex gap-1">
                                <h5 class="card-title">Short Description: </h5>
                                    <p class="card-text"> {{ $savingProduct->short_description }}</p>
                            </div>    
                        </div>
                        @endif
                        <div class="col-sm-6 col-md-6">
                            <div class="mb-2 d-flex gap-1">
                                <h5 class="card-title">Manufacture Code: </h5>
                                <p class="card-text"> {{ $savingProduct->manufacture_code }}</p>
                            </div>    
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="mb-2 d-flex gap-1">
                                <h5 class="card-title">MRP: </h5>
                                <p class="card-text"> {{ $savingProduct->mrp }}</p>
                            </div>    
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="mb-2 d-flex gap-1">
                                <h5 class="card-title">Brand: </h5>
                                <p class="card-text"> {{ $brand->name }}</p>
                            </div>    
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="mb-2 d-flex gap-1">
                                <h5 class="card-title">Size Scale: </h5>
                                <p class="card-text">{{ $sizeScale->size_scale }}</p>
                            </div>    
                        </div>
                    </div>   

                    <div class="card">
                        <div class="card-body">  
                            <form action="{{ route('products.create.step-2') }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-sm-12 col-md-8">
                                        <div class="row">
                                            <div class="col-sm-6 col-md-4">
                                                <div class="mb-3">
                                                    <x-form-input name="supplier_color_code[0]" value="{{ $savingProduct->supplier_color_codes[0] ?? '' }}" label="Supplier Color Code" placeholder="Enter Supplier Color Code" required/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="mb-3">
                                                    <x-form-input name="supplier_color_name[0]" value="{{ $savingProduct->supplier_color_names[0] ?? '' }}" label="Supplier Color Name" placeholder="Enter Supplier Color Name" required/>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-md-4">
                                                <div class="mb-3">
                                                    <label for="color">Select Color <span class="text-danger">*</span></label>
        
                                                    <select name="colors[0]" id="color" @class(["form-control", "is-invalid" =>  $errors->has('colors.0')])>
                                                        <option value="" selected>Select Color</option> 
                                                        @foreach($colors as $color)
                                                            <option value="{{ $color->id }}" {{ old('colors[0]', isset($savingProduct->colors[0]) ? $savingProduct->colors[0] : null) == $color->id ? 'selected' : '' }}>
                                                                {{ $color->name }} ({{ $color->code }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('colors.0')
                                                        <span class="invalid-feedback">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-sm-2 col-md-2">
                                        <div class="mb-3">
                                            <label for="color">Size Range(Min) <span class="text-danger">*</span></label>
                                            <select name="size_range_min" id="size_range_min" class="form-control{{ $errors->has('color') ? ' is-invalid' : '' }}">
                                                @foreach($sizes as $size)
                                                    <option value="{{ old('size_range_min', $size->id) }}">
                                                        {{ $size->size }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('size_range_min')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-sm-2 col-md-2">
                                        <div class="mb-3">
                                            <label for="size_range_max">Size Range(Max) <span class="text-danger">*</span></label>
                                            <select name="size_range_max" id="size_range_max" class="form-control{{ $errors->has('size_range_max') ? ' is-invalid' : '' }}">
                                                @foreach($sizes as $index => $size)
                                                    <option value="{{ old('size_range_max', $size->id) }}" {{ $loop->last ? 'selected' : '' }}>
                                                        {{ $size->size }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('size_range_max')
                                                <span class="invalid-feedback">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    
                                    <div class="col-12" id="color-fields">
                                        @if(isset($savingProduct->supplier_color_codes))
                                            @foreach ($savingProduct->supplier_color_codes as $index => $variant)
                                                @if($index !== 0)
                                                <div class="color-field" id="color-field-{{ $index }}">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="row">
                                                                <div class="col-sm-6 col-md-4">
                                                                    <div class="mb-3">
                                                                        <x-form-input 
                                                                            name="supplier_color_code[{{ $index }}]" 
                                                                            value="{{ $variant ?? '' }}" 
                                                                            label="Supplier Color Code" 
                                                                            placeholder="Enter Supplier Color Code" 
                                                                            required
                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 col-md-4">
                                                                    <div class="mb-3">
                                                                        <x-form-input 
                                                                            name="supplier_color_name[{{ $index }}]" 
                                                                            value="{{ $variant ?? '' }}" 
                                                                            label="Supplier Color Name" 
                                                                            placeholder="Enter Supplier Color Name" 
                                                                            required
                                                                        />
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6 col-md-4">
                                                                    <div class="mb-3">
                                                                        <label for="colors-{{ $index }}">Select Color <span class="text-danger">*</span></label>
                                                                        <select name="colors[{{ $index }}]" id="colors-{{ $index }}" class="form-control{{ $errors->has("colors.$index") ? ' is-invalid' : '' }}">
                                                                            <option value=""  {{ old("colors.$index") === null ? 'selected' : '' }}>Select Color</option>
                                                                            @foreach($colors as $color)
                                                                                <option value="{{ $color->id }}" @selected(old("colors[$index]", $savingProduct->colors[$index] ?? '') == $color->id)
                                                                                    {{ old("colors[$index]", $savingProduct->colors[$index] ?? '') }}>
                                                                                    {{ $color->name }} ({{ $color->code }})
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                        @error("colors.$index")
                                                                            <span class="invalid-feedback">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-md-3">
                                                            <button type="button" class="btn btn-danger remove-color-btn mt-4" data-id="{{ $index }}">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endif
                                            @endforeach
                                        @endif
                                    </div>

                                    
                                    <div class="row mb-2">
                                        <div class="col-lg-6 mb-2">
                                            <button type="button" id="add-color-btn" class="btn btn-secondary me-2">Add New Color</button>
                                            
                                            <button type="submit" class="btn btn-primary w-md">Continue</button>
                                        </div>
                                    </div>
                                </div>    
                            </form>      
                        </div>    
                    </div>
                </div>
            </div>
        </div>

    <x-include-plugins :plugins="['chosen']"></x-include-plugins>
    @push('scripts')
    <script>
        $(document).ready(function () {
            $('form').on('keypress', function (e) {
                if (e.which === 13) { 
                    e.preventDefault();
                    return false; 
                }
            });
        });
        $(function(){
            var colorIndex = {{ isset($savingProduct->supplier_color_codes) ? count($savingProduct->supplier_color_codes)-1 : 1 }};


            $('#add-color-btn').click(function() {
                colorIndex++;

                var newColorField = `
                    <div class="color-field" id="color-field-${colorIndex}">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="row">
                                    <div class="col-sm-6 col-md-4">
                                        <div class="mb-3">
                                            <x-form-input name="supplier_color_code[${colorIndex}]" value="" label="Supplier Color Code" placeholder="Enter Supplier code" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="mb-3">
                                            <x-form-input name="supplier_color_name[${colorIndex}]" value="" label="Supplier Color Name" placeholder="Enter Supplier code" required/>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-4">
                                        <div class="mb-3">
                                            <label for="colors-${colorIndex}">Select Color <span class="text-danger">*</span></label>
                                            <select name="colors[${colorIndex}]" id="colors-${colorIndex}" class="form-control">
                                                <option value="" disabled selected>Select Color</option>
                                                @foreach($colors as $color)
                                                    <option value="{{ $color->id }}">
                                                        {{ $color->name }} ({{ $color->code }})
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-md-3">
                                <button type="button" class="btn btn-danger remove-color-btn mt-4" data-id="${colorIndex}">Remove</button>
                            </div>
                        </div>
                    </div>`;

                $('#color-fields').append(newColorField);
                $('#colors-' + colorIndex).chosen({ width: '100%' });
            });

            $(document).on('click', '.remove-color-btn', function() {
                var id = $(this).data('id');
                $('#color-field-' + id).remove();
            });

            $('#color').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Color'
            });

            $('select[id^="colors"]').chosen({
                width: '100%',
                placeholder_text_multiple: 'Select Color'
            });
            
            $('#size_range_min').val($('#size_range_min option:first').val()).trigger('chosen:updated');

            $('#size_range_min').on('change', function() {
                var minSizeId = parseInt($(this).val());

                $('#size_range_max').prop('disabled', false).trigger('chosen:updated');
                $('#size_range_max option').show();

                $('#size_range_max option').each(function() {
                    var maxSizeId = parseInt($(this).val());

                    if (maxSizeId < minSizeId) {
                        $(this).hide();
                    }
                });

                $('#size_range_max').trigger('chosen:updated');
                var visibleOptions = $('#size_range_max option:visible');
                
                if (visibleOptions.length > 0) {
                    var lastVisibleOptionValue = visibleOptions.last().val();
                    $('#size_range_max').val(lastVisibleOptionValue).trigger('chosen:updated');
                } else {
                    var lastOptionValue = $('#size_range_max option:last').val();
                    $('#size_range_max').val(lastOptionValue).trigger('chosen:updated');
                }
            });

            var minimumSize = {{ isset($savingProduct->size_range_min) ? $savingProduct->size_range_min : '0' }};
            var maximumSize = {{ isset($savingProduct->size_range_max) ? $savingProduct->size_range_max : '0' }};
            var minSizeId = parseInt(minimumSize);
           
            setTimeout(() => {
                $('#size_range_min option[value="'+minimumSize+'"]').prop("selected", true);
                $('#size_range_max option[value="'+maximumSize+'"]').prop("selected", true);
            }, 1000);

            $('#size_range_max').prop('disabled', false).trigger('chosen:updated');
            $('#size_range_max option').show();

            $('#size_range_max option').each(function() {
                var maxSizeId = parseInt($(this).val());
                if (maxSizeId < minSizeId) {
                    $(this).hide();
                }
            });

            $('#size_range_max').trigger('chosen:updated');
            var visibleOptions = $('#size_range_max option:visible');

            if (visibleOptions.length > 0) {
                var lastVisibleOptionValue = visibleOptions.last().val();
                $('#size_range_max').val(lastVisibleOptionValue).trigger('chosen:updated');
            } else {
                var lastOptionValue = $('#size_range_max option:last').val();
                $('#size_range_max').val(lastOptionValue).trigger('chosen:updated');
            }
        });
        </script>
    @endpush
@endsection
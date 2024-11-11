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
                                        @foreach($colors as $color)
                                            <tr>
                                                <td>{{ $color['color_name'] }} ({{ $color['color_code'] }})</td>
                                                @foreach($sizes as $key => $size)
                                                    <td><input type="number" name="quantity[]" value="0" class="form-control"></td>
                                                @endforeach
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td>MRP</td>
                                            @foreach($sizes as $size)
                                                <td><input type="number" name="mrp" value="{{ $savingProduct->mrp }}" class="form-control"></td>
                                            @endforeach
                                        </tr>
                                    </tbody>
                                </table>
                                <button class="btn btn-primary">Submit</button>

                            </form>    
                            
                        </div>    
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row -->
        </div> <!-- container-fluid -->
    </div>

@endsection
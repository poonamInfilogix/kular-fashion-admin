@extends('layouts.app')

@section('title', 'Update Product Type')
@section('header-button')
<a href="{{ route('product-types.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to all product types</a>
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
                            <form action="{{ route('product-types.update', $productType->id) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                @include('product-types.form')
                            </form>    
                        </div>    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-include-plugins :plugins="['chosen']"></x-include-plugins>
    <script>
        $(function(){
            var selectedDeparments =  @json($selectedDeparments);
            $('#department_id').val(selectedDeparments).trigger('chosen:updated');
        });
    </script> 
@endsection
   
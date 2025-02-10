@extends('layouts.app')

@php
    $isEditing = true;
@endphp

@section('title', 'Edit Article '.$product->article_code)
@section('header-button')
    <a href="{{ route('products.edit.web-configuration', $product->id) }}" class="btn btn-primary"><i class="bx bx-landscape"></i> Product Web Configuration</a>
    <a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to products</a>
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
                            <form action="{{ route('products.update-step-1', $product->id) }}" method="post" enctype="multipart/form-data">
                                @method('PUT')
                                @csrf
                                @include('products.steps.step-1-form')
                            </form>    
                        </div>    
                    </div>
                </div>
            </div>
        </div> 
    </div>
<script>
    $(document).ready(function(){
        var productTags = @json($productTags); 
        setTimeout(() => {
            $('#tag_id').val(productTags).trigger('chosen:updated');
        }, 1000);
    });
</script>
@endsection
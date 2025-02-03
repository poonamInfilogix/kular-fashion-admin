@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    {{-- <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Create a new product</h4>

                        <div class="page-title-right">
                            <a href="{{ route('products.index') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to products</a>
                        </div>

                    </div> --}}
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                    <div class="card">
                        <div class="card-body">
                            <form action="{{ route('products.save-step-1') }}" method="post" enctype="multipart/form-data">
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
    $(document).ready(function () {
        function checkManufactureCodeExists(manufactureCode) {
            return $.ajax({
                url: `/check-manufacture-code/${manufactureCode}`,
                type: 'GET',
                dataType: 'json',
            });
        }

        $('form').on('submit', function (e) {
            e.preventDefault();

            let manufactureCode = $('#manufacture_code').val();
            if(!manufactureCode){
                $('form')[0].submit();
            }

            checkManufactureCodeExists(manufactureCode).done(function(response) {
                if (response.exists) {
                    swal({
                        title: 'Manufacture Code Exists',
                        text: 'The Manufacture Code you entered already exists. Do you want to continue with the same code?',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Continue',
                        cancelButtonText: 'Enter New Code',
                    }, function(isConfirm) {
                        if (isConfirm) {
                            $('form')[0].submit();
                        } else {
                            $('#manufacture_code').val('');
                            $('#manufacture_code').focus();
                        }
                    });
                } else {
                    $('form')[0].submit();
                }
            }).fail(function(xhr, status, error) {
                console.error('Error checking manufacture code:', error);
            });
        });
    });
</script>
@endsection

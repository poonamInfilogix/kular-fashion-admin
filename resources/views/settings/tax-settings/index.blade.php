@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Tax Settings</h4>

                        <div class="page-title-right">
                            <a href="{{ route('tax-settings.create') }}" class="btn btn-primary">Add New Tax</a>
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
                            <table id="dataTable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Taxes (in %)</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($taxes as $key => $tax)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $tax->tax }}</td>
                                            <td>
                                                <input type="checkbox" id="{{ $tax->id }}" class="update-status" data-id="{{ $tax->id }}" switch="success" data-on="Active" data-off="Inactive" {{ $tax->status === 0 ? 'checked' : '' }} data-endpoint="{{ route('tax-status') }}" />
                                                <label for="{{ $tax->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                            </td>
                                            <td class="action-buttons">
                                                <a href="{{ route('tax-settings.edit', $tax->id)}}" class="btn btn-primary btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                                <button data-source="tax" data-endpoint="{{ route('tax-settings.destroy', $tax->id)}}"
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
                </div>
            </div>
        </div>
    </div>
    <x-include-plugins :plugins="['dataTable']"></x-include-plugins>
    
    <script>
        $(function() {
            $('#dataTable').DataTable();

            $('.update-status').change(function() {
                var status = $(this).prop('checked') ? '0' : '1';
                var id = $(this).data('id');
                let statusUpdateApiEndpoint = $(this).data('endpoint');
                const toggleButton = $(this);
                swal({
                    title: "Are you sure?",
                    text: `You really want to change this?`,
                    type: "warning",
                    showCancelButton: true,
                    closeOnConfirm: false,
                }, function(isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            type: "POST",
                            dataType: "json",
                            url: statusUpdateApiEndpoint,
                            data: {
                                'status': status,
                                'id': id,
                                '_token': '{{ csrf_token() }}' 
                            },
                            success: function(response) {
                                if(response.success){
                                    swal({
                                        title: "Success!",
                                        text: response.message,
                                        type: "success",
                                        showConfirmButton: false
                                    }) 
    
                                    setTimeout(() => {
                                        location.reload();
                                    }, 2000);
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error updating status:', error);
                            }
                        });
                    } else {
                        console.log('sasd');
                        toggleButton.prop('checked', !toggleButton.prop('checked')); 
                    }
                });
            });
        });
    </script>
@endsection
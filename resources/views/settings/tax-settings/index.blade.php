@extends('layouts.app')

@section('title', 'Tax Settings')
@section('header-button')
    @if (Auth::user()->can('create tax'))
        <a href="{{ route('tax-settings.create') }}" class="btn btn-primary">Add New Tax</a>
    @endif
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
                            <table id="dataTable" class="table table-bordered table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="p-1">#</th>
                                        <th class="p-1">Tax (in %)</th>
                                        <th class="p-1">Status</th>
                                        @canany(['edit tax', 'delete tax'])
                                            <th class="p-1">Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($taxes as $key => $tax)
                                        <tr>
                                            <td class="p-1">{{ ++$key }}</td>
                                            <td class="p-1">
                                                {{ $tax->tax }}
                                                @if ($tax->is_default)
                                                    <span class="badge rounded-pill bg-success">Default</span>
                                                @endif
                                            </td>
                                            <td class="p-1">
                                                <input type="checkbox" id="{{ $tax->id }}" class="update-status"
                                                    data-id="{{ $tax->id }}" switch="success" data-on="Active"
                                                    data-off="Inactive" {{ $tax->status === 1 ? 'checked' : '' }}
                                                    data-endpoint="{{ route('tax-status') }}" />
                                                <label class="mb-0" for="{{ $tax->id }}" data-on-label="Active"
                                                    data-off-label="Inactive"></label>
                                            </td>
                                            @canany(['edit tax', 'delete tax'])
                                                <td class="p-1">
                                                    @if (Auth::user()->can('edit tax'))
                                                        <a href="{{ route('tax-settings.edit', $tax->id) }}"
                                                            class="btn btn-primary btn-sm edit py-0 px-1"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if (Auth::user()->can('delete tax'))
                                                        <button data-source="tax"
                                                            data-endpoint="{{ route('tax-settings.destroy', $tax->id) }}"
                                                            class="delete-btn btn btn-danger btn-sm edit py-0 px-1">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    @endif
                                                </td>
                                            @endcanany
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
                var status = $(this).prop('checked') ? '1' : '0';
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
                                if (response.success) {
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

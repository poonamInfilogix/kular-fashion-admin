@extends('layouts.app')


@section('title', 'Coupons and Discounts')
@section('header-button')
    <a href="{{ route('coupons-discount.create') }}" class="btn btn-primary">Add New Coupon</a>
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
                            <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Code</th>
                                        <th>Type</th>
                                        <th>Type Value</th>
                                        <th>Minimum Amount</th>
                                        <th>Minimum Item </th>
                                        <th>Usage Limit</th>
                                        <th>Limit</th>
                                        <th>Start Date</th>
                                        <th>Expire Date</th>
                                      
                                        @canany(['edit departments', 'delete departments'])
                                            <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($coupons as $key => $coupon)
                                    <tr>
                                        <td>{{ ++$key }}</td>
                                        <td>{{ $coupon->code }}</td>
                                        <td>{{ $coupon->type }}</td>
                                        <td>{{ $coupon->non_numeric_value ?? $coupon->numeric_value }}</td>
                                        <td>{{ $coupon->min_amount }}</td>
                                        <td>{{ $coupon->min_items_count ?? '' }}</td>
                                        <td>{{ $coupon->usage_limit }}</td> 
                                        <td>{{ $coupon->used_count }}</td>
                                        <td>{{  isset($coupon->starts_at) ? date('d-m-Y', strtotime($coupon->starts_at )) : ''}}</td>
                                        <td>{{  isset($coupon->expires_at) ?date('d-m-Y', strtotime($coupon->expires_at  )) : ''}}</td>
                                        @canany(['edit brands', 'delete brands'])
                                            <td>
                                                @if (Auth::user()->can('edit brands'))
                                                    <a href="{{ route('coupons-discount.edit', $coupon->id) }}"
                                                        class="btn btn-primary btn-sm edit py-0 px-1"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                @endif
                                                @if (Auth::user()->can('delete brands'))
                                                    <button data-source="Brand"
                                                        data-endpoint="{{ route('coupons-discount.destroy', $coupon->id) }}"
                                                        class="delete-btn btn btn-danger btn-sm py-0 px-1">
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
    <x-include-plugins :plugins="['dataTable', 'update-status']"></x-include-plugins>

    <script>
        $(document).ready(function() {
            $('#datatable').DataTable({
                columnDefs: [{
                    type: 'string',
                    targets: 1
                }],
                order: [
                    [0, 'asc']
                ],
                drawCallback: function(settings) {
                    $('#datatable th, #datatable td').addClass('p-0');
                }
            });
        });

        // $('#datatable').DataTable({
        //      columnDefs: [{
        // //             type: 'string',
        // //             targets: 1
        // //         }],
        //     ordering: false,
        //     drawCallback: function(settings) {
        //             $('#datatable th, #datatable td').addClass('p-0');
        //         }
        // });
    </script>
@endsection

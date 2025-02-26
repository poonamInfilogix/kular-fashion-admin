@extends('layouts.app')

@section('title', 'Coupon and Discounts')
@section('header-button')
    <a href="{{ route('coupons.create') }}" class="btn btn-primary">Add New Coupon</a>
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
                                        <th>Status</th>
                                        <th>Start Date</th>
                                        <th>Expire Date</th>
                                      
                                        @canany(['edit coupons', 'delete coupons'])
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
                                        <td>
                                            @if($coupon->status == 1)
                                            <span class="badge bg-success">Active</span>
                                        @elseif($coupon->status == 0)
                                            <span class="badge bg-danger">Inactive</span>
                                        @else
                                            <span class="badge bg-secondary">Expired</span>
                                        @endif
                                        </td>
                                        <td>{{  isset($coupon->start_date) ? date('d-m-Y', strtotime($coupon->start_date)) : ''}}</td>
                                        <td>{{  isset($coupon->expire_date) ? date('d-m-Y', strtotime($coupon->expire_date)) : ''}}</td>
                                        @canany(['edit coupons', 'delete coupons'])
                                            <td>
                                                @if (Auth::user()->can('edit coupons'))
                                                    <a href="{{ route('coupons.edit', $coupon->id) }}"
                                                        class="btn btn-primary btn-sm edit py-0 px-1"><i
                                                            class="fas fa-pencil-alt"></i></a>
                                                @endif
                                                @if (Auth::user()->can('delete coupons'))
                                                    <button data-source="Brand"
                                                        data-endpoint="{{ route('coupons.destroy', $coupon->id) }}"
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

@extends('layouts.app')


@section('title', 'Coupons and Discounts')
@section('header-button')
    @if (Auth::user()->can('create departments'))
        <a href="{{ route('coupons-discounts.create') }}" class="btn btn-primary">Add New Coupon Discounts</a>
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
                            <table id="datatable" class="table table-bordered table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        {{-- Start Active Date --}}
                                        <th>From Date</th>
                                        <th>To Date</th>
                                          {{-- End Active Date --}}
                                        <th>Limit</th>
                                        <th>Status</th>
                                        @canany(['edit departments', 'delete departments'])
                                            <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                   
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
                    [1, 'asc']
                ],
                drawCallback: function(settings) {
                    $('#datatable th, #datatable td').addClass('p-0');
                }
            });
        });
    </script>
@endsection

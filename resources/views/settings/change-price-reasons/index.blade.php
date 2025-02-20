@extends('layouts.app')

@section('title', 'Manage Change Price Reasons')
@section('header-button')
    @if (Auth::user()->can('create price reasons'))
        <a href="{{ route('change-price-reasons.create') }}" class="btn btn-primary">Add New Reason</a>
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
                                        <th class="p-1">Reason</th>
                                        @canany(['edit price reasons', 'delete price reasons'])
                                            <th class="p-1">Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reasons as $key => $reason)
                                        <tr>
                                            <td class="p-1">{{ ++$key }}</td>
                                            <td class="p-1">{{ $reason->name }}</td>
                                            @canany(['edit price reasons', 'delete price reasons'])
                                                <td class="p-1">
                                                    @if (Auth::user()->can('edit price reasons'))
                                                        <a href="{{ route('change-price-reasons.edit', $reason->id) }}"
                                                            class="btn btn-primary btn-sm edit  py-0 px-1"><i
                                                                class="fas fa-pencil-alt"></i></a>
                                                    @endif
                                                    @if (Auth::user()->can('delete price reasons'))
                                                        <button data-source="reason"
                                                            data-endpoint="{{ route('change-price-reasons.destroy', $reason->id) }}"
                                                            class="delete-btn btn btn-danger btn-sm edit  py-0 px-1">
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
        });
    </script>
@endsection

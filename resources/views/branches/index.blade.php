@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Branches List</h4>
                        <div class="page-title-right">
                            @if(Auth::user()->can('create branches'))
                            <a href="{{ route('branches.create') }}" class="btn btn-primary">Add New Branch</a>
                            @endif
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
                            <table id="datatable" class="table table-bordered dt-responsive  nowrap w-100">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Short Name</th>
                                    <th>Email</th>
                                    <th>Contact</th>
                                    <th>Location</th>
                                    <th>Status</th>
                                    @canany(['edit branches', 'delete branches'])
                                    <th>Action</th>
                                    @endcanany
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($branches as $key => $branch)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ ucwords($branch->name) }}</td>
                                            <td>{{ ucwords($branch->short_name) }}</td>
                                            <td>{{ $branch->email }}</td>
                                            <td>{{ $branch->contact }}</td>
                                            <td>{{ $branch->location }}</td>
                                            <td>
                                                <input type="checkbox" id="{{ $branch->id }}"  class="update-status" data-id="{{ $branch->id }}" switch="success"  data-on="Active" data-off="Inactive" {{ $branch->status === 'Active' ? 'checked' : '' }} data-endpoint="{{ route('branch-status')}}"/>
                                                <label for="{{ $branch->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                            </td>
                                            @canany(['edit branches', 'delete branches'])
                                            <td class="action-buttons">
                                                @if(Auth::user()->can('edit branches'))
                                                    <a href="{{ route('branches.edit', $branch->id)}}" class="btn btn-primary btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                                @endif
                                                @if(Auth::user()->can('delete branches'))
                                                    @if($branch->id> 1)
                                                    <button data-source="branch" data-endpoint="{{ route('branches.destroy', $branch->id)}}"
                                                        class="delete-btn btn btn-danger btn-sm edit">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    @endif
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
            $('#datatable').DataTable();
        });
    </script>
@endsection
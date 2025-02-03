@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">

            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Roles List</h4>
                        <div class="page-title-right">
                            @if(Auth::user()->can('create role'))
                            <a href="{{ route('roles-and-permissions.create') }}" class="btn btn-primary">Add New Role</a>
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
                            <table id="datatable" class="table table-bordered table-striped dt-responsive  nowrap w-100">
                                <thead>
                                <tr>
                                    <th class="p-1">#</th>
                                    <th class="p-1">Role</th>
                                    @canany(['edit role', 'delete role'])
                                    <th class="p-1">Action</th>
                                    @endcanany
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $key=> $role)
                                    <tr>
                                        <td class="p-1">{{ ++$key }}</td>
                                        <td class="p-1">{{ ucwords($role->name) }}</td>
                                        @canany(['edit role', 'delete role'])
                                        <td class="p-1">
                                            @if(Auth::user()->can('edit role'))
                                            <a href="{{ route('roles-and-permissions.edit', $role->id)}}" class="btn btn-primary btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                            @endif
                                            @if(Auth::user()->can('delete role'))
                                                @if(!$rolesWithUsers[$role->id])
                                                <button data-source="role" data-endpoint="{{ route('roles-and-permissions.destroy', $role->id)}}"
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
    <x-include-plugins :plugins="['dataTable']"></x-include-plugins>
@endsection
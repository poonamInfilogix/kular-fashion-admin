@extends('layouts.app')

@section('title', 'Manage Users')
@section('header-button')
    @if (Auth::user()->can('create users'))
        <a href="{{ route('users.create') }}" class="btn btn-primary">Add New User</a>
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
                            <table id="datatable" class="table table-bordered table-striped dt-responsive  nowrap w-100">
                                <thead>
                                    <tr>
                                        <th class="p-1">#</th>
                                        <th class="p-1">Name</th>
                                        <th class="p-1">Email</th>
                                        <th class="p-1">Role</th>
                                        <th class="p-1">Branch</th>
                                        @canany(['edit users', 'delete users'])
                                            <th class="p-1">Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $key => $user)
                                        <tr>
                                            <td class="p-1">{{ ++$key }}</td>
                                            <td class="p-1">{{ ucwords($user->name) }}</td>
                                            <td class="p-1">{{ $user->email }}</td>
                                            <td class="p-1">{{ $user->getRoleNames()->first() }}</td>
                                            <td class="p-1">{{ $user->branch->name ?? 'N/A' }}</td>
                                            @canany(['edit users', 'delete users'])
                                                <td class="p-1">
                                                    @if (Auth::user()->can('edit users') &&
                                                            (Auth::user()->hasRole('Super Admin') || $user->getRoleNames()->first() !== 'Super Admin'))
                                                        <a href="{{ route('users.edit', $user->id) }}"
                                                            class="btn btn-primary btn-sm edit py-0 px-1">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                    @endif

                                                    @if (Auth::user()->can('delete users') && $user->getRoleNames()->first() !== 'Super Admin')
                                                        <button data-source="user"
                                                            data-endpoint="{{ route('users.destroy', $user->id) }}"
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
                </div> <!-- end col -->
            </div> <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <x-include-plugins :plugins="['dataTable']"></x-include-plugins>
@endsection

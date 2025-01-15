@extends('layouts.app')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Tags</h4>

                        <div class="page-title-right">
                            @if(Auth::user()->can('create tags'))
                            <a href="{{ route('tags.create') }}" class="btn btn-primary">Add New Tag</a>
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
                            <table id="datatable" class="table table-bordered dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tag</th>
                                        <th>Status</th>
                                        @canany(['edit tags', 'delete tags'])
                                        <th>Action</th>
                                        @endcanany
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tags as $key => $tag)
                                        <tr>
                                            <td>{{ ++$key }}</td>
                                            <td>{{ $tag->tag_name }}</td>
                                            <td>
                                                <input type="checkbox" id="{{ $tag->id }}" class="update-status" data-id="{{ $tag->id }}" switch="success" data-on="Active" data-off="Inactive" {{ $tag->status === 'Active' ? 'checked' : '' }} data-endpoint="{{ route('tag-status') }}" />
                                                <label for="{{ $tag->id }}" data-on-label="Active" data-off-label="Inactive"></label>
                                            </td>
                                            @canany(['edit tags', 'delete tags'])
                                            <td class="action-buttons">
                                                @if(Auth::user()->can('edit tags'))
                                                <a href="{{ route('tags.edit', $tag->id)}}" class="btn btn-primary btn-sm edit"><i class="fas fa-pencil-alt"></i></a>
                                                @endif
                                                @if(Auth::user()->can('delete tags'))
                                                <button data-source="Tag" data-endpoint="{{ route('tags.destroy', $tag->id)}}"
                                                    class="delete-btn btn btn-danger btn-sm edit">
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
                columnDefs: [
                    { type: 'string', targets: 1 } 
                ],
                order: [[1, 'asc']]
            });
        });
    </script>
@endsection
@extends('layouts.app',['isVueComponent' => true])

@section('title', 'Inventory Transfer')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />
                    <div class="card">
                        <div class="card-body">
                            <inventory-tranfer 
                                :default-branches="{{ json_encode($branches) }}"
                                :current-user-store="{{ auth()->user()->branch_id }}">
                            </inventory-tranfer>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <x-include-plugins :plugins="['dataTable', 'update-status']"></x-include-plugins>
@endsection
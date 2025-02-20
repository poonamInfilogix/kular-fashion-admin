@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
           @include('dashboard.components.widgets')
        </div>
    </div>
@endsection

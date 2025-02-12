@extends('layouts.app',['isVueComponent' => true])

@section('title', 'View Inventory')
@section('header-button')
    <a href="{{ route('inventory-history') }}" class="btn btn-primary"><i class="bx bx-arrow-back"></i> Back to Inventory History</a>
@endsection
@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
              
                <div class="row">
                    <div class="col-sm-3">
                        <h6 class="mt-1 mb-2">Sent From: <strong>{{$inventoryTransfer->sentFrom->name}}</strong>
                        </h6>
                    </div>
                                        
                    <div class="col-sm-3">
                        <h6 class="mt-1 mb-2">Sent To: <strong>{{$inventoryTransfer->sentTo->name}}</strong>
                        </h6>
                    </div>
                    <div class="col-sm-3">
                        <h6 class="mb-2">Sent By: <strong>{{$inventoryTransfer->sentBy->name}}</strong></h6>
                    </div>
                    <div class="col-sm-3">
                        <h6 class="mb-2">Transfer Date: <strong><td>{{ date('m-d-Y', strtotime($inventoryTransfer->created_at))}}</td></strong></h6>
                    </div>
                </div>
                <!-- ==============  -->
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />

                       <div class="card">
                        <div class="card-body">
                            <table id="invent-trans-datatable" class="table table-sm table-bordered table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Article Code</th>
                                        <th>Manufacture Code</th>
                                        <th>Brand</th>
                                        <th>Color</th>
                                        <th>Size</th>
                                    </tr>
                                </thead>
                                <tbody>
                           
                                    @foreach($invenTransferRecord as $key => $transfer)
                                        @for($i = 0; $i < $transfer->quantity; $i++)  
                                            <tr>
                                                <td>{{++$key}}</td>
                                                <td>{{$transfer->product->article_code}}</td>
                                                <td>{{$transfer->product->manufacture_code}}</td>
                                                <td>{{$transfer->brand->name}}</td>
                                                <td>{{$transfer->productColor->color_name}}</td>
                                                <td>{{$transfer->productSize->size ?? 'N/A' }}</td>
                                            </tr>
                                        @endfor
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
       
            $('#invent-trans-datatable').DataTable({
              
                columnDefs: [{
                    type: 'string',
                    targets: 1
                }],
                order: [
                    [1, 'asc']
                ],
                drawCallback: function(settings) {
                    $('#invent-trans-datatable th, #invent-trans-datatable td').addClass('p-1');
                }
            });
           
        });
      
    </script>
@endsection
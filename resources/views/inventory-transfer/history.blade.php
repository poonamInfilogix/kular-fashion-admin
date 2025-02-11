@extends('layouts.app',['isVueComponent' => true])

@section('title', 'Inventory Transfer')

@section('content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <x-error-message :message="$errors->first('message')" />
                    <x-success-message :message="session('success')" />
               
                       <!-- ============= -->
                       <div class="card">
                        <div class="card-body">
                            <table id="datatable" class="table table-sm table-bordered table-striped dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Sent From</th>
                                        <th>Sent To</th>
                                        <th>Sent By</th>
                                        <th>Transfer Item</th>
                                        <th>Transfer Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($inventory_transfer as $key => $transfer)
                                        <tr>
                                            <td >{{++$key}}</td>
                                            <td>{{$transfer->getSentFrom->name}}</td>
                                            <td>{{$transfer->getSentTo->name}}</td>
                                            <td>{{$transfer->getSentBy->name}}</td>
                                            <td>{{ $inventory_transfer->total_quantity}}</td>
                                            <td>{{ date('m-d-Y', strtotime($transfer->created_at))}}</td>
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
                    [1, 'asc']
                ],
                drawCallback: function(settings) {
                    $('#datatable th, #datatable td').addClass('p-1');
                }
            });
           
        });
    </script>
@endsection
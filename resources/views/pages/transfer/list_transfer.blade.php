@extends('home')
@section('content')
    @inject('warehouse', 'App\Models\Warehouse\Warehouse')
    @inject('quantity', 'App\Models\PosTransfer\PosTransfer')
    <div class="container">
        <div class="row">
            <div class="col-md-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3> All Transfers</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>Transfer No</th>
                                    <th>Transfer Date</th>
                                    <th>From Warehouse</th>
                                    <th>To Warehouse</th>
                                    <th>Total Qty</th>
                                    {{-- <th>Action</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transfer as $transfer)
                                    <tr>
                                        <td>{{ $transfer->transferNo }}</td>
                                        <td>{{ $transfer->transferDate }}</td>
                                        <td>{{ $warehouse->getWareHouseName($transfer->fromWarehouseID) }}</td>
                                        <td>{{ $warehouse->getWareHouseName($transfer->toWarehouseID) }}</td>
                                        <td>{{ $quantity->getTotalProductQuantity($transfer->transferNo) }}</td>
                                        {{-- <td>
                                            <a href="{{ 'transfer/' . $transfer->transfer_id . '/' . 'edit' }}"
                                                class="btn btn-sm btn-warning">Edit</a>
                                            <button class="btn btn-sm btn-danger"
                                                onclick="deleteNow({{ $transfer->transfer_id }})">Delete</button>
                                            <a href="{{ 'transfer/' . $transfer->transfer_id }}"
                                                class="btn btn-sm btn-info">View</a>
                                        </td> --}}
                                    </tr>
                                @endforeach



                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('#myTable')
                .dataTable();


        });
    </script>
@endsection

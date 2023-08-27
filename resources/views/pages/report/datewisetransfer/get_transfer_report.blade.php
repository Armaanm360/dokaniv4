<!-- Form section -->
<!-- start: page toolbar -->
<div class="page-body px-xl-4 px-sm-2 px-0 py-lg-2 py-1 mt-0 mt-lg-3">
    <div class="container-fluid">
        <div class="row g-3">
            <div class="col-12 mt-4">
                <div class="card">
                    <div class="card-header">
                        <h3> Datewise Transfer Report -Warehouse to Warehouse (OUT)</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Transfer No</th>
                                    <th>To</th>
                                    <th>Total Quanitity</th>
                            </thead>
                            <tbody>
                                @foreach ($warehouse_to_warehouse_out as $warehouse_out)
                                @php
                                    $to_ware_house = "";
                                    $total_quantity = "";
                                    $to_ware_house_name = App\Models\Warehouse\Warehouse::warehouseName($warehouse_out->toWarehouseID);
                                    if($to_ware_house_name)
                                    {
                                        $to_ware_house = $to_ware_house_name->warehouse_name;
                                    }
                                    $totalQuantity = App\Models\PosTransferProduct\PosTransferProduct::quantity($warehouse_out->transferNo);
                                    if($totalQuantity)
                                    {
                                        $total_quantity = $totalQuantity;
                                    }
                                @endphp
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $warehouse_out->transferDate }}</td>
                                        <td>{{ $warehouse_out->transferNo }}</td>
                                        <td>{{ $to_ware_house }}</td>
                                        <td>{{ $total_quantity }}</td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3> Datewise Transfer Report -Warehouse to Warehouse (IN)</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Transfer No</th>
                                    <th>From</th>
                                    <th>Total Quanitity</th>
                            </thead>
                            <tbody>
                                @foreach ($warehouse_to_warehouse_in as $warehouse_in)
                                @php
                                    $from_ware_house = "";
                                    $total_quantity = "";
                                    $from_ware_house_name = App\Models\Warehouse\Warehouse::warehouseName($warehouse_in->fromWarehouseID);
                                    if($from_ware_house_name)
                                    {
                                        $from_ware_house = $from_ware_house_name->warehouse_name;
                                    }
                                    $totalQuantity = App\Models\PosTransferProduct\PosTransferProduct::quantity($warehouse_in->transferNo);
                                    if($totalQuantity)
                                    {
                                        $total_quantity = $totalQuantity;
                                    }
                                @endphp
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $warehouse_in->transferDate }}</td>
                                        <td>{{ $warehouse_in->transferNo }}</td>
                                        <td>{{ $from_ware_house }}</td>
                                        <td>{{ $total_quantity }}</td>
                                    </tr>
                                @endforeach


                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3> Datewise Transfer Report -Warehouse to Branch</h3>
                    </div>
                    <div class="card-body">
                        <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                            <thead>
                                <tr>
                                    <th>SL</th>
                                    <th>Date</th>
                                    <th>Transfer No</th>
                                    <th>To (Branch)</th>
                                    <th>Total Quanitity</th>
                            </thead>
                            <tbody>
                                @foreach ($warehouse_to_branch as $warehouse_to_branch)
                                @php
                                    $branchName = "";
                                    $total_quantity = "";
                                    $to_branch_name = App\Models\Branch\Branch::branchName($warehouse_to_branch->branch_id);
                                    if($to_branch_name)
                                    {
                                        $branchName = $to_branch_name->branch_name;
                                    }
                                    $totalQuantity = App\Models\Transfer\WarehouseToBranchItems::quantity($warehouse_to_branch->warehouse_to_branch_transfer_number);
                                    if($totalQuantity)
                                    {
                                        $total_quantity = $totalQuantity;
                                    }
                                @endphp
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $warehouse_to_branch->transfer_date }}</td>
                                        <td>{{ $warehouse_to_branch->warehouse_to_branch_transfer_number }}</td>
                                        <td>{{ $branchName }}</td>
                                        <td>{{ $total_quantity }}</td>
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

<!-- start: page body -->

<!-- end form section -->




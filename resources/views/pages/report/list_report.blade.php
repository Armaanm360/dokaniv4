@extends('home')
@section('content')
<div class="col-md-12 mt-4">
            <div class="card">
              <div class="card-body">
                <table id="myTable" class="table display dataTable table-hover" style="width:100%">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Position</th>
                      <th>Office</th>
                      <th>Age</th>
                      <th>Start date</th>
                      <th>Salary</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td class="sorting_1">Tiger Nixon</td>
                      <td>System Architect</td>
                      <td>Edinburgh</td>
                      <td>61</td>
                      <td>2011/04/25</td>
                      <td class="dt-body-right">$320,800</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
@endsection
@extends('home')
@section('content')

<div class="content">

    <div class="page-inner">
 
        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('List of Permission')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatable" class="display table table-striped table-hover" >
                                <thead>

                                    <tr>
                                        <th>{{__('Sl')}}</th>
                                        <th>{{__('Section')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($all_permissions as $row)
                                    <tr>
                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ $row->section_name }}
                                        </td>

                                        <td>
                                            {{ $row->name }}
                                        </td>

                                        <td>
                                            <a href="{{url('permissions')}}/{{ $row->id }}/edit" class="btn btn-success btn-sm">
                                            {{__('Edit')}}
                                            </a>
                                            <form  action="{{route('permissions.destroy', $row->id)}}" method='POST' style='display: inline-block;'>
                                            {{csrf_field()}}
                                            {{method_field('DELETE')}}
                            <button onclick="return confirm('Are you want to delete this!')" class='btn btn-danger btn-sm' type='submit'>{{__('Delete')}}</button>
                        </form>

                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{__('Sl')}}</th>
                                        <th>{{__('Section')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Action')}}</th>
                                    </tr>
                                </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $('#basic-datatable').DataTable({ });

    });
</script>
@endsection    

@extends('home')
@section('content')

<div class="content">

    <div class="page-inner">

        <div class="row">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{__('List of Roles')}}</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="basic-datatable" class="display table table-striped table-hover" >
                                          <thead>
                    <tr>
                        <th>{{__('Sl')}}</th>
                        <th>{{__('Name')}}</th>
                        <th>{{__('Slug')}}</th>
                        <th>{{__('Action')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($all_roles as $row)
                        <tr>
                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $row->name }}
                            </td>

                            <td>
                                {{ $row->slug }}
                            </td>
                            
                            <td>
                                <a class="btn btn-success btn-sm" href="{{url('roles')}}/{{ $row->id }}/edit">
                                {{__('Edit')}}
                                </a>
                                <a class="btn btn-danger btn-sm text-white">
                                {{__('Delete')}}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>{{__('Sl')}}</th>
                                        <th>{{__('Name')}}</th>
                                        <th>{{__('Slug')}}</th>
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
        $('#basic-datatable').DataTable({
        });

    });
</script>
@endsection    

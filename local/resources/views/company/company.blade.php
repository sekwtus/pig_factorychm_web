@extends('layouts.template')

@section('title', 'Company')

@section('stylesheet')

@stop
@section('content')
<div class="content-wrapper">
    <div class="row" id="stepApp">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <div class="row border-bottom">
                        <div class="col-12 p-0 text-left">
                            <h4>&nbsp;&nbsp;&nbsp;Company&nbsp;&nbsp;
                            <button type="button" class="btn btn-icons btn-rounded btn-success" title="Add Company" data-toggle="modal" data-target="#ADD"><i class="mdi mdi-plus"></i></a></button>
                            </h4>
                            <br>
                        </div>
                    </div>
                    @if($errors->all())
                    <div class="alert alert-danger">
                        {{ $errors->first() }}
                    </div>
                    @endif
                    <table id="table" class="table table-striped table-bordered" style="width:100%">
                        <thead>
                            <tr>
                                <th>ลำดับ</th>
                                <th>ชื่อบริษัท</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>

                    {{ Form::open(['method' => 'POST' , 'url' => 'company']) }}
                    @csrf
                    <div class="modal fade" id="ADD" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header ">
                                    <h4 class="modal-title" id="myModalLabel">Add Company</h4>
                                    <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i class="mdi mdi-close"></i></button>
                                </div>
                                <div class="modal-body">
                                    <label>ชื่อบริษัท :</label> {{ Form::text('Name',null, ['class' => 'form-control','placeholder' => 'ชื่อบริษัท']) }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" id="add" name="add" value="save">Save</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}

                    @foreach($data_company as $out_data_company)
                    {{ Form::open(['method' => 'PATCH' , 'action' => ['company_controller@update',$out_data_company->ID]]) }}
                    @csrf
                    <div class="modal fade" id="EDIT{{ $out_data_company->ID }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header ">
                                    <h4 class="modal-title" id="myModalLabel">Edit Company</h4>
                                    <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i class="mdi mdi-close"></i></button>
                                </div>
                                <div class="modal-body">
                                    <label>ชื่อบริษัท :</label> {{ Form::text('Name',$out_data_company->Name, ['class' => 'form-control','placeholder' => 'ชื่อบริษัท']) }}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-success" id="add" name="add" value="save">Save changes</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                    @endforeach

                    @foreach($data_company as $out_data_company)
                    {{ Form::open(['method' => 'DELETE' , 'action' => ['company_controller@destroy',$out_data_company->ID]]) }}
                    <div class="modal fade" id="DELETE{{ $out_data_company->ID }}" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Delete Company</h5>
                                    <button type="button" class="btn btn-icons btn-rounded btn-closed" title="close" data-dismiss="modal"><i class="mdi mdi-close"></i></button>
                                </div>
                                <div class="modal-body">
                                    <h5>Comfirm Delete : {{ $out_data_company->Name }}</h5>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-danger" id="delete" name="delete" value="delete">Delete</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('scripts')
<script>
    $(function() {
          $('#table').DataTable({
          processing: true,
          serverSide: true,
          ajax: '{{ url('/table/company') }}',
          columns: [
                   { data: 'ID', name: 'ID' },
                   { data: 'Name', name: 'Name' },
                   { data: 'ID', name: 'ID' ,orderable: false, searchable: false}
                ],
                columnDefs: [
                {
                    "targets": 0,
                    "className": "text-center"
                },
                {
                    "targets": 1
                },
                {
                    "targets": 2,
                    "className": "text-center",
                    render: function(data, type, row) {
                        return '<button class="btn btn-warning" data-toggle="modal" data-target="#EDIT'+data+'" style="padding:10px;">&nbsp;&nbsp;&nbsp;Edit&nbsp;&nbsp;&nbsp;</button>  <button class="btn btn-danger" data-toggle="modal" data-target="#DELETE'+data+'" style="padding:10px;">Delete</button>'
                        }
                }],
                "order": []
       });
    });
</script>
@stop

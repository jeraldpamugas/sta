@extends('layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3 style="margin: 0;">Warehouse</h3>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('warehouses.create') }}"> Add New Warehouse</a>
            </div>
        </div>
    </div>
    <hr>
    @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
    @endif
   
    <div style="overflow-y: hidden;">
        <table class="table table-striped">
            <tr>
                <th>Id</th>
                <th>Warehouse Code</th>
                <th>Description</th>
                <th>Action</th>
            </tr>
            @foreach ($warehouses as $warehouse)
            <tr>
                <td>{{ $warehouse->id }}</td>
                <td>{{ $warehouse->warehouseCode }}</td>
                <td>{{ $warehouse->description }}</td>
                <td>
                    <div>
                        <div class="col-sm-4">
                            <a style="display: block; margin: 2px;" class="btn btn-info" href="{{ route('warehouses.show',$warehouse->id) }}"><i class="fa fa-eye" aria-hidden="true"></i></a>
                        </div>
                        <div class="col-sm-4">
                            <a style="display: block; margin: 2px;" class="btn btn-primary" href="{{ route('warehouses.edit',$warehouse->id) }}"><i class="fa fa-edit" ></i></a>
                        </div>
                        <div class="col-sm-4">
                            <a style="display: block; margin: 2px;" class="btn btn-danger" href="{{ route('warehouses.destroy', $warehouse->id) }}"><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
      
@endsection
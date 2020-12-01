@extends('layout')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Warehouse</h2>
            </div>
            <div class="pull-right">
                <a class="btn" href="{{ route('warehouses.index') }}"> Back</a>
            </div>
        </div>
    </div>
    <hr>
    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
  
    <form action="{{ route('warehouses.update',$warehouse->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Warehouse Code:</strong>
                    <input type="text" name="warehouseCode" value="{{ $warehouse->warehouseCode }}" class="form-control" placeholder="Input Warehouse Code">
                </div>
                <div class="form-group">
                    <strong>Description:</strong>
                    <input type="text" name="Description" value="{{ $warehouse->description }}" class="form-control" placeholder="Input Description">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary" style="display: block; width: 100%;">Save Update</button>
            </div>
        </div>
   
    </form>
@endsection
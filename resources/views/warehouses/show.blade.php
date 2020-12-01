@extends('layout')
@section('content')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6" style="margin: auto;">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Warehouse Details</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn" href="{{ route('warehouses.index') }}"> Back</a>
                    </div>
                </div>
            </div>
           <hr>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Id:</strong>
                        {{ $warehouse->id }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Item Code:</strong>
                        {{ $warehouse->warehouseCode }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Description:</strong>
                        {{ $warehouse->description }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
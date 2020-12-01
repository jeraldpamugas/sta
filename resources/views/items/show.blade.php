@extends('layout')
@section('content')
    <div class="row">
        <div class="col-sm-3"></div>
        <div class="col-sm-6" style="margin: auto;">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="pull-left">
                        <h2>Item Details</h2>
                    </div>
                    <div class="pull-right">
                        <a class="btn" href="{{ route('items.index') }}"> Back</a>
                    </div>
                </div>
            </div>
           <hr>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Id:</strong>
                        {{ $item->id }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Item Code:</strong>
                        {{ $item->itemCode }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Description:</strong>
                        {{ $item->Description }}
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="form-group">
                        <strong>Unit:</strong>
                        {{ $item->unit }}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
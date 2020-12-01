@extends('layout')
   
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Edit Item</h2>
            </div>
            <div class="pull-right">
                <a class="btn" href="{{ route('items.index') }}"> Back</a>
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
  
    <form action="{{ route('items.update',$item->id) }}" method="POST">
        @csrf
        @method('PUT')
   
         <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Item Code:</strong>
                    <input type="text" name="itemCode" value="{{ $item->itemCode }}" class="form-control" placeholder="Input Item Code">
                </div>
                <div class="form-group">
                    <strong>Description:</strong>
                    <input type="text" name="Description" value="{{ $item->Description }}" class="form-control" placeholder="Input Description">
                </div>
                <div class="form-group">
                    <strong>Unit:</strong>
                    <input type="text" name="unit" value="{{ $item->unit }}" class="form-control" placeholder="Input Unit">
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
              <button type="submit" class="btn btn-primary" style="display: block; width: 100%;">Save Update</button>
            </div>
        </div>
    </form>
@endsection
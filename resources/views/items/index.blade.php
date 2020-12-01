@extends('layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Items</h2>
            </div>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('items.create') }}"> Add New Items</a>
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
                <th>Item Code</th>
                <th>Description</th>
                <th>Unit</th>
                <th>Action</th>
            </tr>
            @foreach ($items as $item)
            <tr>
                <td>{{ $item->id }}</td>
                <td>{{ $item->itemCode }}</td>
                <td>{{ $item->Description }}</td>
                <td>{{ $item->unit }}</td>
                <td>
                    <form action="{{ route('items.destroy', $item->id) }}" method="POST">
    
                        <a class="btn btn-info" href="{{ route('items.show',$item->id) }}">Show</a>
        
                        <a class="btn btn-primary" href="{{ route('items.edit',$item->id) }}">Edit</a>
    
                        @csrf
                        @method('DELETE')
        
                        <button type="submit" class="btn btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
      
@endsection
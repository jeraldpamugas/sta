@extends('layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4>Transaction No: <b>{{ $transaction->transNo }}</b></h4>
            </div>
            <div class="pull-right">
                <a class="btn" href="{{ route('transactions.index') }}">Back</a>
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
    <form id="transForm">
        @csrf
        @method('PUT')
    
        <div class="row">
            <input type="hidden" name="wrId" id="wrId" value="{{ $transaction->id }}">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="col-sm-4 form-group">
                    <strong>Employee Code:</strong>
                    <input type="text" class="form-control" value="{{ $transaction->employeeCode }}" disabled>
                </div>
                <div class="col-sm-4 form-group">
                    <strong>Reference:</strong>
                    <input type="text" class="form-control" value="{{ $transaction->reference }}" disabled>
                </div>
                <div class="col-sm-4 form-group">
                    <strong>Status:</strong>
                    <input type="text" class="form-control" value="{{ $transaction->status }}" disabled>
                </div>
                <div class="col-sm-4 form-group">
                    <strong>warehouseFrom:</strong>
                    <input type="text" class="form-control" value="{{ $transaction->warehouseFrom }}" disabled>
                </div>
                <div class="col-sm-4 form-group">
                    <strong>warehouseTo:</strong>
                    <input type="text" class="form-control" value="{{ $transaction->warehouseTo }}" disabled>
                </div>
                <div class="col-sm-4 form-group">
                    <strong>TransferDate:</strong>
                    <input type="text" class="form-control" value="{{ $transaction->transferDate }}" disabled>
                </div>
                <div class="col-sm-14">
                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <h4>Items:</h4>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Item Code</th>
                                    <th>Unit</th>
                                    <th>Quantity</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($translinesList as $item)
                                    <tr>
                                        <td>{{ $item->itemCode }}</td>
                                        <td>{{ $item->unit }}</td>
                                        <td>{{ $item->quantity }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <div class="col-sm-6">
                    @if($usertype == 'supervisor' && $transaction->status == 'O')
                        <div style="padding: 0;" class="col-sm-12">
                            <div style="margin: auto;">
                                <div style="padding: 0;" class="col-sm-12 form-group">
                                    <strong>Update Status:</strong>
                                    <select id="status" name="status" class="form-control">
                                        <option value="A">Authorized</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary" style="display: block; width: 100%; margin-top: 18px;">Save Update</button>
                    </div>
                    @elseif($usertype == 'manager' && $transaction->status == 'A' || $usertype == 'manager' && $transaction->status == 'C')
                        <div style="padding: 0;" style="margin: auto;" class="col-sm-12">
                            <div style="padding: 0;" class="col-sm-12 form-group">
                                <strong>Update Status:</strong>
                                <select id="status" name="status" class="form-control">
                                    @if ($transaction->status == 'A')
                                        <option value="C">Confirmed</option>
                                    @elseif ($transaction->status == 'C')
                                        <option value="P">Processed</option>
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-primary" style="display: block; width: 100%; margin-top: 18px;">Save Update</button>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </form>
    <script>
        
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#transForm').on('submit', function(event) {
        
        event.preventDefault();

        var status = $('#status').val();
        var id = $("#wrId").val();
        let _url     = '/updatetrans';
        let _token   = $('meta[name="csrf-token"]').attr('content');

        if(!status){

            alert("Status is invalid");

        }
        else{

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    id: id,
                    status: status,
                    _token: _token,
                },
                success: function(response) {
                    window.location.href = "/transactions";
                },
                error: function(response) {
                    alert("Invalid Status Value!");
                    location.reload();
                }
            });

        }
    });

    </script>
@endsection
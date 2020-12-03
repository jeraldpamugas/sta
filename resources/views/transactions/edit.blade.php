@extends('layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4>Transaction No: <b>{{ $transaction->transNo }}</b></h4>
            </div>
            <div class="pull-right">
                <a id="btnBackFromEditTrans" class="btn" href="#">Back</a>
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
                    @if($usertype == 'supervisor' && $transaction->status == 'O')
                        <input id="status" name="status" type="hidden" value="A">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary" style="display: block; width: 100%; margin-top: 18px;">Authorize</button>
                        </div>
                    @elseif($usertype == 'manager' && $transaction->status == 'A' || $usertype == 'manager' && $transaction->status == 'C')
                        @if ($transaction->status == 'A')
                        <input id="status" name="status" type="hidden" value="C">
                        @elseif ($transaction->status == 'C')
                        <input id="status" name="status" type="hidden" value="P">
                        @endif
                        <div class="col-sm-12">
                            @if ($transaction->status == 'A')
                                <button type="submit" class="btn btn-primary" style="display: block; width: 100%; margin-top: 18px;">Confirm</button>
                            @elseif ($transaction->status == 'C')
                                <button type="submit" class="btn btn-primary" style="display: block; width: 100%; margin-top: 18px;">Process</button>
                            @endif
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

        $.ajax({
            url: _url,
            type: "POST",
            data: {
                id: id,
                status: status,
                _token: _token,
            },
            success: function(response) {
                if(response == 'Invalid Status'){
                    alert("Please enter a valid status!");
                }
                else{
                // window.history.back();
                // location.reload();
                window.location = document.referrer;
                }
            },
            error: function(response) {
                alert('Press ok to refresh the page!');
                location.reload();
            }
        });
    });

    $('#btnBackFromEditTrans').click( function(e) {
        e.preventDefault();
        window.location = document.referrer;
        // window.history.back(); return false;
    });

    </script>
@endsection
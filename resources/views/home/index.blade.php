@extends('layout')
 
@section('content')
<div class="row">
    {{-- <div style="margin: 20px;">
        <button style="border-radius: 20px;" class="btn"><i class="fas fa-map-marker-alt"></i> Portland <i class="fas fa-times-circle"></i></button>
    </div> --}}
    @if($usertype != 'staff')
        <div class="col-sm-6" style="margin-bottom: 10px;">
            <div class="card pendingCard">
                @if($usertype == 'supervisor')
                <h3 style="background-color: rgba(255, 0, 0, 0.5); margin: 0; padding: 10px; color: white; text-align: center;">Pending for Authorization</h3>
                @else
                <h3 style="background-color: rgba(255, 0, 0, 0.5); margin: 0; padding: 10px; color: white; text-align: center;">Pending for Confirmation</h3>
                @endif
                <div style="overflow-x: hidden; height: 270px;">
                    @if(!$transactions)
                        <div style="padding: 1px 10px;" class="card-body">
                            <h4 style="text-align: center;">No pending records.</h4>
                        </div>
                    @else
                    <hr style="margin: 0;">
                        @foreach ($transactions as $trans)
                            @if ($trans->id)
                                @if ($trans->isOpened)
                                <a class="pendingTransA" href="{{ route('transactions.edit',$trans->id) }}">
                                    <div style="padding: 1px 10px; box-shadow: inset 5px 0 0 0 rgb(172, 112, 0);" class="card-body">
                                        <span style="height: 100%; width:10px; background-color: limegreen;"></span>
                                        <h4 class="card-title"><i class="far fa-envelope-open"></i> Transaction No: {{ $trans->transNo }}</h4>
                                        <h5 class="card-text">Status: {{ $trans->status }}</h5>
                                        <h5 class="card-text">Transfer Date: {{ $trans->transferDate }}</h5>
                                    </div>
                                </a>
                                @else
                                <a class="pendingTransA" href="{{ route('transactions.edit',$trans->id) }}">
                                    <div style="padding: 1px 10px; box-shadow: inset 5px 0 0 0 rgb(158, 0, 0);" class="card-body">
                                        <span style="height: 100%; width:10px; background-color: limegreen;"></span>
                                        <h4 class="card-title"><b><i class="fa fa-envelope" aria-hidden="true"></i> Transaction No: {{ $trans->transNo }}</b></h4>
                                        <h5 class="card-text"><b>Status: {{ $trans->status }}</b></h5>
                                        <h5 class="card-text"><b>Transfer Date: {{ $trans->transferDate }}</b></h5>
                                    </div>
                                </a>
                                @endif
                                <hr style="margin: 0;">
                            @endif
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
        <div class="col-sm-6" style="margin-bottom: 10px;">
            <div class="card upcomingCard">
                @if($usertype == 'supervisor')
                    <h3 style="background-color:  rgba(0, 158, 71, 0.5); margin: 0; padding: 10px; color: white; text-align: center;">Authorized</h3>
                    <div style="overflow-x: hidden; height: 270px;">
                        @if(!$transactionsCP)
                            <div style="padding: 1px 10px;" class="card-body">
                                <h4 style="text-align: center;">No Authorized records.</h4>
                            </div>
                        @else
                        <hr style="margin: 0;">
                            @foreach ($transactionsCP as $trans)
                                <a class="confirmedTrans" href="{{ route('transactions.show',$trans->id) }}">
                                    <div style="padding: 1px 10px;" class="card-body">
                                        <span style="height: 100%; width:10px; background-color: limegreen;"></span>
                                        <h4 class="card-title">Transaction No: {{ $trans->transNo }}</h4>
                                        <h5 class="card-text">Status: {{ $trans->status }}</h5>
                                        <h5 class="card-text">Transfer Date: {{ $trans->transferDate }}</h5>
                                    </div>
                                </a>
                                <hr style="margin: 0;">
                            @endforeach
                        @endif
                    </div>
                @elseif($usertype == 'manager')
                    <h3 style="background-color:  rgba(0, 158, 71, 0.5); margin: 0; padding: 10px; color: white; text-align: center;">Confirmed and Processed</h3>
                    <div style="overflow-x: hidden; height: 270px;">
                        @if(!$transactionsCP)
                            <div style="padding: 1px 10px;" class="card-body">
                                <h4 style="text-align: center;">No Confirmed and Processed records.</h4>
                            </div>
                        @else
                        <hr style="margin: 0;">
                            @foreach ($transactionsCP as $trans)
                                <a class="confirmedTrans" href="{{ route('transactions.show',$trans->id) }}">
                                    <div style="padding: 1px 10px;" class="card-body">
                                        <span style="height: 100%; width:10px; background-color: limegreen;"></span>
                                        <h4 class="card-title">Transaction No: {{ $trans->transNo }}</h4>
                                        <h5 class="card-text">Status: {{ $trans->status }}</h5>
                                        <h5 class="card-text">Transfer Date: {{ $trans->transferDate }}</h5>
                                    </div>
                                </a>
                                <hr style="margin: 0;">
                            @endforeach
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <hr>
    @endif
    <div class="col-sm-12">
        <div class="col-sm-9">
            <h3>Upcoming:</h3>
        </div>
        <div class="col-sm-3">
            @if($usertype == 'staff')
            <a style="display: block;" class="btn btn-success" href="{{ route('transactions.create') }}">New Transaction</a>
            @endif
        </div>
        <div class="col-sm-12" style="overflow-y: hidden; height: 100%; margin: 10px 0;">
            <table style="border-collapse: collapse; width: 100%;" id="transactionTable" class="table table-bordered table-striped">
                <thead>
                    <tr style="">
                        <th style="position: sticky; top: 0; background-color: white;">Trans. No</th>
                        <th style="position: sticky; top: 0; background-color: white;">Emp. Code</th>
                        <th style="position: sticky; top: 0; background-color: white;">Transfer Date</th>
                        <th style="position: sticky; top: 0; background-color: white;">Warehouse From</th>
                        <th style="position: sticky; top: 0; background-color: white;">Warehouse To</th>
                        <th style="position: sticky; top: 0; background-color: white;">Reference</th>
                        <th style="position: sticky; top: 0; background-color: white;">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactionsToday as $trans)
                    <tr>
                        <td><a class="confirmedTrans" href="{{ route('transactions.show',$trans->id) }}"><b>{{ $trans->transNo }}</b></a></td>
                        <td>{{ $trans->employeeCode }}</td>
                        <td>{{ $trans->transferDate }}</td>
                        <td>{{ $trans->warehouseFrom }}</td>
                        <td>{{ $trans->warehouseTo }}</td>
                        <td>{{ $trans->reference }}</td>
                        <td>{{ $trans->status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
  $('#transactionTable').DataTable();
</script>
@endsection
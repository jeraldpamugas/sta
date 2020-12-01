@extends('layout')
 
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h3 style="margin: 0;">Transactions</h3>
            </div>
            <div class="pull-right">
                @if($usertype == 'staff')
                <a class="btn btn-success" href="{{ route('transactions.create') }}"> Add New Transactions</a>
                @endif
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
        <table id="transactionTable" class="table table-striped">
            <tr>
                <th>     </th>
                <th>Trans. No</th>
                <th>Emp. Code</th>
                <th>TransferDate</th>
                <th>WarehouseFrom</th>
                <th>WarehouseTo</th>
                <th>Reference</th>
                <th>Status</th>
                <th>AuthorizeBy</th>
                <th>AuthorizeDate</th>
                <th>ConfirmedBy</th>
                <th>ConfirmedDate</th>
                <th>ProcessBy</th>
                <th>ProcessedDate</th>
                <th>SysCreated</th>
                <th>SysCreator</th>
                <th>SysModified</th>
                <th>SysModifier</th>
            </tr>
            @foreach ($transactions as $trans)
            <tr>
                @if($usertype != 'staff')
                    @if($trans->status == 'P')
                        <td title="Processed!" style="text-align: center"><i style="color: rgb(3, 128, 3);" class="fas fa-check"></i></td>
                    @elseif($trans->status == 'C')
                        <td title="Confirmed!" style="text-align: center"><a href="{{ route('transactions.edit',$trans->id) }}"><i style="color: lime;" class="fas fa-check"></i></a></td>
                    @elseif($trans->status == 'A')
                        <td title="Authorized!" style="text-align: center"><a href="{{ route('transactions.edit',$trans->id) }}"><i style="color: lime;" class="fas fa-check"></i></a></td>
                    @elseif($trans->transferDate < date('Y-m-d H:i:s'))
                        <td title="Transaction Expired!" style="text-align: center"><i style="font-size:14px;color: red;" class="fas fa-times"><i class="fa fa-exclamation-triangle" style="font-size:10px;color:red"></i></i></td>
                    @else
                        <td title="Not yet Authorized!" style="text-align: center"><a href="{{ route('transactions.edit',$trans->id) }}"><i style="color: rgb(179, 0, 0);" class="fas fa-times"></i></a></td>
                    @endif
                @else
                    @if($trans->status == 'P')
                        <td title="Processed!" style="text-align: center"><i style="color: rgb(3, 128, 3);" class="fas fa-check 2x"></i></td>
                    @elseif($trans->status == 'C')
                        <td title="Confirmed!" style="text-align: center"><i style="color: lime;" class="fas fa-check"></i></td>
                    @elseif($trans->status == 'A')
                        <td title="Authorized!" style="text-align: center"><i style="color: lime;" class="fas fa-check"></i></td>
                    @elseif($trans->transferDate < date('Y-m-d H:i:s'))
                        <td title="Transaction Expired!" style="text-align: center"><i style="font-size:14px;color: red;" class="fas fa-times"><i class="fa fa-exclamation-triangle" style="font-size:10px;color:red"></i></i></td>
                    @else
                        <td title="Not yet Authorized!" style="text-align: center"><i style="color: rgb(179, 0, 0);" class="fas fa-times"></i></td>
                    @endif
                @endif
                <td><a href="{{ route('transactions.show',$trans->id) }}"><b>{{ $trans->transNo }}</b></a></td>
                <td>{{ $trans->employeeCode }}</td>
                <td>{{ $trans->transferDate }}</td>
                <td>{{ $trans->warehouseFrom }}</td>
                <td>{{ $trans->warehouseTo }}</td>
                <td>{{ $trans->reference }}</td>
                <td style="text-align: center">{{ $trans->status }}</td>
                <td>{{ $trans->authorizedBy }}</td>
                <td>{{ $trans->authorizedDate }}</td>
                <td>{{ $trans->confirmedBy }}</td>
                <td>{{ $trans->confirmedDate }}</td>
                <td>{{ $trans->processedBy }}</td>
                <td>{{ $trans->processedDate }}</td>
                <td>{{ $trans->created_at }}</td>
                <td>{{ $trans->syscreator }}</td>
                <td>{{ $trans->updated_at }}</td>
                <td>{{ $trans->sysmodifier }}</td>
            </tr>
            @endforeach
        </table>
   </div>
  <script>
    $('#transactionTable').DataTable();
  </script>
   {{-- {!! $transactions->links() !!} --}}
   {{-- {!! $transactions->appends(input::except('page'))->render() !!} --}}
      
@endsection
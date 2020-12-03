@extends('layout')
@section('content')
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h4 style="margin: 0px;">Transaction No: <b>{{ $transaction[0]['transNo'] }}</b></h4>
            </div>
            <div class="pull-right">
                <a id="btnBackFromEditTrans" class="btn" href="#"> Back</a>
            </div>
        </div>
        <div id="report" class="col-sm-12" style='margin: auto;'>
           <hr>
            <div class="row">
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Id:</strong>
                                {{ $transaction[0]['id'] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Employee Code:</strong>
                                {{ $transaction[0]['employeeCode'] }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Transfer Date:</strong>
                                {{ $transaction[0]['transferDate'] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>WarehouseFrom:</strong>
                                {{ $transaction[0]['warehouseFrom'] }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>WarehouseTo:</strong>
                                {{ $transaction[0]['warehouseTo'] }}
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Reference:</strong>
                                {{ $transaction[0]['reference'] }}
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong>Status:</strong>
                                {{ $statusVal }}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="col-sm-12">
                        <div class="col-xs-12 col-sm-12 col-md-12">
                            <h4>Items:</h4>
                            <div style="overflow-x: hidden;">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Item Code</th>
                                            <th>Description</th>
                                            <th>Unit</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($translinesList as $item)
                                            <tr>
                                                <td>{{ $item['itemCode'] }}</td>
                                                <td>{{ $item['Description'] }}</td>
                                                <td>{{ $item['unit'] }}</td>
                                                <td>{{ $item['quantity'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="col-sm-3">
                <button id="btnReport" type="button" class="btn btn-primary" style="display: block; width: 100%;" onclick="showReport()">Generate</button>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function showReport(){

            $("#btnReport").hide();
            $("#btnBack").hide();
            window.print();
            $("#btnReport").show();
            $("#btnBack").show();
            
        }

        $('#btnBackFromEditTrans').click( function(e) {
            e.preventDefault(); 
            window.history.back(); return false; 
        });
    
    </script>
@endsection
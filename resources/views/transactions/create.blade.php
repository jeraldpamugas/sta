@extends('layout')
  
@section('content')
<div class="row">
    <div class="col-lg-12 margin-tb">
        <div class="pull-left">
            <h4>New Transaction</h4>
        </div>
        <div class="pull-right">
            <a class="btn" href="#" onclick="backTrans()">Back</a>
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
  
     <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="col-sm-6 form-group">
                <strong><span style="color: red;"><b>*</b></span> Warehouse From:</strong>
                <select id="warehouseFrom" name="warehouseFrom" class="form-control">
                    @foreach ($warehouseList as $item)
                        <option value="{{ $item->warehouseCode }}">{{ $item->warehouseCode }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-6 form-group">
                <strong><span style="color: red;"><b>*</b></span> Warehouse To:</strong>
                <select id="warehouseTo" name="warehouseTo" class="form-control">
                @foreach ($warehouseList as $item)
                    <option value="{{ $item->warehouseCode }}">{{ $item->warehouseCode }}</option>
                @endforeach
                </select>
            </div>
            <div class="col-sm-6 form-group">
                <strong><span style="color: red;"><b>*</b></span> Transfer Date:</strong>
                <input type="datetime-local" id="transferDate" name="transferDate" class="form-control">
            </div>
            <div class="col-sm-6 form-group">
                <strong><span style="color: red;"><b>*</b></span> Reference:</strong>
                <input type="text" id="reference" name="reference" class="form-control" placeholder="Reference Number">
            </div>
            <div class="col-sm-12"><hr><h4>Items:</h4></div>

            <div class="col-sm-5 form-group">
                <strong>Item Code:</strong>
                <select id="itemCode" name="itemCode" class="form-control">
                    @foreach ($itemList as $item)
                        <option value="{{ $item->itemCode }}">{{ $item->itemCode }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-sm-5 form-group">
                <strong>Quantity:</strong>
                <input id="quantity" type="number" name="quantity" class="form-control" placeholder="Quantity">
            </div>
            <div class="col-sm-2 form-group">
                <br>
                <button id="addItem" type="button" class="btn" style="display: block; width: 100%;">add item</button>
            </div>
            <div class="col-sm-12">
                <table id="itemTable" class="table table-striped">
                    <thead>
                        <tr>
                            <th>Item Code</th>
                            <th>Quantity</th>
                            <th>Remove Item</th>
                        </tr>
                    </thead>
                    <tbody id="itemTbody">
                    </tbody>
                </table>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 text-center">
            <div class="col-sm-6" style="text-align: left; margin: 10px 0px;">
                <a href='#' id='removeItem' onclick='emptyTbody();return false;' ><i class="fas fa-minus-square"></i> Remove All Items</a>
            </div>
            <div class="col-sm-6" style="margin: 10px 0px;">
                <button id="submit" class="btn btn-primary" style="display: block; width: 100%;">Save</button>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">

    $("#itemTable").on("click", "#removeItem", function() {
        $(this).closest("tr").remove();
    });

    function emptyTbody(){
        $('#itemTable > tbody').empty();
    };

    $(document).ready(function(){
        $("#addItem").click(function(){
            
            var code = $('#itemCode').val();
            var qty = 0;
            qty = parseInt($('#quantity').val());
            var isItemExist = false;

            $("#itemTable tbody tr").each(function() {
                let _trItemCode = $(this).find("td:eq(0)").html();
                let _trQty = parseInt($(this).find("td:eq(1)").html());
                
                if(code == _trItemCode){

                    let newQuantity = qty + _trQty;
                    $(this).find("td:eq(1)").html(newQuantity);
                    isItemExist = true;
                    $("#quantity").val('');
                    
                }
            });
            
            if($("#itemTable tbody tr").length == 0){

                if(Number.isInteger(qty)){

                    var markup = "<tr></td><td>" + code + "</td><td>" + qty + "</td><td><button type='button' class='btn' id='removeItem' ><i class='far fa-minus-square'></i></button></td></tr>";
                    $("table tbody").append(markup);
                    $("#quantity").val('');

                }

            }
            else if(!isItemExist){

                if(Number.isInteger(qty)){

                    var markup = "<tr></td><td>" + code + "</td><td>" + qty + "</td><td><button type='button' class='btn' id='removeItem' ><i class='far fa-minus-square'></i></button></td></tr>";
                    $("table tbody").append(markup);
                    $("#quantity").val('');

                }

            }

        });
    });
    
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    
    $('#transForm').on('submit', function(event) {
        
        var items = [];
        let isQtyNum = true;
        var errorMessage = "";

        $("#itemTable tbody tr").each(function() {
            
            let _trItemCode = $(this).find("td:eq(0)").html();
            let _trQty = parseInt($(this).find("td:eq(1)").html());
            
            if(_trQty <= 0){

                emptyTbody();
                if(isQtyNum){
                    isQtyNum = false;
                }
                errorMessage = "Quantity should be greater then 0.";
                alert(errorMessage);

            }
            else if(Number.isInteger(_trQty)){

                var itemVal = _trItemCode + '-' + _trQty;
                items.push(itemVal);

            }
            else{

                emptyTbody();
                if(isQtyNum){
                    isQtyNum = false;
                }
                errorMessage = "Quantity should be a number.";
                alert(errorMessage);

            }
            
        });
        
        if(isQtyNum && $('#itemTable tbody').find('tr').length){
            
            event.preventDefault();

            var warehouseFrom = $('#warehouseFrom').val();
            var warehouseTo = $('#warehouseTo').val();
            var transferDate = $('#transferDate').val();
            var reference = $('#reference').val();
            let _url     = '/transform';
            let _token   = $('meta[name="csrf-token"]').attr('content');

            if(!warehouseFrom || !warehouseTo || !transferDate || !reference){

                alert("Fillout all required fields");

            }
            else{

                $.ajax({
                    url: _url,
                    type: "POST",
                    data: {
                        warehouseFrom: warehouseFrom,
                        warehouseTo: warehouseTo,
                        transferDate: transferDate,
                        reference: reference,
                        items: items,
                        _token: _token,
                    },
                    success: function(response) {
                        // console.log(response);
                        window.location.href = "/";
                    },
                    error: function(response) {
                        console.log(response);
                        alert("Something is error. Error details: " + response);
                    }
                });

            }

        }
        else{

            alert("Add item first.");

        }
    });

    function backTrans(){
        window.location = document.referrer;
    }
    
    
    // function createPost() {

    //     var itemCode = $('#itemCode').val();
    //     var description = $('#Description').val();
    //     var unit = $('#unit').val();
    //     var id = $('#item_id').val();
    //     let _url     = `/items`;
    //     let _token   = $('meta[name="csrf-token"]').attr('content');

    //     $.ajax({
    //         url: _url,
    //         type: "POST",
    //         data: {
    //         id: id,
    //         itemCode: itemCode,
    //         Description: description,
    //         unit: unit,
    //         _token: _token
    //         },
    //         success: function(response) {

    //             if(response.code == 200) {

    //             let res = JSON.parse(response.data);
    //             if(id != ""){
                    
    //                 $("#row_"+id+" td:nth-child(2)").html(res.data.itemCode);
    //                 $("#row_"+id+" td:nth-child(3)").html(res.data.Description);
    //                 $("#row_"+id+" td:nth-child(4)").html(res.data.unit);

    //             } else {

    //                 $('table tbody').prepend('<tr id="row_'+res.data.id+'"><td>'+res.data.id+'</td><td>'+res.data.itemCode+'</td><td>'+res.data.Description+'</td><td>'+res.data.unit+'</td><td><a href="javascript:void(0)" data-id="'+res.data.id+'" onclick="editPost(event.target)" class="btn btn-info" style="width: 45%; padding: 6px 6px;"><i data-id="'+res.data.id+'" onclick="editPost(event.target)" class="fas fa-edit"></i></a><a href="javascript:void(0)" data-id="'+res.data.id+'" onclick="deletePost(event.target)" class="btn btn-danger" style="width: 45%; padding: 6px 6px;"><i data-id="'+res.data.id+'" onclick="deletePost(event.target)" class="fas fa-trash-alt"></i></a></td></tr>');
                
    //             }

    //             $('#itemCode').val('');
    //             $('#Description').val('');
    //             $('#unit').val('');
    //             $('#post-modal').modal('hide');

    //             }
    //         },
    //         error: function(response) {
    //         if(response.responseJSON.errors.itemCode){
    //             $('#itemCode').addClass('requiredField');
    //             $('#itemcodeError').text(response.responseJSON.errors.itemCode);
    //         }
    //         else{
    //             $('#itemCode').removeClass('requiredField');
    //             $('#itemcodeError').text('');
    //         }
    //         if(response.responseJSON.errors.Description){
    //             $('#Description').addClass('requiredField');
    //             $('#descriptionError').text(response.responseJSON.errors.Description);
    //         }
    //         else{
    //             $('#Description').removeClass('requiredField');
    //             $('#descriptionError').text('');
    //         }
    //         if(response.responseJSON.errors.unit){
    //             $('#unit').addClass('requiredField');
    //             $('#unitError').text(response.responseJSON.errors.unit);
    //         }
    //         else{
    //             $('#unit').removeClass('requiredField');
    //             $('#unitError').text('');
    //         }
    //         }
    //     });
    // }

</script>
@endsection
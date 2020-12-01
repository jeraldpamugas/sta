@extends('layout')
 
@section('content')<!DOCTYPE html>

<div class="row">
  <div class="col-12 text-right">
      <div class="col-sm-6" style="float: left;">
           <h3 class="pull-left" style="margin: 0;">Items</h3>
       </div>
      <div class="col-sm-6">
           <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-post" onclick="addPost()">Add Item</a>
      </div>
  </div>
</div>
<div class="row" style="clear: both;margin-top: 18px;">
   <div class="col-12" style="margin: 0px 10px; overflow-y: hidden;">
     <table id="itemTable" class="table table-striped table-hover">
       <thead>
           <tr>
               <th>Id</th>
               <th>Item Code</th>
               <th>Description</th>
               <th>Unit</th>
               <th>Action</th>
           </tr>
       </thead>
       <tbody>
           @foreach($items as $item)
           <tr id="row_{{$item->id}}">
              <td>{{ $item->id  }}</td>
              <td>{{ $item->itemCode }}</td>
              <td>{{ $item->Description }}</td>
              <td>{{ $item->unit }}</td>
              <td>
               <a href="javascript:void(0)" data-id="{{ $item->id }}" onclick="editPost(event.target)" class="btn btn-info" style="width: 45%; padding: 6px 6px;"><i data-id="{{ $item->id }}" onclick="editPost(event.target)" class="fas fa-edit"></i></a>
               <a href="javascript:void(0)" data-id="{{ $item->id }}" onclick="deletePost(event.target)" class="btn btn-danger" style="width: 45%; padding: 6px 6px;"><i data-id="{{ $item->id }}" onclick="deletePost(event.target)" class="fas fa-trash-alt"></i></a></td>
              </tr>
           @endforeach
       </tbody>
     </table>
  </div>
</div>

<div class="modal fade" id="post-modal" aria-hidden="true">
 <div class="modal-dialog">
   <div class="modal-content">
       <div class="modal-header">
           <h4 id="modalHeader" class="modal-title">Item</h4>
       </div>
       <div class="modal-body">

           <form name="itemForm">
               @csrf
                <div class="row">
                   <div class="col-xs-12 col-sm-12 col-md-12">
                       <input type="hidden" name="item_id" id="item_id">
                       <div class="form-group">
                           <strong>Item Code:</strong>
                           <input type="text" id="itemCode" name="itemCode" class="form-control" placeholder="Input Item Code">
                           <span id="itemcodeError" class="alert-message"></span>
                       </div>
                       <div class="form-group">
                           <strong>Description:</strong>
                           <input type="text" id="Description" name="Description" class="form-control" placeholder="Input Description">
                           <span id="descriptionError" class="alert-message"></span>
                       </div>
                       <div class="form-group">
                           <strong>Unit:</strong>
                           <input type="text" id="unit" name="unit" class="form-control" placeholder="Input Unit">
                           <span id="unitError" class="alert-message"></span>
                       </div>
                   </div>
               </div>
              
           </form>
       </div>
       <div class="modal-footer">
           <button type="button" class="btn" onclick="closeItemModel()">Cancel</button>
           <button type="button" class="btn btn-primary" onclick="createPost()">Save</button>
       </div>
   </div>
 </div>
</div>

<script>
  $('#itemTable').DataTable();

  function addPost() {

    $("#item_id").val('');
    $('#post-modal').modal('show');
    $('#modalHeader').html('Add New Item');
    $("#itemCode").val('');
    $("#Description").val('');
    $("#unit").val('');

    $('#itemcodeError').text('');
    $('#descriptionError').text('');
    $('#unitError').text('');
    
    $('#itemCode').removeClass('requiredField');
    $('#Description').removeClass('requiredField');
    $('#unit').removeClass('requiredField');
    
  }

  function closeItemModel() {

    $("#post-modal").modal('hide');

  }

  function editPost(event) {

    var id  = $(event).data("id");
    let _url = `/items/${id}`;
    $('#itemcodeError').text('');
    $('#descriptionError').text('');
    $('#unitError').text('');
    $('#modalHeader').html('Edit Item');
    
    $.ajax({
      url: _url,
      type: "GET",
      success: function(response) {
          if(response) {
            let res = JSON.parse(response);
            $("#item_id").val(res[0].id);
            $("#itemCode").val(res[0].itemCode);
            $("#Description").val(res[0].Description);
            $("#unit").val(res[0].unit);
            $('#post-modal').modal('show');

          }
      }
    });
  }

  function createPost() {

    var itemCode = $('#itemCode').val();
    var description = $('#Description').val();
    var unit = $('#unit').val();
    var id = $('#item_id').val();
    let _url     = `/items`;
    let _token   = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        url: _url,
        type: "POST",
        data: {
          id: id,
          itemCode: itemCode,
          Description: description,
          unit: unit,
          _token: _token
        },
        success: function(response) {

            if(response.code == 200) {

              let res = JSON.parse(response.data);
              if(id != ""){
                
                $("#row_"+id+" td:nth-child(2)").html(res.data.itemCode);
                $("#row_"+id+" td:nth-child(3)").html(res.data.Description);
                $("#row_"+id+" td:nth-child(4)").html(res.data.unit);

              } else {

                $('table tbody').prepend('<tr id="row_'+res.data.id+'"><td>'+res.data.id+'</td><td>'+res.data.itemCode+'</td><td>'+res.data.Description+'</td><td>'+res.data.unit+'</td><td><a href="javascript:void(0)" data-id="'+res.data.id+'" onclick="editPost(event.target)" class="btn btn-info" style="width: 45%; padding: 6px 6px;"><i data-id="'+res.data.id+'" onclick="editPost(event.target)" class="fas fa-edit"></i></a><a href="javascript:void(0)" data-id="'+res.data.id+'" onclick="deletePost(event.target)" class="btn btn-danger" style="width: 45%; padding: 6px 6px;"><i data-id="'+res.data.id+'" onclick="deletePost(event.target)" class="fas fa-trash-alt"></i></a></td></tr>');
              
              }

              $('#itemCode').val('');
              $('#Description').val('');
              $('#unit').val('');
              $('#post-modal').modal('hide');

            }
        },
        error: function(response) {
          if(response.responseJSON.errors.itemCode){
            $('#itemCode').addClass('requiredField');
            $('#itemcodeError').text(response.responseJSON.errors.itemCode);
          }
          else{
            $('#itemCode').removeClass('requiredField');
            $('#itemcodeError').text('');
          }
          if(response.responseJSON.errors.Description){
            $('#Description').addClass('requiredField');
            $('#descriptionError').text(response.responseJSON.errors.Description);
          }
          else{
            $('#Description').removeClass('requiredField');
            $('#descriptionError').text('');
          }
          if(response.responseJSON.errors.unit){
            $('#unit').addClass('requiredField');
            $('#unitError').text(response.responseJSON.errors.unit);
          }
          else{
            $('#unit').removeClass('requiredField');
            $('#unitError').text('');
          }
        }
      });
  }

  function deletePost(event) {

    var id  = $(event).data("id");
    let _url = `/items/${id}`;
    let _token   = $('meta[name="csrf-token"]').attr('content');

      $.ajax({
        url: _url,
        type: 'DELETE',
        data: {
          _token: _token
        },
        success: function(response) {
          $("#row_"+id).remove();
          alert(response.success);
        }
      });
  }

</script>
@endsection
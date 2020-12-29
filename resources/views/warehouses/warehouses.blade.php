@extends('layout')

@section('content')
    <!DOCTYPE html>

    <div class="row">
        <div class="col-12 text-right">
            <div class="col-sm-6" style="float: left;">
                {{-- <h3 class="pull-left" style="margin: 0;">Warehouse</h3>
                --}}
                <a href="javascript:void(0)" style="" class="btn btn-success mb-3 pull-left" id="create-new-post"
                    onclick="addPost()">Add Warehouse</a>
            </div>
        </div>
    </div>
    <div class="row" style="clear: both;margin-top: 18px;">
        <div class="col-12" style="margin: 0px 10px; overflow-y: hidden;">
            <table id="warehouseTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Warehouse Code</th>
                        <th>Description</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($warehouses as $warehouse)
                        <tr id="row_{{ $warehouse->id }}">
                            <td>{{ $warehouse->id }}</td>
                            <td>{{ $warehouse->warehouseCode }}</td>
                            <td>{{ $warehouse->description }}</td>
                            <td>
                                <a href="javascript:void(0)" data-id="{{ $warehouse->id }}" onclick="editPost(event.target)"
                                    class="btn btn-info" style="width: 45%; padding: 6px 6px;"><i
                                        data-id="{{ $warehouse->id }}" onclick="editPost(event.target)"
                                        class="fas fa-edit"></i></a>
                                <a href="javascript:void(0)" data-id="{{ $warehouse->id }}"
                                    onclick="deletePost(event.target)" class="btn btn-danger"
                                    style="width: 45%; padding: 6px 6px;"><i data-id="{{ $warehouse->id }}"
                                        onclick="deletePost(event.target)" class="fas fa-trash-alt"></i></a>
                            </td>
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
                    <h4 id="modalHeader" class="modal-title">Warehouse Form</h4>
                </div>
                <div class="modal-body">

                    <form name="warehouseForm">
                        @csrf
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12">
                                <input type="hidden" name="warehouse_id" id="warehouse_id">
                                <div class="form-group">
                                    <strong>Warehouse Code:</strong>
                                    <input type="text" id="warehouseCode" name="warehouseCode" class="form-control"
                                        placeholder="Input Warehouse Code">
                                    <span id="warehouseCodeError" class="alert-message"></span>
                                </div>
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    <input type="text" id="Description" name="Description" class="form-control"
                                        placeholder="Input Description">
                                    <span id="descriptionError" class="alert-message"></span>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn" onclick="closeWarehouseModel()">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="createPost()">Save</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        $('#warehouseTable').DataTable();

        function addPost() {

            $("#warehouse_id").val('');
            $('#post-modal').modal('show');
            $('#warehouseCode').val('');
            $('#Description').val('');
            $('#modalHeader').html('Add New Warehouse');


            $('#warehouseCode').removeClass('requiredField');
            $('#warehouseCodeError').text('');
            $('#Description').removeClass('requiredField');
            $('#descriptionError').text('');

        }

        function closeWarehouseModel() {

            $("#post-modal").modal('hide');

        }

        function editPost(event) {

            var id = $(event).data("id");
            let _url = `/warehouses/${id}`;
            $('#warehousecodeError').text('');
            $('#descriptionError').text('');
            $('#unitError').text('');
            $('#modalHeader').html('Edit Warehouse');

            $.ajax({
                url: _url,
                type: "GET",
                success: function(response) {
                    if (response) {
                        let res = JSON.parse(response);
                        $("#warehouse_id").val(res[0].id);
                        $("#warehouseCode").val(res[0].warehouseCode);
                        $("#Description").val(res[0].description);
                        $('#post-modal').modal('show');
                    }
                },
                error: function(response) {
                    alert("Something is error. Error details: " + res[0]);
                }
            });
        }

        function createPost() {

            var warehouseCode = $('#warehouseCode').val();
            var description = $('#Description').val();
            var id = $('#warehouse_id').val();
            let _url = `/warehouses`;
            let _token = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: _url,
                type: "POST",
                data: {
                    id: id,
                    warehouseCode: warehouseCode,
                    description: description,
                    _token: _token
                },
                success: function(response) {

                    if (response.code == 200) {
                        let res = JSON.parse(response.data);
                        if (id != "") {
                            $("#row_" + id + " td:nth-child(2)").html(res.data.warehouseCode);
                            $("#row_" + id + " td:nth-child(3)").html(res.data.Description);
                        } else {
                            $('table tbody').prepend('<tr id="row_' + res.data.id + '"><td>' + res.data.id +
                                '</td><td>' + res.data.warehouseCode + '</td><td>' + res.data.Description +
                                '</td><td><a href="javascript:void(0)" data-id="' + res.data.id +
                                '" onclick="editPost(event.target)" class="btn btn-info" style="width: 45%; padding: 6px 6px;"><i data-id="' +
                                res.data.id +
                                '" onclick="editPost(event.target)" class="fas fa-edit"></i></a><a href="javascript:void(0)" data-id="' +
                                res.data.id +
                                '" class="btn btn-danger" onclick="deletePost(event.target)" style="width: 45%; padding: 6px 6px;"><i data-id="' +
                                res.data.id +
                                '" onclick="deletePost(event.target)" class="fas fa-trash-alt"></i></a></td></tr>'
                            );
                        }

                        $('#warehouseCode').val('');
                        $('#Description').val('');
                        $('#post-modal').modal('hide');

                        Swal.fire({
                            position: 'middle',
                            icon: 'success',
                            title: 'Warehouse has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        })

                    }
                },
                error: function(response) {

                    if (response.responseJSON.errors.warehouseCode) {
                        $('#warehouseCode').addClass('requiredField');
                        $('#warehouseCodeError').text(response.responseJSON.errors.warehouseCode);
                    } else {
                        $('#warehouseCode').removeClass('requiredField');
                        $('#warehouseCodeError').text('');
                    }
                    if (response.responseJSON.errors.description) {
                        $('#Description').addClass('requiredField');
                        $('#descriptionError').text(response.responseJSON.errors.description);
                    } else {
                        $('#Description').removeClass('requiredField');
                        $('#descriptionError').text('');
                    }

                }
            });
        }

        function deletePost(event) {

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {

                    var id = $(event).data("id");
                    let _url = `/warehouses/${id}`;
                    let _token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: _url,
                        type: 'DELETE',
                        data: {
                            _token: _token
                        },
                        success: function(response) {
                            console.log('1');
                            $("#row_" + id).remove();
                            console.log('2');
                        }
                    });

                    Swal.fire(
                        'Deleted!',
                        'Warehouse has been deleted.',
                        'success'
                    )
                }
            })

        }

    </script>

@endsection

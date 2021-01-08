@extends('layout')

@section('content')
    <!DOCTYPE html>

    <div class="row">
        <div class="col-12 text-right">
            <div class="col-sm-6" style="float: left;">
                {{-- <h3 class="pull-left" style="margin: 0;">Items</h3>
                --}}
                <a href="javascript:void(0)" class="btn btn-success mb-3 pull-left" id="create-new-post"
                    onclick="addPost()">Add Item</a>
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
                    @foreach ($items as $item)
                        <tr id="row_{{ $item->id }}">
                            <td>{{ $item->id }}</td>
                            <td>{{ $item->itemCode }}</td>
                            <td>{{ $item->Description }}</td>
                            <td>{{ $item->unit }}</td>
                            <td>
                                <a href="javascript:void(0)" data-id="{{ $item->id }}" onclick="editPost(event.target)"
                                    class="btn btn-info" style="width: 45%; padding: 6px 6px;"><i data-id="{{ $item->id }}"
                                        onclick="editPost(event.target)" class="fas fa-edit"></i></a>
                                <a href="javascript:void(0)" data-id="{{ $item->id }}" onclick="deletePost(event.target)"
                                    class="btn btn-danger" style="width: 45%; padding: 6px 6px;"><i
                                        data-id="{{ $item->id }}" onclick="deletePost(event.target)"
                                        class="fas fa-trash-alt"></i></a>
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
                                    <input type="text" id="itemCode" name="itemCode" class="form-control"
                                        placeholder="Input Item Code">
                                    <span id="itemcodeError" class="alert-message"></span>
                                </div>
                                <div class="form-group">
                                    <strong>Description:</strong>
                                    <input type="text" id="Description" name="Description" class="form-control"
                                        placeholder="Input Description">
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

            var id = $(event).data("id");
            let _url = `/items/${id}`;
            $('#itemcodeError').text('');
            $('#descriptionError').text('');
            $('#unitError').text('');
            $('#modalHeader').html('Edit Item');

            $.ajax({
                url: _url,
                type: "GET",
                success: function(response) {
                    if (response) {
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
            let _url = `/items`;
            let _token = $('meta[name="csrf-token"]').attr('content');

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
                    if (response.code == 200) {
                        let res = JSON.parse(response.data);
                        // console.log(res);
                        // console.log(id);
                        if (id != "") {

                            $("#row_" + id + " td:nth-child(2)").html(res.data.itemCode);
                            $("#row_" + id + " td:nth-child(3)").html(res.data.Description);
                            $("#row_" + id + " td:nth-child(4)").html(res.data.unit);

                        } else {

                            $('table tbody').prepend('<tr id="row_' + res.data.id + '"><td>' + res.data.id +
                                '</td><td>' + res.data.itemCode + '</td><td>' + res.data.Description +
                                '</td><td>' + res.data.unit +
                                '</td><td><a href="javascript:void(0)" data-id="' + res.data.id +
                                '" onclick="editPost(event.target)" class="btn btn-info" style="width: 45%; padding: 6px 6px;"><i data-id="' +
                                res.data.id +
                                '" onclick="editPost(event.target)" class="fas fa-edit"></i></a><a href="javascript:void(0)" data-id="' +
                                res.data.id +
                                '" onclick="deletePost(event.target)" class="btn btn-danger" style="width: 45%; padding: 6px 6px;"><i data-id="' +
                                res.data.id +
                                '" onclick="deletePost(event.target)" class="fas fa-trash-alt"></i></a></td></tr>'
                            );

                        }

                        $('#itemCode').val('');
                        $('#Description').val('');
                        $('#unit').val('');
                        $('#post-modal').modal('hide');

                        Swal.fire({
                            position: 'middle',
                            icon: 'success',
                            title: 'Item has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        })

                    }
                },
                error: function(response) {
                    if (response.responseText) {
                        $('#itemCode').val('');
                        $('#Description').val('');
                        $('#unit').val('');
                        $('#post-modal').modal('hide');

                        Swal.fire({
                            position: 'middle',
                            icon: 'success',
                            title: 'Item has been saved',
                            showConfirmButton: false,
                            timer: 1500
                        })
                    }
                    else {
                        if (response.responseJSON.errors.itemCode) {
                            $('#itemCode').addClass('requiredField');
                            $('#itemcodeError').text(response.responseJSON.errors.itemCode);
                            console.log('erro1 daw');
                        } else {
                            $('#itemCode').removeClass('requiredField');
                            $('#itemcodeError').text('');
                        }
                        if (response.responseJSON.errors.Description) {
                            $('#Description').addClass('requiredField');
                            $('#descriptionError').text(response.responseJSON.errors.Description);
                        } else {
                            $('#Description').removeClass('requiredField');
                            $('#descriptionError').text('');
                        }
                        if (response.responseJSON.errors.unit) {
                            $('#unit').addClass('requiredField');
                            $('#unitError').text(response.responseJSON.errors.unit);
                        } else {
                            $('#unit').removeClass('requiredField');
                            $('#unitError').text('');
                            console.log('erro2 daw');
                        }
                    }
                }
            });
        }

        function deletePost(event) {

            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Continue Delete',
                cancelButtonText: 'Cancel',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {

                    var id = $(event).data("id");
                    let _url = `/items/${id}`;
                    let _token = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        url: _url,
                        type: 'DELETE',
                        data: {
                            _token: _token
                        },
                        success: function(response) {
                            $("#row_" + id).remove();
                        }
                    });

                    swalWithBootstrapButtons.fire(
                        'Deleted!',
                        'Item has been deleted.',
                        'success'
                    )
                } else if (
                    /* Read more about handling dismissals below */
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    swalWithBootstrapButtons.fire(
                        'Cancelled',
                        'Delete canceled!',
                        'error'
                    )
                }
            })
        }

    </script>

    {{-- <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    --}}
    <script src="//js.pusher.com/3.1/pusher.min.js"></script>
    {{-- <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous">
    </script> --}}

    <script type="text/javascript">
        var notificationsWrapper = $('.dropdown-notifications');
        var notificationsToggle = notificationsWrapper.find('a[data-toggle]');
        var notificationsCountElem = notificationsToggle.find('i[data-count]');
        var notificationsCount = parseInt(notificationsCountElem.data('count'));
        var notifications = notificationsWrapper.find('ul.dropdown-menu');
        if (notificationsCount <= 0) {
            notificationsWrapper.hide();
        }

        // Enable pusher logging - don't include this in production
        // Pusher.logToConsole = true;
        var pusher = new Pusher('ad7d614f8f158a381f64', {
            cluster: 'ap1',
            encrypted: true
        });

        // Subscribe to the channel we specified in our Laravel Event
        var channel = pusher.subscribe('items-updated');

        // Bind a function to a Event (the full Laravel class)
        channel.bind('App\\Events\\ItemsUpdated', function(data) {
            // console.log(data);
            if (data.submitType == 'add') {
                var markup = `<tr id="row_` + data.item.id + `">
                                                        <td>` + data.item.id + `</td>
                                                        <td>` + data.item.itemCode + `</td>
                                                        <td>` + data.item.Description + `</td>
                                                        <td>` + data.item.unit + `</td>
                                                        <td>
                                                            <a href="javascript:void(0)" data-id="` + data.item.id +
                    `" onclick="editPost(event.target)"
                                                                class="btn btn-info" style="width: 45%; padding: 6px 6px;"><i data-id="` +
                    data
                    .item.id + `"
                                                                    onclick="editPost(event.target)" class="fas fa-edit"></i></a>
                                                            <a href="javascript:void(0)" data-id="` + data.item.id + `" onclick="deletePost(event.target)"
                                                                class="btn btn-danger" style="width: 45%; padding: 6px 6px;"><i
                                                                    data-id="` + data.item.id + `" onclick="deletePost(event.target)"
                                                                    class="fas fa-trash-alt"></i></a>
                                                        </td>
                                                    </tr>`
                $("table tbody").append(markup);
            } else {
                $("#row_" + data.item.id + " td:nth-child(2)").html(data.item.itemCode);
                $("#row_" + data.item.id + " td:nth-child(3)").html(data.item.Description);
                $("#row_" + data.item.id + " td:nth-child(4)").html(data.item.unit);
            }
        });
        // {
        //     "id": 10050,
        //     "itemCode": "IT0006",
        //     "Description": "hard",
        //     "unit": "U006",
        //     "created_at": "2021-01-04T05:28:16.000000Z",
        //     "updated_at": "2021-01-04T05:42:42.000000Z"
        // } {
        //     "code": 200,
        //     "message": "Post Created successfully",
        //     "data": "{\"code\":200,\"message\":\"Item Created successfully\",\"data\":{\"id\":10050,\"itemCode\":\"IT0006\",\"Description\":\"hard\",\"unit\":\"U006\",\"created_at\":\"2021-01-04T05:28:16.000000Z\",\"updated_at\":\"2021-01-04T05:42:42.000000Z\"}}"
        // }

    </script>
@endsection

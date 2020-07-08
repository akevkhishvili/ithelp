@extends('layouts.master')

@section('content')
    @include('navigation.navigation')
    <br><br><br>
    <div class="container-fluid">
        <button onclick="create();" class="btn btn-sm btn-outline-primary mb-2">დამატება</button>
        <table class="table table-hover table-sm table-bordered col-4">
            <thead>
            <tr class="text-center">
                <th></th>
                <th>სახელი</th>
                <th>გვარი</th>
                <th>მეილი</th>
                <th>შიდა ნომერი</th>
                <th>მობილური</th>
                <th>ოთახი</th>
                <th>IP</th>
            </tr>
            </thead>
            @foreach($staffUsers as $staffUser)
                <tbody>
                <tr>
                    <td><button data-id="{{$staffUser->id}}" class="btn btn-sm btn-outline-danger" onclick="deleteUser(this);"><i class="fas fa-trash"></i></button></td>
                    <td><input class="form-control-sm" style="width: 150px" name="firstName" type="text" data-id="{{$staffUser->id}}" value="{{$staffUser->firstName}}" onkeyup="insert(this);"></td>
                    <td><input class="form-control-sm" style="width: 150px" name="lastName" type="text" data-id="{{$staffUser->id}}" value="{{$staffUser->lastName}}" onkeyup="insert(this);"></td>
                    <td><input class="form-control-sm" style="width: 200px" name="email" type="text" data-id="{{$staffUser->id}}" value="{{$staffUser->email}}" onkeyup="insert(this);"></td>
                    <td><input class="form-control-sm" style="width: 150px" name="phone" type="text" data-id="{{$staffUser->id}}" value="{{$staffUser->phone}}" onkeyup="insert(this);"></td>
                    <td><input class="form-control-sm" style="width: 150px" name="mobile" type="text" data-id="{{$staffUser->id}}" value="{{$staffUser->mobile}}" onkeyup="insert(this);"></td>
                    <td><input class="form-control-sm" style="width: 150px" name="room" type="text" data-id="{{$staffUser->id}}" value="{{$staffUser->room}}" onkeyup="insert(this);"></td>
                    <td><input class="form-control-sm" style="width: 150px" name="ipAddress" type="text" data-id="{{$staffUser->id}}" value="{{$staffUser->ipAddress}}" onkeyup="insert(this);"></td>
                </tr>
                </tbody>
            @endforeach
        </table>
    </div>
    <div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">დამატება</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="createRecord" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-12">
                                <label>სახელი</label>
                                <input id="firstName" name="firstName" type="text" class="form-control">
                                <span class="d-none text-danger" id="firstNameError">ველი სავალდებულოა</span>
                            </div>
                            <div class="form-group col-12">
                                <label>გვარი</label>
                                <input  id="lastName" name="lastName" type="text" class="form-control">
                                <span class="d-none text-danger" id="lastNameError">ველი სავალდებულოა</span>
                            </div>
                            <div class="form-group col-12">
                                <label>მეილი</label>
                                <input  id="email" name="email" type="text" class="form-control">
                                <span class="d-none text-danger" id="emailError">ველი სავალდებულოა</span>
                            </div>
                            <div class="form-group col-12">
                                <label>შიდა ნომერი</label>
                                <input  id="phone" name="phone" type="text" class="form-control">
                                <span class="d-none text-danger" id="phoneError">ველი სავალდებულოა</span>
                            </div>
                            <div class="form-group col-12">
                                <label>მობილური</label>
                                <input  id="mobile" name="mobile" type="text" class="form-control">
                                <span class="d-none text-danger" id="mobileError">ველი სავალდებულოა</span>
                            </div>
                            <div class="form-group col-12">
                                <label>ოთახი</label>
                                <input  id="room" name="room" type="text" class="form-control">
                                <span class="d-none text-danger" id="roomError">ველი სავალდებულოა</span>
                            </div>
                            <div class="form-group col-12">
                                <label>ip</label>
                                <input  id="ip" name="ip" type="text" class="form-control">
                                <span class="d-none text-danger" id="ipError">ველი სავალდებულოა</span>
                            </div>
                        </div>
                        <div class="modal-footer justify-content-center">
                            <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">დახურვა</button>
                            <button type="submit" class="btn btn-sm btn-outline-primary">დამატება</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>

        function create(){
            $('#createModal').modal('show');
        }

        $("#createRecord").on('submit', function(event){
            event.preventDefault();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: "{{route('staffUserCreate')}}",
                type: 'POST',
                data:new FormData(this),
                dataType:'JSON',
                contentType: false,
                cache: false,
                processData: false,
                success: function (data) {
                    $('#createModal').modal('hide');
                    $('#tablereload').html(data.html); //reload only table
                    swal("ჩანაწერი დაემატა!", "success");
                },
                error: function (data) {
                    $('#firstNameError').addClass('d-none');
                    $('#ipError').addClass('d-none');
                    $('#lastNameError').addClass('d-none');
                    $('#emailError').addClass('d-none');
                    $('#phoneError').addClass('d-none');
                    $('#mobileError').addClass('d-none');
                    $('#roomError').addClass('d-none');
                    var errors = data.responseJSON;
                    if ($.isEmptyObject(errors) == false) {
                        $.each(errors.errors, function (key, value) {
                            var ErrorId = '#' + key + 'Error';
                            $(ErrorId).removeClass('d-none');
                            $(ErrorId).addClass('text-danger');
                            $(ErrorId).text(value);
                            $(ErrorId).focus();

                        });
                    }
                }
            });

        });

        function insert(arg){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var id = $(arg).attr("data-id");
            var value = arg.value;
            var name = arg.name;
            $.ajax({

                type: 'POST',
                url: "{{route('staffUserEdit')}}",
                data: {_token: CSRF_TOKEN,
                    id:id,
                    value:value,
                    name:name,
                },
                dataType:'JSON',

                success: function (data) {

                }
            });
        }

        function deleteUser(arg) {
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            const id = $(arg).attr("data-id");
            $.ajax({

                type: 'POST',
                url: "{{route('staffdelete')}}",
                data: {_token: CSRF_TOKEN,
                    id:id
                },
                dataType:'JSON',

                success: function (data) {

                    window.location.reload()
                }
            });
        }
    </script>
@endsection








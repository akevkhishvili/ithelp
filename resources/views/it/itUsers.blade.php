@extends('layouts.master')

@section('content')
 @include('navigation.navigation')
    <br><br><br>
    <div class="col-md-4 col-12">
        <h5 class="text-center">IT ჯგუფი</h5>
    </div>
    <div class="container-fluid">
        <button onclick="create();" class="btn btn-sm btn-outline-primary mb-2">დამატება</button>
        <table class="table table-hover table-sm table-bordered col-4">
            <thead>
            <tr>
                <th>მოქმედება</th>
                <th>სახელი</th>
                <th>გვარი</th>
                <th>მეილი</th>
            </tr>
            </thead>
            @foreach($itUsers as $itUser)
                <tbody>
                <tr>
                    <td><button value="{{$itUser->id}}" class="btn btn-sm btn-outline-danger" onclick="deleteUser(this);"><i class="fas fa-trash"></i></button>
                        <button value="{{$itUser->id}}"
                                data-firstName="{{$itUser->s_firstName}}"
                                data-lastName="{{$itUser->s_lastName}}"
                                data-email="{{$itUser->email}}" class="btn btn-sm btn-outline-warning" onclick="openEditModal(this);"><i class="fas fa-user-edit"></i></button></td>
                    <td>{{$itUser->s_firstName}}</td>
                    <td>{{$itUser->s_lastName}}</td>
                    <td>{{$itUser->email}}</td>
                </tr>
                </tbody>
            @endforeach
        </table>
    </div>

    <!--create Modal -->
    <div class="modal fade" id="createRecord" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">დამატება</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
               <div class="row">
                   <div class="form-group col-12">
                       <label>სახელი</label>
                       <input id="s_firstName" type="text" class="form-control">
                       <span class="d-none text-danger" id="s_firstNameError">ველი სავალდებულოა</span>
                   </div>
                   <div class="form-group col-12">
                       <label>გვარი</label>
                       <input  id="s_lastName" type="text" class="form-control">
                       <span class="d-none text-danger" id="s_lastNameError">ველი სავალდებულოა</span>
                   </div>
                   <div class="form-group col-12">
                       <label>მეილი</label>
                       <input  id="email" type="text" class="form-control">
                       <span class="d-none text-danger" id="emailError">ველი სავალდებულოა</span>
                   </div>
                   <div class="form-group col-12">
                       <label>პაროლი</label>
                       <input value="" id="s_password" type="password" class="form-control">
                       <span class="d-none text-danger" id="emailError">ველი სავალდებულოა</span>
                   </div>
               </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">დახურვა</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="insert();">შენახვა</button>
                </div>
            </div>
        </div>
    </div>

    <!--edit Modal -->
    <div class="modal fade" id="editRecord" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">დამატება</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <input type="hidden" id="recordEditId">
                        <div class="form-group col-12">
                            <label>სახელი</label>
                            <input value="" id="s_firstNameEdit" type="text" class="form-control">
                            <span class="d-none text-danger" id="s_firstNameError">ველი სავალდებულოა</span>
                        </div>
                        <div class="form-group col-12">
                            <label>გვარი</label>
                            <input  id="s_lastNameEdit" type="text" class="form-control">
                            <span class="d-none text-danger" id="s_lastNameError">ველი სავალდებულოა</span>
                        </div>
                        <div class="form-group col-12">
                            <label>მეილი</label>
                            <input value="" id="emailEdit" type="text" class="form-control">
                            <span class="d-none text-danger" id="emailError">ველი სავალდებულოა</span>
                        </div>
                        <div class="form-group col-12">
                            <label>პაროლი</label>
                            <input value="" id="s_passwordEdit" type="password" class="form-control">
                            <span class="d-none text-danger" id="s_passwordEditError">ველი სავალდებულოა</span>
                        </div>

                    </div>
                </div>
                <div class="modal-footer justify-content-center">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">დახურვა</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="editUser();">შენახვა</button>
                </div>
            </div>
        </div>
    </div>

    <script>
       function create(){
        $('#createRecord').modal('show');
        }
        function insert(){
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var s_firstName = $('#s_firstName').val();
            var s_lastName = $('#s_lastName').val();
            var email = $('#email').val();
            var s_password = $('#s_password').val();


            if (s_firstName === ""){
                $('#s_firstNameError').removeClass("d-none");
                $('#s_firstName').addClass("is-invalid");
                return;
            } else{
                $('#s_firstNameError').addClass("d-none");
                $('#s_firstName').removeClass("is-invalid");
                $('#s_firstName').addClass("is-valid");
            }

            if (s_lastName === ""){
                $('#s_lastNameError').removeClass("d-none");
                $('#s_lastName').addClass("is-invalid");
                return;
            } else{
                $('#s_lastNameError').addClass("d-none");
                $('#s_lastName').removeClass("is-invalid");
                $('#s_lastName').addClass("is-valid");
            }

            if (email === ""){
                $('#emailError').removeClass("d-none");
                $('#email').addClass("is-invalid");
                return;
            } else{
                $('#emailError').addClass("d-none");
                $('#email').removeClass("is-invalid");
                $('#email').addClass("is-valid");
            }

            $.ajax({

                type: 'POST',
                url: "{{route('itUserInsert')}}",
                data: {_token: CSRF_TOKEN,
                    s_firstName:s_firstName,
                    s_lastName:s_lastName,
                    password:s_password,
                    email:email,
                },
                dataType:'JSON',

                success: function (data) {
                    $('#createRecord').modal('hide');
                    swal("", "ჩანაწერი წარმატებით დაემატა!", "success")
                .then(() => {
                        location.reload();
                    });

                }
            });

        }


       function openEditModal(arg){
           $('#editRecord').modal('show');
           var id = arg.value;
           var s_firstNameEdit = $(arg).attr("data-firstName");
           var s_lastNameEdit = $(arg).attr("data-lastName");
           var emailEdit = $(arg).attr("data-email");

           $('#recordEditId').val(id);
           $('#s_firstNameEdit').val(s_firstNameEdit);
           $('#s_lastNameEdit').val(s_lastNameEdit);
           $('#emailEdit').val(emailEdit);
       }

       function editUser(arg){

           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
           var id = $('#recordEditId').val();
           var s_firstName = $('#s_firstNameEdit').val();
           var s_lastName = $('#s_lastNameEdit').val();
           var email = $('#emailEdit').val();
           var s_passwordEdit = $('#s_passwordEdit').val();


           $.ajax({

               type: 'POST',
               url: "{{route('itUserEdit')}}",
               data: {_token: CSRF_TOKEN,
                   id:id,
                   s_firstName:s_firstName,
                   s_lastName:s_lastName,
                   email:email,
                   password:s_passwordEdit,
               },
               dataType:'JSON',

               success: function (data) {
                   $('#editRecord').modal('hide');
                   swal("", "ჩანაწერი რედაქტირებულია!", "success")
                       .then(() => {
                           location.reload();
                       });
               }
           });

       }
       function deleteUser(arg){
           var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
           var id = arg.value;

           swal({
               title: "ჩანაწერის წაშლა",
               text: "დარწმუნებული ხართ, რომ გინდათ ჩანაწერის წაშლა?",
               icon: "warning",
               buttons: true,
               dangerMode: true,
           })
               .then((willDelete) => {
                   if (willDelete) {
                       $.ajax({

                           type: 'POST',
                           url: "{{route('itUserDelete')}}",
                           data: {_token: CSRF_TOKEN,
                               id:id,
                           },
                           dataType:'JSON',

                           success: function (data) {

                               swal("ჩანაწერი წაიშალა", {
                                   icon: "success",
                               })
                           .then(() => {
                                   location.reload();
                               });
                           }
                       });

                   } else {
                       swal("მოქმედება შეწყვეტილია!");
                   }
               });





       }


    </script>

@endsection

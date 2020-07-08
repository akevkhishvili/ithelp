@extends('layouts.master')

@section('content')
    @include('navigation.navigation')
    <br><br><br>



    <div class="container-fluid">
        <div class="row" id="itHomeRowDiv">
            <div class="col-md-9">
                <table class="table table-bordered table-hover table-sm text-nowrap font12">
                    <thead>
                    <tr class="text-center">
                        <th>სტატუსი</th>
                        <th>თარიღი</th>
                        <th class="hideForChat">მიმაგრებულია</th>
                        <th class="hideForChat">ქეისი აიღო</th>
                        <th>გამომგზავნი</th>
                        <th>ოთახი</th>
                        <th>ნომერი</th>
                        <th>ქეისი</th>
                        <th>მოქმედება</th>
                        <th>გადაცემა</th>
                        <th style="width: 4%"><button class="btn btn-sm disabled"><i class="far fa-envelope"></i></button></th>
                    </tr>
                    </thead>
                    @foreach($cases as $case)
                        <tbody>
                        <tr class="text-white font12 @if($case->status == 'აქტიური')bg-Red @elseif($case->status == 'მიმაგრებულია') bg-Salmon @elseif($case->status == 'დახურული') bg-Green @elseif($case->status == 'მუშავდება') bg-info @else bg-secondary  @endif"`>
                            <td>{{$case->status}}</td>
                            <td>{{$case->created_at}}</td>
                            <td class="hideForChat">{{$case->stacked_to}}</td>
                            <td class="hideForChat">{{$case->accepted_by}}</td>
                            <td>{{$case->firstName}} {{$case->lastName}}</td>
                            <td>{{$case->room}}</td>
                            <td>{{$case->phone}}</td>
                            <td><a name="{{$case->casetext}}" onclick="showCase(this)">{{$case->subject}}</a> </td>
                            <td class="bg-white text-center">
                                <button data-subject="{{$case->subject}}" value="{{$case->id}}" onclick="finishCase(this);"
                                        class="btn btn-sm btn-outline-success"
                                        @if($case->status != 'აქტიური' && $case->status != 'მუშავდება' &&  $case->status != 'მიმაგრებულია') disabled @endif>დახურვა
                                </button>

                                <button class="btn btn-warning btn-sm" value="{{$case->id}}" onclick="acceptCase(this)"
                                        @if($case->status != 'აქტიური'&& $case->status != 'მიმაგრებულია') disabled @endif>მე გავაკეთებ
                                </button>

                                {{-- <button class="btn btn-outline-info btn-sm" value="{{$case->id}}" onclick="forwardCase(this)"
                                         @if($case->status != 'აქტიური' && $case->status != 'მუშავდება') disabled @endif><i class="fas fa-arrow-right"></i>
                                 </button>--}}
                            </td>
                            <td class="bg-white text-center">
                                <select data-recordID="{{$case->id}}" onchange="forwardCase(this)" class="form-control-sm col"
                                        @if($case->status != 'აქტიური' && $case->status != 'მუშავდება'&& $case->status != 'მიმაგრებულია') disabled @endif>
                                    <option></option>
                                    @foreach($supportTeam as $member)
                                        <option value="{{$member->s_firstName}} {{$member->s_lastName}}">{{$member->s_firstName}} {{$member->s_lastName}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="text-center @if(empty($case->itResponse)) bg-white
                                        @elseif($case->itResponseRead == 1) bg-success @else bg-danger  @endif" style="width: 4%"><button class="btn btn-sm" value="{{$case->id}}" onclick="sendBackMessage(this)">
                                    @if($case->itResponseRead == 1) <i class="far fa-envelope-open"></i> @else <i class="far fa-envelope"></i>@endif</button></td>
                        </tr>
                        </tbody>
                    @endforeach
                </table>
            </div>

        </div>
    </div>


    <div class="modal fade" id="sendBackMessage" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="mr-3 far fa-envelope"></i>ქეისზე პასუხის გაცემა</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input id="caseId" type="hidden">
                    <textarea class="form-control" id="itResponse" rows="5"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-sm btn-primary" onclick="postItResponse()">გაგზავნა</button>
                </div>
            </div>
        </div>
    </div>

    <script>

        //მოდალის გახსნა
        function sendBackMessage(arg){
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            const caseId = $(arg).val();
            $("#itResponse").val("");
            $("#caseId").val(caseId);
            $.ajax({
                url: "{{route('getItResponse')}}",
                type: 'POST',
                data: {_token: CSRF_TOKEN,
                    caseId:caseId,
                },
                dataType: 'json',
                success: function (data) {
                    //console.log(data[0]);
                    $("#itResponse").val(data[0]);
                }
            });
            $('#sendBackMessage').modal('show');

        }


        //send case itResponse
        function postItResponse() {
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            const caseId = $("#caseId").val();
            const value = $("#itResponse").val();

            $.ajax({
                url: "{{route('postItResponse')}}",
                type: 'POST',
                data: {_token: CSRF_TOKEN,
                    caseId:caseId,
                    value:value
                },
                dataType: 'json',
                success: function (data) {
                    $('#sendBackMessage').modal('hide');
                }
            });
        }

        //page auto reloat
        /*  $(document).ready(function() {
            setInterval(function() {
                cache_clear()
            }, 60000);
        });

        function cache_clear() {
            window.location.reload(true);
            // window.location.reload(); use this if you do not remove cache
        }*/

        //get chat msg (ახალი მესიჯის ამოღება და ჩასმა ჩათში)
        $(document).ready(function() {
            setInterval(function() {
                updateChat();
                chekNewMessage();
            }, 5000);
        });
        function chekNewMessage() {
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            const myID = $("#myID").val();
            //  console.log(myID);
            $.ajax({
                url: "{{route('getMessagesCount')}}",
                type: 'POST',
                data: {_token: CSRF_TOKEN,
                    //myID:myID
                },
                dataType: 'json',
                success: function (data) {
                    const value = data[0];
                    //console.log(data[0]);
                    if(value != 0) {
                        const badge = "<span id='itChatButtonBadge' class='badge badge-danger badge-pill float-right'>" + value + "</span>";
                        $("#itChatButtonBadge").remove();
                        $("#itChatButton").append(badge);
                    }
                }
            });

        }

        function updateChat() {
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            const userId = $("#chatUserName").attr('data-id');
            if(userId == ''){
                return true;
            }
            const myID = $("#myID").val();
            const from = "IT";
            $.ajax({
                url: "{{route('getChatMessages')}}",
                type: 'POST',
                data: {_token: CSRF_TOKEN,
                    myID:myID,
                    userId:userId,
                    from:from},
                dataType: 'json',
                success: function (data) {
                    $.each(data[1], function (key, value) {
                        const hasNewMessageIt = value.hasNewMessageIt;

                        if(hasNewMessageIt == 1){
                            //console.log(hasNewMessageIt);
                            $('#chatWindowDiv').empty();
                            $.each(data[0], function (key, value) {
                                var msg =  value.text;
                                var sender = value.sender;
                                var time = value.created_at;
                                if(sender == myID){
                                    messageBody = "<div class=' offset-4 mt-2'><div class='p-1 font10 text-danger text-right'>" +time+ "</div><div class='bg-primary font10 text-white p-2 rounded'>" +msg+ "</div><div>";
                                    $('#chatWindowDiv').append(messageBody);
                                    $('#leftmenuinnerinner').scrollTop($('#leftmenuinnerinner')[0].scrollHeight);
                                }else {
                                    messageBody = "<div class='col-8 mt-2'><div class='p-1 font10 text-danger'>" +time+ "</div><div class='bg-WhiteSmoke font10 text-dark p-2 rounded'>" +msg+ "</div><div>";
                                    $('#chatWindowDiv').append(messageBody);
                                    $('#leftmenuinnerinner').scrollTop($('#leftmenuinnerinner')[0].scrollHeight);
                                }
                            });
                        }
                    })
                }
            });
        }


        //listen msgText chat Enter Hit !!!!
        function listenMsgTextEnterKey(e) {
            if(e.which === 13) {
                postMessage();
            }
        }
        //remove chat
        function removeChatWindow() {
            $(".verticalScroll").remove();
        }

        //post massage
        function postMessage() {
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            const member1 = $("#chatUserName").attr('data-id');
            const member2 = $("#myID").val();
            const myID = $("#myID").val();
            const message = $("#msgText").text();
            $("#msgText").empty();
            //console.log(message);
            $.ajax({
                url: "{{route('postMessageIt')}}",
                type: 'POST',
                dataType: 'json',
                data: {_token: CSRF_TOKEN,
                    member1:member1,
                    member2:member2,
                    message:message},

                success: function (data) {
                    const date = new Date();
                    const time = date.getHours() + ":" + date.getMinutes() + ":" + date.getSeconds();
                    if(member2 == myID){
                        messageBody = "<div class=' offset-4 mt-2'><div class='p-1 font10 text-danger text-right'>" +time+ "</div><div class='bg-primary font10 text-white p-2 rounded'>" +message+ "</div><div>";
                        $('#chatWindowDiv').append(messageBody);
                        $('#leftmenuinnerinner').scrollTop($('#leftmenuinnerinner')[0].scrollHeight);
                    }else {
                        messageBody = "<div class='col-8 mt-2'><div class='p-1 font10 text-danger'>" +time+ "</div><div class='bg-WhiteSmoke font10 text-dark p-2 rounded'>" +message+ "</div><div>";
                        $('#chatWindowDiv').append(messageBody);
                        $('#leftmenuinnerinner').scrollTop($('#leftmenuinnerinner')[0].scrollHeight);
                    }

                }
            });
        }

        //open chat window IT
        function openChatWindowIt(arg) {
            removeChatListIt();
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            const userName = $(arg).text();
            const userId = $(arg).attr('data-id');
            const myID = $("#myID").val();
            const from = "IT";
            const outerChatDiv = "<div style='max-height: 65vh; z-index: 99' class='verticalScroll col-3 card' id='outerChatDiv'><div class='card p-2'>\n" +
                "                <div class='row'>\n" +
                "                    <div class='col-1'>\n" +
                "                        <i class='fas fa-user'></i>\n" +
                "                    </div>\n" +
                "                    <div class='col-9'>\n" +
                "                        <span id='chatUserName' class='ml-2'></span>\n" +
                "                    </div>\n" +
                "                    <div class='col-1'>\n" +
                "                        <i onclick='removeChatWindow()' style='color: red' class='fas fa-times'></i>\n" +
                "                    </div>\n" +
                "                </div>\n" +
                "            </div>\n" +
                "            <div class='card' id='leftmenuinnerinner' data-id=''>\n" +
                "                <div class='p-1' id='chatWindowDiv'></div></div><div id='chatBoxDiv' class=''><div class='card'><div onchange='listenMsgTextEnterKey(this)' id='msgText' class='p-1' contenteditable='true'  type='text'></div>\n" +
                "                    <div  class='p-1'><i onclick='postMessage()' style='color: #298fe2' class='fas fa-play float-right'></i></div></div></div></div>";
            $("#itHomeRowDiv").append(outerChatDiv);
            $("#chatUserName").empty().text(userName).attr('data-id', userId);
            $("#chatWindowDiv").empty();
//get chat messages
            $.ajax({
                url: "{{route('getChatMessages')}}",
                type: 'POST',
                data: {_token: CSRF_TOKEN,
                    myID:myID,
                    userId:userId,
                    from:from},

                success: function (data) {

                    $.each(data[0], function (key, value) {
                        var msg =  value.text;
                        var sender = value.sender;
                        var time = value.created_at;
                        // var time = time.getHours() + ":" + time.getMinutes() + ":" + time.getSeconds();
                        if(sender == myID){
                            messageBody = "<div class=' offset-4 mt-2'><div class='p-1 font10 text-danger text-right'>" +time+ "</div><div class='bg-primary font10 text-white p-2 rounded'>" +msg+ "</div><div>";
                            //messageBody = "<div class='offset-4'><div class='mb-2'><span class='font10 text-danger float-right'>"+ time +"</span><span class='font10 text-danger float-right '></span></div><br><div class='bg-primary rounded p-1 font10 text-white m-1 p-2'<span class=''>"+msg+"</span></div></div>";
                            $('#chatWindowDiv').append(messageBody);
                            $('#leftmenuinnerinner').scrollTop($('#leftmenuinnerinner')[0].scrollHeight);
                        }else {
                            messageBody = "<div class='col-8 mt-2'><div class='p-1 font10 text-danger'>" +time+ "</div><div class='bg-WhiteSmoke font10 text-dark p-2 rounded'>" +msg+ "</div><div>";

                            // messageBody = "<div class='col-8 bg-WhiteSmoke  m-1 p-2 rounded text-left'><span class='font10 text-danger float-right'>"+ time +"</span><span  class='font10 text-black '>" + msg + "</span></div>";
                            $('#chatWindowDiv').append(messageBody);
                            $('#leftmenuinnerinner').scrollTop($('#leftmenuinnerinner')[0].scrollHeight);
                        }
                    });
                    // chatWindowDiv
                }
            });
        }
        //open chat user list
        function addChatListIt() {
            const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $(".verticalScroll").remove();
            $(".hideForChat").addClass('d-none');
            const removeCatButton = "<button class='btn btn-outline-danger btn-sm rounded-circle' onclick='removeChatListIt()'><i class='fas fa-comment-slash'></i></button>";
            $("#itChatButton").empty().append(removeCatButton);
            $.ajax({
                url: "{{route('getStaffMembersForChat')}}",
                type: 'POST',
                data: {_token: CSRF_TOKEN,},
                success: function (data) {
                    // console.log(data[1]);
                    const outerChatDiv = "<div style='max-height: 65vh' class='verticalScroll col-3 card' id='outerChatDiv'></div>";
                    $("#itHomeRowDiv").append(outerChatDiv);
                    $.each(data[0], function (key, value) {
                        let id =  value.id;
                        let firstName =  value.firstName;
                        let lastName =  value.lastName;

                        const chatList = "<div  class=' list-group '><a onclick='openChatWindowIt(this)' data-id='"+id+"' class='moverHblue list-group-item-action rounded font12 p-1'>&nbsp; " +lastName+ " " +firstName+ " <span class='badge badge-danger badge-pill float-right' id='newMsg"+id+"'></span></a></div>";
                        $("#outerChatDiv").append(chatList);
                    });

                    $.each(data[1], function (key, value) {
                        let id =  value.member2;
                        newId = "#"+"newMsg"+id;
                        let newMsg =  value.hasNewMessageIt;
                        if(newMsg == 1){
                            $(newId).text("new");
                        }
                    });

                }
            });
        }

        function removeChatListIt() {

            const addChatButton = "<button class='btn btn-outline-success btn-sm rounded-circle' onclick='addChatListIt()'><i class='far fa-comment-dots'></i></button>";
            $("#itChatButton").empty().append(addChatButton);
            $(".verticalScroll").remove();
            $(".hideForChat").removeClass('d-none');
        }


        function finishCase(arg) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var subject = $(arg).attr("data-subject");
            var status = 'დახურული';
            var id = arg.value;
            swal({
                title: "ქეისის დახურვა",
                text: subject,
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{route('closeCase')}}",
                            type: 'POST',
                            dataType: 'json',
                            data: {_token: CSRF_TOKEN, id:id, status:status },

                            success: function (data) {

                                swal("ქეისი წარმატებით დაიხურა", "", "success")

                                    .then(() => {
                                        location.reload();
                                    });

                            }
                        });
                    } else {
                        swal("მოქმედება გაუქმებულია");
                    }
                });
        }
        function showCase(arg) {
            var caseText = arg.name;
            //alert(caseText);
            swal("ქეისი", caseText);

        }
        function forwardCase(arg) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var recordID = $(arg).attr("data-recordID");
            var id = arg.value;
            swal({
                title: "",
                text: "ნამდვილად გსურთ ქეისის გადამისამართება?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{route('forwardCase')}}",
                            type: 'POST',
                            dataType: 'json',
                            data: {_token: CSRF_TOKEN, id:id, recordID:recordID},

                            success: function (data) {

                                swal("ქეისი წარმატებით გადამისამართდა", "", "success")

                                    .then(() => {
                                        location.reload();
                                    });

                            }
                        });
                    } else {
                        swal("მოქმედება გაუქმებულია");
                    }
                });
        }

        function acceptCase(arg) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var status = 'მუშავდება';
            var id = arg.value;
            swal({
                title: "ქეისის მიღება",
                text: "",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            url: "{{route('acceptCase')}}",
                            type: 'POST',
                            dataType: 'json',
                            data: {_token: CSRF_TOKEN, id:id, status:status },

                            success: function (data) {

                                swal("ქეისი მიღებულია", "", "success")

                                    .then(() => {
                                        location.reload();
                                    });

                            }
                        });
                    } else {
                        swal("მოქმედება გაუქმებულია");
                    }
                });


        }

        function logout() {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                url: "{{ route('logout') }}",
                type: 'POST',
                dataType: 'json',
                data: {_token: CSRF_TOKEN,},

                success: function (data) {


                }
            });
            location.reload();
        }
    </script>
@endsection

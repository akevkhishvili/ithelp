<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ITHELP</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.6.9/angular.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
</head>
<body>
!test
<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <h6 class="text-info "><a href="{{route('login')}}">ადმინ პანელი</a></h6>
    <h1 class="text-center text-info navbar-text col">ITHELP</h1>
    <div id="chatButton">
        <button class="btn btn-outline-success btn-sm rounded-circle" onclick="addChatList()"><i class="far fa-comment-dots"></i></button>
    </div>

</nav>

<div class="container-fluid" >
    <div class="row" id="mainRow">
        <div class="col-md-6 col-6 offset-md-3" id="caseDiv">
            <div class=" col-12">
                <div class="form-group">
                    <ul class="list-group">
                        <li class="list-group-item py-1"><span style="float: left;width: 100px;">თარიღი:</span> <span class="text-danger">{{ date('d-m-Y H:i:s') }}</span></li>
                        <li class="list-group-item py-1"><span style="float: left;width: 100px;">სახელი:</span><span class="text-danger">{{$user->lastName}} {{$user->firstName}}</span> |
                            <span class="text-danger">{{$user->email}}</span> <input type="hidden" id="staffId" value="{{$user->id}}">|
                            <span>{{$user->room}}</span></li>
                        <li class="list-group-item py-1 d-none"><span style="float: left;width: 100px;">ადრესატი:</span>
                            <select name="to" id="to" class="form-control-sm col-md-4 col-12">
                                @foreach($supportTeam as $member)
                                    <option value="{{$member->id}}">{{$member->s_firstName}} {{$member->s_lastName}}</option>
                                @endforeach
                            </select>
                        </li>
                        <li class="list-group-item py-1"><span style="float: left;width: 100px;">ქეისი:</span>
                            <select name="case" id="case" class="form-control col-md-8 col-12">
                                <option value="">აირჩიეთ</option>
                                @foreach($caseOptions as $option)
                                    <option value="{{$option->caseName}}">{{$option->caseName}}</option>
                                @endforeach
                                <option value="სხვა">სხვა</option>
                            </select>
                        </li>
                        <li class="list-group-item py-1"><span style="float: left;width: 350px;">გსურთ მიიღოთ მეილით დასტური?</span>
                            <select name="reciveEmail" id="reciveEmail" class="form-control col-md-2 col-12">
                                <option value="">არა</option>
                                <option value="1">დიახ</option>
                            </select>
                        </li>
                    </ul>
                    <textarea id="caseText" rows="6" class="form-control" placeholder="აღწერეთ შემთხვევა"></textarea>
                </div>
                <span class="justify-content-center d-flex mb-3">
                    <button id="openCaseBtn" class="btn btn-sm btn-info" onclick="openCase(this);">ქეისის გახსნა</button>
                </span>
            </div>
        </div>

        {{-- *** Chat Box ***--}}
        <div id="chatBoxDivOuter"  style="height: 55vh; z-index: 99 /*position:absolute; left:100vh*/" class="col-md-3 col-12  d-none">
            <div class="card p-2">
                <div class="row">
                    <div class="col-1">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="col-9">
                        <span id="chatUserName" class="ml-2"></span>
                    </div>
                    <div class="col-1">
                        <i onclick="removeChatWindow()" style="color: red" class="fas fa-times"></i>
                    </div>
                </div>
            </div>
            <div class="card" id="leftmenuinnerinner" data-id="">
                <div class="p-1" id="chatWindowDiv">

                </div>
            </div>
            <div id="chatBoxDiv" class="">
                <div class="card">
                    <div id="msgText" class="p-1" contenteditable="true"  type="text">

                    </div>
                    <div  class="p-1"><i onclick="postMessage()" style="color: #298fe2" class="fas fa-play float-right"></i></div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="container col-10 position-relative offset-1">
    <table class="table table-sm table-bordered table-hover text-nowrap font10">
        <thead>
        <tr>
            <td class="">მოქმედება</td>
            <td class="w-20">თარიღი</td>
            {{-- <td class="w-20">მიმღები</td>--}}
            <td class="w-20">ქეისი</td>
            <td class="w-25">სტატუსი</td>
            <td style="width: 4%"><button class="btn btn-sm disabled text-center"><i class="far fa-envelope"></i></button></td>

        </tr>

        </thead>
        @foreach($cases as $case)
            <tbody>
            <tr class="@if ($case->status == "დახურული") bg-secondary text-white @elseif($case->status == "გაუქმებული") bg-secondary text-white @else bg-success text-white @endif">
                <td style="width: 10%"><button value="{{$case->id}}"
                                               class="btn btn-danger btn-sm" onclick="closeCase(this);"
                                               @if($case->status !='აქტიური')disabled @endif>გაუქმება</button>
                <td style="width:  20%">{{$case->created_at}}</td>
                {{--<td  style="width:  20%">{{$case->firstName}} {{$case->lastName}}</td>--}}
                <td><a class="@if ($case->status == "დახურული") @else text-white @endif" name="{{$case->casetext}}" onclick="showCase(this)">{{$case->subject}}</a> </td>
                <td style="width: 10%">
                    @php
                        if($case->status == "აქტიური"){
                        echo ("ქეისი აქტიურია");
                        }elseif($case->status == "მიმაგრებულია"){
                         echo("ქეისი მუშავდება");
                         }elseif($case->status == "დახურული"){
                          echo ("ამოცანა დასრულებულია");
                         }elseif ($case->status == "მუშავდება"){
                          echo("ქეისი მუშავდება");
                         }elseif ($case->status == "გაუქმებული"){
                          echo("ქეისი გაუქმებულია");
                    }
                    @endphp
                </td>
                <td id="itresponse{{$case->id}}" class="bg-white text-center">
                @if($case->itResponseRead == 2)
                <button class="btn btn-sm "><i class="far fa-envelope" id="{{$case->id}}" onclick="openitResponseText(this)"></i></button>
                    @elseif($case->itResponseRead ==1) <button class="btn btn-sm center"><i class='far fa-envelope-open'  id="{{$case->id}}" onclick="openitResponseText(this)"></i></button>
                @endif
                </td>
            </tr>
            </tbody>
        @endforeach
    </table>
</div>

<div class="modal fade" id="itResponseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="itResponseReadHeader"></h6>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <textarea readonly class="form-control" id="itResponseRead" rows="5"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">დახურვა</button>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {
        setInterval(function() {
            updateChat();
            getItResponseForUser();
            chekNewMessageUser()
        }, 5000);
    });

    function chekNewMessageUser() {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        const staffMemberId = $("#staffId").val();
        //  console.log(myID);
        $.ajax({
            url: "{{route('getMessagesCountUser')}}",
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                staffMemberId:staffMemberId
            },
            dataType: 'json',
            success: function (data) {
                const value = data[0];

                if(value != 0) {
                    const badge = "<span id='ChatButtonBadge' class='badge badge-danger badge-pill float-right'>" + value + "</span>";
                    $("#ChatButtonBadge").remove();
                    $("#chatButton").append(badge);
                }

                $.each(data[1], function (key, value) {
                    //console.log(value.hasNewMessage);
                    let id =  value.member1;
                    newId = "#"+"newMsg"+id;
                    let newMsg =  value.hasNewMessage;
                    if(newMsg == 1){
                        $(newId).text("new");
                    }
                });
            }
        });

    }


    function openitResponseText(e) {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        const userId = $("#staffId").val();
        const caseId = $(e).attr('id');
        $("#itResponseReadHeader").empty();
        $("#itResponseRead").empty();

        $('#itResponseModal').modal('show');

        $.ajax({
            url: "{{route('getItResponseForUser')}}",
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                userId:userId,
                caseId:caseId,
            },
            dataType: 'json',
            success: function (data) {

                $.each(data[0], function (key, value) {

                    const itResponse = value.itResponse;
                    const itMember = value.itResponsePerson;
                    //console.log(itMember);
                    $("#itResponseRead").val(itResponse);
                    $("#itResponseReadHeader").text("გპასუხობთ: "+itMember)
                })
            }
        });
    }




    function getItResponseForUser(){
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        const userId = $("#staffId").val();

        $.ajax({
            url: "{{route('getItResponseForUser')}}",
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                userId:userId,
            },
            dataType: 'json',
            success: function (data) {
                //console.log(data[0]);
                $.each(data, function (key, value) {
                    $.each(value, function(key2, value2){
                        const id = value2.id;
                        const tdId = "#itresponse"+id;
                        const itRespons = value2.itResponseRead;
                        if(itRespons === 2) {
                            //console.log(itRespons);
                            const value = "<button class='btn btn-sm' id=" + id + " onclick=(openitResponseText(this))><i class='far fa-envelope'></i></button>";
                            $(tdId).empty();
                            $(tdId).append(value);
                        }
                        else if(itRespons ===1){
                            const value = "<button class='btn btn-sm' id=" + id + " onclick=(openitResponseText(this))><i class='far fa-envelope-open'></i></button>";
                            $(tdId).empty();
                            $(tdId).append(value);
                        }
                        else{
                            $(tdId).empty();
                        }
                    })

                })

            }
        });
    }



    function updateChat() {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        const userId = $("#chatUserName").attr('data-id');
        if(userId == ''){
            return true;
        }
        const myID = $("#staffId").val();
        const from = "STAFF";
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
                    const hasNewMessage = value.hasNewMessage;

                    if(hasNewMessage == 1){
                        //console.log(hasNewMessage);
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



    //remove chat window X button top
    function removeChatWindow() {
        $("#chatBoxDivOuter").addClass('d-none');
    }
    //post massage
    function postMessage() {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        const member1 = $("#chatUserName").attr('data-id');
        const member2 = $("#staffId").val();
        const myID = $("#staffId").val();
        const message = $("#msgText").text();
        $("#msgText").empty();
        //console.log(message);
        $.ajax({
            url: "{{route('postMessage')}}",
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
    //show chat window (with messages)
    function showChatWindow(arg) {
        const CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        const userName = $(arg).text();
        const userId = $(arg).attr('data-id');
        const myID = $("#staffId").val();
        $("#chatBoxDivOuter").removeClass('d-none');
        $("#chatUserName").empty().text(userName).attr('data-id', userId);
        $("#chatWindowDiv").empty();
        //get chat messages
        $.ajax({
            url: "{{route('getChatMessages')}}",
            type: 'POST',
            data: {_token: CSRF_TOKEN,
                myID:myID,
                userId:userId},
            success: function (data) {

                    $.each(data[0], function (key, value) {
                        var msg =  value.text;
                        var sender = value.sender;
                        var time = value.created_at;
                       // var time = time.getHours() + ":" + time.getMinutes() + ":" + time.getSeconds();
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
               // chatWindowDiv
            }
        });

            //remove chat list window
        removeChatList();

    }

    //add chat list window
    function addChatList () {
        const chatList = "<div class='col-md-3 col-3' id='chatListDiv'><div class='card'><div class='list-group'>@foreach($users as $user)<a data-id='{{$user->id}}'  class='list-group-item list-group-item-action' onclick='showChatWindow(this)'>{{$user->name}} <span id='newMsg{{$user->id}}' class='badge text-danger'></span></a>@endforeach</div></div></div>";
        const removeCatButton = "<button class='btn btn-outline-danger btn-sm rounded-circle' onclick='removeChatList()'><i class='fas fa-comment-slash'></i></button>";
        $("#chatListDiv").remove();
        $("#chatButton").empty().append(removeCatButton);
        $("#mainRow").append(chatList);
        //$("#caseDiv").removeClass('offset-md-3');
        $("#chatBoxDivOuter").removeClass('d-none').addClass('d-none');
    }


    //remove chat list window
    function removeChatList () {
        const addChatButton = "<button class='btn btn-outline-success btn-sm rounded-circle' onclick='addChatList()'><i class='far fa-comment-dots'></i></button>";
        $("#chatListDiv").remove();
        $("#chatButton").empty().append(addChatButton);
        $("#caseDiv").addClass('offset-md-3');
    }

    $('#leftmenuinnerinner').scrollTop($('#leftmenuinnerinner')[0].scrollHeight);

    function openCase(arg) {

        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var to = $('#to').val();
        var newcase = $('#case').val();
        var otherCase = $('#otherCase').val();
        var caseText = $('#caseText').val();
        let reciveEmail = $('#reciveEmail').val()
        //alert(otherCase);
        if(newcase=='') {
            $('#case').addClass("is-invalid");
            return;
        }

        if(caseText=='') {
            $('#caseText').addClass("is-invalid");
            return;
        }
        $('#openCaseBtn').prop("disabled", true);
        $.ajax({
            url: "{{route('newCase')}}",
            type: 'POST',
            data: {_token: CSRF_TOKEN, to:to, newcase:newcase, otherCase:otherCase, caseText:caseText, reciveEmail:reciveEmail},
            success: function (data) {

                swal("ქეისი გახსნილია", "IT სპეციალისტი მალე დაგიკავშირდებათ", "success")

                    .then(() => {
                        location.reload();
                    });
            }
        });

    }
    function showCase(arg) {
        var caseText = arg.name;
        //alert(caseText);
        swal("ქეისი", caseText);

    }

    /* function otherCase(arg) {
         var value = arg.value;
         //swal("Here's the title!", value);
         //alert(value);
         if(value=='z'){
             $('#otherCaseOption').removeClass('d-none');
         }else{
             $('#otherCaseOption').addClass('d-none');
         }

     }*/
    function closeCase(arg) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        var status = 'გაუქმებული';
        var id = arg.value;
        swal({
            title: "ქეისის გაუქმება",
            text: "დარწმუნებული ხართ, რომ გსურთ ქეისის გაუქმება?",
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

                            swal("ქეისი გაუქმებულია", "", "success")

                                .then(() => {
                                    location.reload();
                                });

                        }
                    });
                } else {
                    swal("ქეისი აქტიურია!","ქეისის გაუქმება შეწყვეტილის!");
                }
            });


    }

</script>
</body>
</html>


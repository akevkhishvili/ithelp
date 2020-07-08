@extends('layouts.master')
@section('content')

    <div class="container-fluid">
<div id="caseTable">
    @include('it.caseBoardTable')
</div>
    </div>
    <audio id="audio" src="{{asset('sound/plucky.mp3')}}"></audio>

    <script>

        $(document).ready(function() {
            setInterval(function() {
                getRecord()
            }, 10000);
        });
        function getRecord() {
            $.ajax({
                type: 'GET',
                url: "{{route('caseNotification')}}",
                dataType:'JSON',

                success: function (data) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    const oldValue = data[0];
                    const newValue = data[1];
                    const action = data[2];

                   /* if (newValue > oldValue){

                        $.ajax({
                            url: "{{route('caseNotificationRecord')}}",
                            type: 'POST',
                            data: {_token: CSRF_TOKEN, newValue:newValue},
                            error: function (data) {
                                swal({
                                    title: "შეცდომა",
                                    text: "გთხოვთ დაუკავშირდეთ ადმინისტრატორს",
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                })
                            },
                            success: function (data) {
                                $("#audio")[0].play();
                                $('#caseTable').html(data.html);
                            }
                        });
                    }else*/ if(action > 0){

                        $.ajax({
                            url: "{{route('caseNotificationRecord')}}",
                            type: 'POST',
                            data: {_token: CSRF_TOKEN, action:0},
                            error: function (data) {
                                swal({
                                    title: "შეცდომა",
                                    text: "გთხოვთ დაუკავშირდეთ ადმინისტრატორს",
                                    icon: "warning",
                                    buttons: true,
                                    dangerMode: true,
                                })
                            },
                            success: function (data) {
                                $("#audio")[0].play();
                                $('#caseTable').html(data.html);
                            }

                        });
                    }
                    console.log(data)
                }
            });
        }



      /*  $(document).ready(function() {
            setInterval(function() {
                cache_clear()
            }, 10000);
        });

        function cache_clear() {
            window.location.reload(true);
            // window.location.reload(); use this if you do not remove cache
        }*/
    </script>
@endsection

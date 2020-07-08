<div>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <span class="navbar-brand">{{$user->name}}</span>
            <input id="myID" value="{{$user->id}}" type="hidden">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item @if(\Route::current()->getName() == 'home')active @endif">
                        <a class="nav-link" href="{{route('home')}}">Home
                            <span class="sr-only">(current)</span>
                        </a>
                    </li>
                    <li class="nav-item @if(\Route::current()->getName() == 'staffUser')active @endif">
                        <a class="nav-link" href="{{route('staffUser')}}">თანამშრომლები</a>
                    </li>
                    <li class="nav-item @if(\Route::current()->getName() == 'itUser')active @endif">
                        <a class="nav-link" href="{{route('itUser')}}">მომხმარებლები</a>
                    </li>
                    <li class="nav-item @if(\Route::current()->getName() == 'caseBoard')active @endif">
                        <a class="nav-link" href="{{route('caseBoard')}}" target="_blank">ყველა ქეისი</a>
                    </li>

                </ul>
            </div>
        </div>
        <div id="itChatButton">
            <button class="btn btn-outline-success btn-sm rounded-circle" onclick="addChatListIt()"><i class="far fa-comment-dots"></i></button>
            <span id='itChatButtonBadge' class='badge badge-danger badge-pill float-right'></span>
        </div>
        <div class="nav-item ml-2">
            <a class="btn btn-outline-danger btn-sm  rounded-circle" href="{{ route('logout') }}"><i class="fas fa-power-off"></i></a>
        </div>
    </nav>
</div>

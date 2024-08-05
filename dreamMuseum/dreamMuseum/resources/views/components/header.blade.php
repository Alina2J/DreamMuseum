<header>
    <nav class="navbar navbar-expand-lg ">
        <div class="container-fluid container-content">
            <a class="navbar-brand" href="{{route('main-page')}}"><img class="logo" src="/img/LOGO.png" alt="Logo"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    @if(Auth::user())
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('chat-page', ['id' => $chat->id])}}">Поддержка</a>
                        </li>
                        @if(Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="">{{Auth::user()->login}}</a>
                            </li>
                        @else
                            <li class="nav-item">
                                <a class="nav-link avatar" href="{{route('profile')}}"><img src="/storage/{{Auth::user()->photo_url}}" alt="avatar">{{Auth::user()->login}}</a>
                            </li>
                        @endif
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('logout')}}">Выйти</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('reg-page')}}">Регистрация</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('auth-page')}}">Войти</a>
                        </li>
                    @endif
                </ul>
                <form class="d-flex" method="get" action="{{route('search')}}" autocomplete="off" role="search">
                    <input value="{{old('search')}}" class="form-control me-3" type="search" name="search" placeholder="Введите название модели...">
                    <button class="btn-search btn-reset" type="submit"><img class="search-img" src="/img/Vector.svg" alt="search"></button>
                </form>
            </div>
        </div>
    </nav>
</header>

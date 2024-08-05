@extends('layout')

@section('title', 'Мой профиль')

@section('scripts')
    <script type="text/javascript">
        var container = document.querySelector('.row-cols-md-4');
        var msnry = new Masonry( container, {
            columnWidth: 340,
            itemSelector: '.item',
            percentPosition: false,
            gutter: 10,
        });
    </script>
@endsection

@section('page-content')
    <section class="bg-profile">
        <div class="container-fluid container-content">
            <div class="profile-header">
                <img src="/storage/{{Auth::user()->photo_url}}" alt="avatar">
                <div class="profile-info">
                    <h4>{{Auth::user()->login}}</h4>
                    <p class="contacts"><ion-icon name="mail-outline"></ion-icon>{{Auth::user()->email}}</p>
                    @if(Route::is('profile'))
                        <p class="contacts"><ion-icon name="cube-outline"></ion-icon>{{$posts->count()}} {{ trans_choice('публикация|публикации|публикаций', $posts->count())}}</p>
                    @elseif(Route::is('favourites-page'))
                        <p class="contacts"><ion-icon name="cube-outline"></ion-icon>{{$posts->count()}} в избранном</p>
                    @endif
                    <p>{{Auth::user()->description}}</p>
                </div>
                <form action="">
                    <a href="{{route('add-model')}}" style="display: flex; justify-content: center;" class="btn-reset glow-2">Загрузить модель</a>
                    <a href="{{route('edit-profile')}}" style="display: flex; justify-content: center;" class="btn-reset glow-2">Редактировать</a>
                </form>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid container-content">
            <nav class="nav">
                <a class="nav-link {{Route::is('profile') ? 'active' : '' }}" aria-current="page" href="{{route('profile')}}">Публикации</a>
                <a class="nav-link {{Route::is('favourites-page') ? 'active' : '' }}" href="{{route('favourites-page')}}">Избранное</a>
            </nav>
            @if(Route::is('profile'))
                @if($posts->isNotEmpty())
                <div class= "row row-cols-1 row-cols-md-4 g-4">
                    @foreach($posts as $post)
                        <x-post :post="$post"></x-post>
                    @endforeach
                </div>
                @else
                    <h3>Вы ещё не опубликовали ни одной модели :(</h3>
                    <p>Начало ваших публикаций</p>
                @endif
            @elseif(Route::is('favourites-page'))
                @if($posts->isNotEmpty())
                    <div class= "row row-cols-1 row-cols-md-4 g-4">
                        @foreach($posts as $post)
                            <x-post :post="$post"></x-post>
                        @endforeach
                    </div>
                @else
                    <h3>Здесь будут отображаться модели которым вы поставили лайк :)</h3>
                    <p>Начало ваших избранных моделей</p>
                @endif
            @endif
        </div>
    </section>
@endsection

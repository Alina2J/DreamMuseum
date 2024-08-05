@extends('layout')

@section('title', 'Профиль пользователя')

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
                <img src="/storage/{{ $user->photo_url }}" alt="avatar">
                <div class="profile-info">
                    <h4>{{ $user->login }}</h4>
                    <p class="contacts"><ion-icon name="mail-outline"></ion-icon>{{ $user->email }}</p>
                    <p class="contacts"><ion-icon name="cube-outline"></ion-icon>{{$posts->count()}} {{ trans_choice('публикация|публикации|публикаций', $posts->count())}}</p>
                    <p>{{ $user->description }}</p>
                </div>
                <form action="">
                </form>
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid container-content">
            <nav class="nav">
                <a class="nav-link active" aria-current="page" href="#">Публикации</a>
            </nav>
            <div class= "row row-cols-1 row-cols-md-4 g-4">
                @foreach($posts as $post)
                    <x-post :post="$post"></x-post>
                @endforeach
            </div>
        </div>
    </section>
@endsection

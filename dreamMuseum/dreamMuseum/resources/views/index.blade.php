@php
    $segments = request()->segments();
@endphp

@extends('layout')

@section('title', 'Главная')

@section('page-content')
    @if(Auth::user() && Auth::user()->isAdmin())
    @else
    <section class="content">
        <div class="container-fluid container-content">
            <div class="row row-cols-2" style="display: flex; align-items: center">
                <div class="col flex-block">
                    <img class="dd-text" src="/img/3d-text.png" alt="3d">
                    <p class="main-description">
                        Управляйте своими 3D-ресурсами. <br>
                        Распространяйте опыт 3D и AR. <br>
                        Продемонстрируйте свою работу.<br>
                        Скачивайте и просматривайте 3D <br> модели.
                    </p>
                    <a href="#posts" class="btn-reset glow-on-hover">Показать больше</a>
                </div>
                <img class="col" style="width: 700px; height: 500px" src="/img/car.png" alt="car">
            </div>
        </div>
    </section>
    <section>
        <div class="container-fluid container-content">
            <ul class="categories-block list-reset anim">
                <a href="{{route('category-search', ['id' => 7])}}#posts" class="category">
                    <p>Автомобили</p>
                    <img class="dragon" src="/img/car.png" alt="popular">
                </a>
                <a href="{{route('category-search', ['id' => 1])}}#posts" class="category">
                    <p>Персонажи</p>
                    <img src="/img/pers.png" alt="pers">
                </a>
                <a href="{{route('category-search', ['id' => 8])}}#posts" class="category">
                    <p class="name-category">Органика</p>
                    <img src="/img/flower.png" alt="popular">
                </a>
            </ul>
        </div>
    </section>
    @endif
    <section style="margin-top: 20px" id="posts">
        <div class="container-fluid container-content">
            <h2>Публикации</h2>
            <nav class="nav">
                <a class="nav-link {{Route::is('main-page') ? 'active' : '' }}" href="{{route('main-page')}}#posts">Последние</a>
                @foreach($categories as $category)
                    <a class="nav-link {{ (last($segments) == $category->id) ? 'active' : '' }}" href="{{route('category-search', ['id' => $category->id])}}#posts">{{$category->title}}</a> <!-- active -->
                @endforeach
            </nav>
            @if($posts->isNotEmpty())
                <div class= "row row-cols-1 row-cols-md-4 g-4">
                @foreach($posts as $post)
                    <x-post :post="$post"></x-post>
                @endforeach
                </div>
            @else
                <h3>В выбранной категории ничего не нашлось :(</h3>
                <p>Станьте первым кто опубликует модель в данной категории</p>
            @endif
        </div>

    </section>
@endsection

@section('scripts')
    <script type="text/javascript">
        var container = document.querySelector('.row-cols-md-4');
        var msnry = new Masonry( container, {
            columnWidth: 340,
            itemSelector: '.item',
            percentPosition: false,
            gutter: 12,
        });
    </script>
@endsection

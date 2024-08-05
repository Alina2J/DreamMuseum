@extends('layout')

@section('title', 'Поиск')

@section('page-content')
    <section id="posts">
        <div class="container-fluid container-content">
            <h2 style="margin: 50px 0">Публикации по запросу "{{ $search }}"</h2>
            @if($posts->isNotEmpty())
                <div class= "row row-cols-1 row-cols-md-4 g-4">
                    @foreach($posts as $post)
                        <x-post :post="$post"></x-post>
                    @endforeach
                </div>
            @else
                <p>По запросу "{{ $search }}"ничего не нашлось :(</p>
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
            gutter: 10,
        });
    </script>
@endsection

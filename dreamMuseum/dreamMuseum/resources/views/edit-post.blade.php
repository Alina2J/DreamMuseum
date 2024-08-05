@extends('layout')

@section('title', 'Редактирование поста')

@section('page-content')
    <section>
        <div class="container-fluid container-content">
            <h2 class="heading-secondary">Редактирование поста</h2>
            <form action="{{route('post.update', $post->id)}}" method="post" class="row g-3 needs-validation authorization" enctype="multipart/form-data">
                @csrf
                {{ method_field('put') }}
                <div class="col-md-4 validate-me">
                    <label for="title" class="form-label">Название</label>
                    <input value="{{old('title') ? : $post->title}}" type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" autofocus required>
                    @error('title')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4 validate-me">
                    <label for="validationCustom05" class="form-label">Категория</label>
                    <select name="category" class="form-select" id="validationCustom05" required>
                        <option selected disabled value="">Выберите...</option>
                        @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $post->category->id == $category->id ? 'selected' : '' }}>{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4 validate-me">
                    <label for="description" class="form-label">Описание</label>
                    <textarea rows="5" class="form-control @error('description') is-invalid @enderror" style="width: 450px;" name="description" id="description">{{old('description') ? : $post->description}}</textarea>
                    @error('description')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4 validate-me">
                    <label for="image" class="form-label">Изображение</label>
                    <input name="image" type="file" style="width: 450px;" class="form-control @error('image') is-invalid @enderror" id="image">
                    @error('image')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-12">
                    <button class="btn-reset glow" type="submit">Обновить пост</button>
                </div>
            </form>
        </div>
    </section>
@endsection

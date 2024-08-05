@extends('layout')

@section('title', 'Редактирование профиля')

@section('page-content')
    <section>
        <div class="container-fluid container-content">
            <h2 class="heading-secondary">Редактирование профиля</h2>
            <form action="{{route('edit')}}" method="post" class="row g-3 needs-validation authorization" enctype="multipart/form-data">
                @csrf
                <div class="col-md-4 validate-me">
                    <label for="login" class="form-label">Имя пользователя</label>
                    <input value="{{old('login') ? : Auth::user()->login}}" placeholder="Alex" type="text" name="login" id="login" class="form-control @error('login') is-invalid @enderror" autofocus required>
                    @error('login')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4 validate-me">
                    <label for="image" class="form-label">Изображение профиля</label>
                    <input name="image" type="file" style="width: 450px;" class="form-control @error('image') is-invalid @enderror" id="image">
                    @error('image')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4 validate-me">
                    <label for="description" class="form-label">Описание</label>
                    <textarea rows="5" class="form-control @error('description') is-invalid @enderror" style="width: 450px;" name="description" id="description">{{old('description') ? : Auth::user()->description}}</textarea>
                    @error('description')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-12">
                    <button class="btn-reset glow" type="submit">Обновить профиль</button>
                </div>
            </form>
        </div>
    </section>
@endsection

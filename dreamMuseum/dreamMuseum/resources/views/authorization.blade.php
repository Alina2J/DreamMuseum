@extends('layout')

@section('title', 'Авторизация')

@section('page-content')
    <section>
        <div class="container-fluid container-content">
            <h2 class="heading-secondary">Авторизация</h2>
            @if(session('status'))
                <p style="font-weight: bold; color: #7a4c8f;">Пароль был успешно изменён!</p>
            @endif
            <form action="{{route('auth')}}" method="post" style="width: 520px" class="row g-3 needs-validation authorization">
                @csrf
                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input value="{{old('email')}}" autofocus placeholder="dreammuseum@gmail.com" type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="password" class="form-label">Пароль</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" required>
                    @error('password')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-12" style="display: flex; justify-content: space-between; align-items: flex-end;">
                    <button class="btn-reset glow" type="submit">Войти</button>
                    <a href="{{route('password-page')}}" style="font-weight: bold; color: #8649a9;" class="btn-reset">Забыли пароль?</a>
                </div>
            </form>
        </div>
    </section>
@endsection

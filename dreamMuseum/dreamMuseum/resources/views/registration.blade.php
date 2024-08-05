@extends('layout')

@section('title', 'Регистрация')

@section('page-content')
    <section>
        <div class="container-fluid container-content">
            <h2 class="heading-secondary">Регистрация</h2>
            <form action="{{route('reg')}}" method="post" class="row g-3 needs-validation authorization">
                @csrf
                <div class="col-md-4 validate-me">
                    <label for="login" class="form-label">Имя пользователя</label>
                    <input value="{{old('login')}}" placeholder="Alex" type="text" name="login" id="login" class="form-control @error('login') is-invalid @enderror" autofocus required>
                    @error('login')
                        <div style="width: 500px" class="invalid-feedback">
                            {{$message}}
                        </div>
                    @enderror
                </div>
                <div class="col-md-4 validate-me">
                    <label for="email" class="form-label">Email</label>
                    <input value="{{old('email')}}" placeholder="dreammuseum@gmail.com" type="email" style="width: 445px" name="email" id="email" class="form-control  @error('email') is-invalid @enderror" required>
                    @error('email')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4 validate-me">
                    <label for="password" class="form-label">Пароль</label>
                    <input placeholder="минимум 5 символов" type="password" style="width: 445px" name="password" id="password" class="form-control  @error('password') is-invalid @enderror" required>
                    @error('password')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4 validate-me">
                    <label for="password_confirmation" class="form-label">Подтвердите пароль</label>
                    <input  placeholder="минимум 5 символов" type="password" style="width: 445px;" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" required>
                    @error('password')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-12">
                    <button class="btn-reset glow" type="submit">Зарегистрироваться</button>
                </div>
            </form>
        </div>
    </section>
@endsection

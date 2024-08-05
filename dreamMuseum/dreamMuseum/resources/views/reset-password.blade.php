@extends('layout')

@section('title', 'Восстановление пароля')

@section('page-content')
    <section>
        <div class="container-fluid container-content">
            <h2 class="heading-secondary">Сброс пароля</h2>
            <form novalidate action="{{route('password.update')}}" method="post" style="width: 600px" class="row g-3 needs-validation authorization">
                @csrf
                <input type="hidden" name="token" value="{{ $request->token }}">
                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input value="{{old('email', $request->email)}}"  style="width: 445px;" placeholder="dreammuseum@gmail.com" type="email" name="email" id="email" class="form-control" readonly  required>
                    @error('email')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label for="password" class="form-label">Новый пароль</label>
                    <input autofocus placeholder="минимум 5 символов" type="password" style="width: 445px" name="password" id="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label style="width: 500px" for="password_confirmation" class="form-label">Подтвердите пароль</label>
                    <input  placeholder="минимум 5 символов" type="password" style="width: 445px;" name="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" id="password_confirmation" required>
                    @error('password')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-12">
                    <button class="btn-reset glow" type="submit">Сбросить</button>
                </div>
            </form>
            @if(session('status'))
                <p style="font-weight: bold; color: #7a4c8f; padding-left: 15px">Письмо для сброса пароля отправлено на указанную почту!</p>
            @endif
        </div>
    </section>
@endsection

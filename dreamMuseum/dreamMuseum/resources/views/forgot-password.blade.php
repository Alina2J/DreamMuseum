@extends('layout')

@section('title', 'Восстановление  пароля')

@section('page-content')
    <section>
        <div class="container-fluid container-content">
            <h2 class="heading-secondary">Забыли пароль?</h2>
            <form action="{{route('password')}}" method="post" style="width: 520px" class="row g-3 needs-validation authorization">
                @csrf
                <div class="col-md-4">
                    <label for="email" class="form-label">Email</label>
                    <input autofocus placeholder="dreammuseum@gmail.com" type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" required>
                    @error('email')
                    <div style="width: 500px" class="invalid-feedback">
                        {{$message}}
                    </div>
                    @enderror
                </div>
                <div class="col-12">
                    <button class="btn-reset glow" type="submit">Отправить</button>
                </div>
            </form>
            @if(session('status'))
            <p style="font-weight: bold; color: #7a4c8f; padding-left: 15px">Письмо для сброса пароля отправлено на указанную почту!</p>
            @endif
        </div>
    </section>
@endsection

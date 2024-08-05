@extends('layout')

@section('title', 'Подтверждение адреса электронной почты')

@section('page-content')
    <section>
        <div class="container-fluid container-content">
            <h2 class="heading-secondary">Подтверждение адреса электронной почты</h2>
            <p style="font-weight: bold; color: #7a4c8f;">Повторная ссылка для отправки письма на почту!</p>
            @if(session('message'))
                <p style="font-weight: bold; color: #7a4c8f;">{{session('message')}}</p>
            @endif
            <form style="margin-top: 0;" action="{{route('verification.send')}}" method="post" class="row g-3 needs-validation authorization">
                @csrf
                <div style="margin: 10px 0 100px 0; padding-left: 0;" class="col-12" >
                    <button class="btn-reset glow" type="submit">Отправить</button>
                </div>
            </form>
        </div>
    </section>
@endsection

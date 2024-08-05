@php
    $segments = request()->segments();
@endphp
@extends('layout')

@section('title', 'Чат')

@section('page-content')
    <style>
        .mes {
            transition: all 0.3s;
        }
        .mes:hover {
            background-color: #bca9d7;
        }
    </style>
    @if(Auth::user()->isAdmin())
        <section id="app" style="background-color: #eee; margin: 0">
            <div class="container py-5">
                <div class="row">
                    @if($chats->isNotEmpty())
                        <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                            <h5 class="font-weight-bold mb-3 text-center text-lg-start">Чаты</h5>
                            <div class="card">
                                <div class="card-body">
                                    <ul class="list-unstyled mb-0 overflow">
                                        @foreach($chats as $key)
                                            <li class="mes p-1 border-bottom {{ (last($segments) === $key->id) ? 'checked-mes' : '' }}">
                                                <a href="{{route('chat-page', $key->id)}}">
                                                    <div style="display: flex; align-items: center;">
                                                        <img src="/storage/{{ $key->user->photo_url }}" alt="avatar"
                                                             class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                                        <div>
                                                            <p class="fw-bold mb-0">{{ $key->user->login }}</p>
                                                            <p class="small text-muted">Пользователь задал вопрос, необходимо ответить!</p>
                                                        </div>
                                                    </div>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-7 col-xl-8 padding">
                                <ul class="list-unstyled">
                                    <div class="hidden" id="messages">
                                        <chat-messages :chat-id="{{ $route }}" :user="{{ Auth::user() }}"></chat-messages>
                                    </div>
                                    <chat-form :id="{{ $route }}"></chat-form>
                                </ul>
                        </div>
                    @else
                        <h>У вас еще нет чатов :(</h>
                    @endif
                </div>
            </div>
        </section>
    @else
    <section id="app" style="background-color: #eee; margin: 0">
        <div class="container py-5">
            <div class="row">
                <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">
                    <h5 class="font-weight-bold mb-3 text-center text-lg-start">Чаты</h5>
                    <div class="card">
                        <div class="card-body">
                            <ul class="list-unstyled mb-0 overflow">
                                    <li class="mes p-1 border-bottom {{Route::is('chat-page', $chat->id) ? 'checked-mes' : '' }}">
                                        <a href={{route('chat-page', $chat->id)}}>
                                            <div style="display: flex; align-items: center;">
                                                <img src="/storage/{{ $admin->photo_url }}" alt="avatar"
                                                     class="rounded-circle d-flex align-self-center me-3 shadow-1-strong" width="60">
                                                <div>
                                                    <p class="fw-bold mb-0">{{ $admin->login }}</p>
                                                    <p class="small text-muted">Администратор сайта. Обращаться только по необходимости!</p>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-md-6 col-lg-7 col-xl-8 padding">
                    <ul class="list-unstyled">
                        <div class="hidden" id="messages">
                            <chat-messages :chat-id="{{ $chat->id }}" :user="{{ Auth::user() }}"></chat-messages>
                        </div>
                        <chat-form :id="{{ $chat->id }}"></chat-form>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    @endif
@endsection


<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function registration(Request $request) {

        $request->validate([
            'login' => 'required|string|min:3',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|confirmed|min:5'
        ]);

        $userData = $request->all();

        $user = new User();
        $user->login = $userData['login'];
        $user->email = $userData['email'];
        $user->password = bcrypt($userData['password']);
        $user->photo_url = 'uploads/none-img.jpg';
        $user->role_id = 2;
        $user->description = 'Опишите себя, свое творчество, опыт работы и как долго вы этим занимаетесь...';

        $user->save();

        $chat = new Chat();

        $chat->user_id = $user->id;
        $chat->admin_id = 1;

        $chat->save();

        event(new Registered($user));

        Auth::login($user);

        return redirect('/');
    }

    public function authorization(Request $request) {

        $credentials = $request->validate([
            'email' => 'required|string|exists:users',
            'password' => 'required|string'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route('main-page');
        }

        return back()->withErrors([
            'password' => 'Неверный пароль'
        ]);

    }

    public function logout() {
        Auth::logout();
        return redirect('/');
    }

    public function password(Request $request) {
        $request->validate([
            'email' => 'required|email',
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', trans($status));
        }

        return back()->withInput($request->only('email'))
            ->withErrors([
                'email' => 'Данный email не зарегестрирован.'
            ]);
    }

    public function reset(Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:5',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' =>  bcrypt($request->password),
                    'remember_token' => Str::random(60)
                ])->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('auth')->with('status', trans($status));
        }
    }

    public function notice(Request $request) {

        if ($request->user()->hasVerifiedEmail()){
            return redirect()->intended('/');
        }


        $chat = Chat::where('user_id', Auth::id())->orWhere('admin_id', Auth::id())->first();
        return view('verify-email', compact('chat'));
    }

    public function verify(EmailVerificationRequest $request) {

        if ($request->user()->hasVerifiedEmail()){
            return redirect()->intended('/');
        }

        $request->fulfill();

        return redirect()->intended('/');
    }

    public function send(Request $request) {

        if ($request->user()->hasVerifiedEmail()){
            return redirect()->intended('/');
        }

        $request->user()->sendEmailVerificationNotification();

        return back()->with('message', 'Ссылка отправлена!');
    }

    public function edit(Request $request) {
        $request->validate([
            'login' => 'required|string|min:3',
            'image' => 'sometimes|nullable|mimes:jpeg,png',
        ]);

        $id = Auth::user()->id;
        $photo = Auth::user()->photo_url;

        $user = User::find($id);
        $user->login = $request->input('login');
        if ($request->file('image') == null) {
            $user->photo_url = $photo;
        }else{
            $user->photo_url = $request->file('image')->store('uploads', 'public');
        }
        $user->description = $request->input('description');

        $user->save();

        return redirect()->route('profile');
    }
}

<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Http\Requests\MessageFormRequest;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    public function messages($id)
    {
        return Message::query()
            ->where('chat_id', $id)
            ->with('user')
            ->get();
    }

    public function send(MessageFormRequest $request, $id) {

        $message = $request->user()->messages()->create(array_merge($request->validated(), ['chat_id' => $id]));

        broadcast(new MessageSent($request->user(), $message));

        return $message;
    }

}

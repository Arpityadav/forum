<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePostPolicy;
use App\Notifications\YouWereMentioned;
use App\Reply;
use App\Thread;
use App\Rules\SpamFree;
use App\User;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(10);
    }

    public function store($channelId, Thread $thread, CreatePostPolicy $form)
    {
        return $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->delete();

        if(request()->wantsJSON()){
            return response(['status' => 'Reply deleted.']);
        }

        return back();
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);

        $this->validate(request(), ['body' => ['required', new SpamFree]]);

        $reply->update(['body' => request('body')]);

    }

}

<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Spam;
use App\Thread;
use Illuminate\Http\Request;

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

    public function store($channelId, Thread $thread, Spam $spam)
    {
        $this->validate(request(), ['body' => 'required']);
        $spam->detect(request('body'));



        $reply = $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        if(request()->expectsJSON()) {
            return $reply->load('owner');
        }

        return back()
            ->with('flash', 'Your reply has been left.');
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

        $reply->update(['body' => request('body')]);
    }
}

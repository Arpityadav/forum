<?php

namespace App\Http\Controllers;

use App\Reply;
use App\Inspections\Spam;
use App\Thread;

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

    public function store($channelId, Thread $thread)
    {
        try {
            $this->validateReply();

            $reply = $thread->addReply([
                'body' => request('body'),
                'user_id' => auth()->id()
            ]);

            return $reply->load('owner');
        } catch (\Exception $e) {
            return response('Reply could not be saved at this moment.', 422);
        }
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
        try {
            $this->authorize('update', $reply);

            $this->validateReply();

            $reply->update(['body' => request('body')]);
        }catch (\Exception $e) {
            return response('Reply could not be saved at this moment.', 422);
        }
    }

    protected function validateReply()
    {
        $this->validate(request(), ['body' => 'required']);
        resolve(Spam::class)->detect(request('body'));
    }
}

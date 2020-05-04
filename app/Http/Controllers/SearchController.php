<?php

namespace App\Http\Controllers;

use App\Thread;
use App\Trending;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Trending $trending)
    {
        if (request()->wantsJson()) {
            $search = request('q');
            $threads = Thread::search($search)->paginate(10);

            return $threads;
        }

        return view('threads.search', [
            'trending' => $trending->get()
        ]);
    }
}

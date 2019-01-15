<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function show(User $user)
    {
        $activities = $user->activities()->latest()->with('subject')->take(50)->get()->groupBy(function($activity){
            return $activity->created_at->format('Y-m-d');
        });
        return view('profile.show', [
            'profileUser' => $user,
            'activities' => $activities,
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index(Request $request)
    {
        $setting = DB::table('settings')->where('user_id', Auth::id())->first();
        return Inertia::render('Setting/Index', [
            'setting' => $setting,

        ]);
    }

    public function update(Request $request){

        // dd($request->all());
        $userId = Auth::id();

        $request->validate([
            'feed_per_row' => 'required|integer|min:2|max:5',
        ]);

        DB::table('settings')->where('user_id', $userId)->update([
            'feed_per_row' => $request->feed_per_row,
        ]);

        return response()->json(['success' => true]);
    }
}

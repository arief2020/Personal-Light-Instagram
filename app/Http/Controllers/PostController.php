<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function show(string $id, Request $request)
    {
        $post = Post::findOrFail($id);

        return Inertia::render('Post/IndexPost', ['post' => $post]);
    }

    public function create(Request $request)
    {
        return Inertia::render('Post/CreatePost');
    }

    public function archive(Request $request)
    {
        return Inertia::render('Post/ArchivePost');
    }

    public function store(Request $request)
{
    $request->validate([
        'caption' => 'required',
        'file_path' => 'required|file|mimes:jpg,png,jpeg,mp4,mov|max:153600', // 150MB
    ]);

    $filePath = null;
    $fileType = 'unknown';

    if ($request->hasFile('file_path')) {
        $file = $request->file('file_path');
        $filePath = $file->store('posts', 'public');
        $fileType = $file->getMimeType();
    }

    DB::table('posts')->insert([
        'caption' => $request->caption,
        'file_path' => $filePath,
        'file_type' => $fileType, // Simpan file type dari PHP bukan dari request
        'user_id' => Auth::id(),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return to_route('profile.show', ['id' => Auth::id()]);
}

    // public function store(Request $request)
    // {
    //     // dd($request->all());
    //     $request->validate([
    //         'caption' => 'required',
    //         'file_path' => 'required|file|mimes:jpg,png,jpeg,mp4,mov|max:153600', // 150MB
    //     ]);

    //     $filePath = null;
    //     $fileType = $fileType ?? 'unknown';

    //     if ($request->hasFile('file_path')) {
    //         $file = $request->file('file_path');
    //         $filePath = $file->store('posts', 'public');
    //         $fileType = $file->getMimeType(); // Ambil MIME Type
    //     }

    //     // // dd($filePath, $fileType);

    //     Post::create([
    //         'caption' => $request->caption,
    //         'file_path' => $filePath,
    //         'file_type' => $request->file_type, // Simpan file type
    //         'user_id' => Auth::user()->id,
    //     ]);

    //     // return redirect()->route('posts.index')->with('success', 'Post created successfully.');

    //     // Post::create([
    //     //     'caption' => "captio",
    //     //     'file_path' => "test.jpg",
    //     //     'file_type' => "image", // Simpan file type
    //     //     'user_id' => 7,
    //     // ]);
    //     return to_route('posts.index');
    // }
}

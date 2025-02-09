<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

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
        $post = Post::where('user_id', Auth::id())->where('is_archived', true)->get();
        return Inertia::render('Post/ArchivePost', ['posts' => $post]);
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

    public function storeArchive(Request $request, $id)
    {
        $updated = DB::table('posts')
            ->where('id', $id)
            ->update(['is_archived' => true, 'updated_at' => now()]);

        if ($updated) {
            $post = DB::table('posts')->where('id', $id)->first();

            return response()->json(['success' => true, 'post' => $post]);
        }

        return response()->json(['success' => false, 'message' => 'Post not found or update failed'], 404);
    }
}

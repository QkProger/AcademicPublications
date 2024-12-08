<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Music;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AlbumController extends Controller
{
    public function index(Request $request)
    {
        $albums = Album::paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/Album/Index', [
            'albums' => $albums
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Album/Create');
    }

    public function store(Request $request)
    {
        Album::create([
            'title' => $request->title,
        ]);
        return redirect()->route('admin.albums.index')->with('success', 'Сәтті қосылды');
    }

    public function edit(Album $album)
    {
        return Inertia::render('Admin/Album/Edit', [
            'album' => $album
        ]);
    }

    public function update(Request $request, Album $album)
    {
        $album->update([
            'title' => $request->title,
        ]);
        return redirect()->route('admin.albums.index')->with('success', 'Сәтті сақталды');
    }

    public function destroy(Album $album)
    {
        Music::where('album_id', $album->id)->update([
            'album_id' => 0
        ]);
        $album->delete();
        return redirect()->back()->withSuccess('Сәтті жойылды');
    }
}

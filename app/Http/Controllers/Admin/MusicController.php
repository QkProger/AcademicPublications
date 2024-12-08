<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Music;
use App\Models\UserMusic;
use App\Services\FileService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MusicController extends Controller
{
    public function index(Request $request)
    {
        $musics = Music::with('album')->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/Music/Index', [
            'musics' => $musics
        ]);
    }

    public function create()
    {
        $albums = Album::get();
        return Inertia::render('Admin/Music/Create', [
            'albums' => $albums
        ]);
    }

    public function store(Request $request)
    {
        $data = [
            'title' => $request->title,
            'artist' => $request->artist,
            'album_id' => $request->album_id,
            'genre' => $request->genre,
        ];

        if ($request->hasFile('file')) {
            $music_file = $request->file('file');
            $file_name = FileService::saveFile($music_file, "/musics");
            $data['file_path'] = 'musics/' . $file_name;
        }
        Music::create($data);
        return redirect()->route('admin.musics.index')->with('success', 'Сәтті қосылды');
    }

    public function edit(Music $music)
    {
        $albums = Album::get();
        return Inertia::render('Admin/Music/Edit', [
            'music' => $music,
            'albums' => $albums
        ]);
    }

    public function update(Request $request, Music $music)
    {
        $data = [
            'title' => $request->title,
            'artist' => $request->artist,
            'album_id' => $request->album_id,
            'genre' => $request->genre,
        ];
        
        $oldMusicFile = basename($music->file_path);
        if ($request->hasFile('file')) {
            $music_file = $request->file('file');
            $file_name = FileService::saveFile($music_file, "/musics", $oldMusicFile);
            $data['file_path'] = 'musics/' . $file_name;
        }
        $music->update($data);
        return redirect()->route('admin.musics.index')->withSuccess("Сәтті сақталды!");
    }

    public function destroy(Music $music)
    {
        $music->delete();
        UserMusic::where('music_id', $music->id)->delete();
        return redirect()->back()->withSuccess('Сәтті жойылды');
    }
}

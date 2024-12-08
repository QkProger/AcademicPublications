<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Album;
use App\Models\Music;
use App\Models\UserAlbum;
use App\Models\UserMusic;
use Illuminate\Http\Request;
use Inertia\Inertia;

class MainController extends Controller
{
    public function index(Request $request)
    {
        $title = $request->title;

        $tracks = Music::with('album')
            ->when($title, fn($q) => $q->where('title', 'like', "%$title%"))->get();
        $albums = Album::with('tracks')->get();
        $myTracks = auth()->user()->myTracks;
        $myTracks->load('album');
        $myAlbums = auth()->user()->myAlbums;
        $myAlbums->load('tracks');

        return Inertia::render('Client/Musics', [
            'tracks' => $tracks,
            'albums' => $albums,
            'myTracks' => $myTracks,
            'myAlbums' => $myAlbums,
        ]);
    }

    public function saveTrack(Request $request)
    {
        UserMusic::create([
            'music_id' => $request->music_id,
            'user_id' => auth()->id()
        ]);
    }

    public function deleteMyTrack(Request $request)
    {
        UserMusic::where('music_id', $request->music_id)->where('user_id', auth()->id())->delete();
    }

    public function saveAlbum(Request $request)
    {
        UserAlbum::create([
            'album_id' => $request->album_id,
            'user_id' => auth()->id()
        ]);
    }

    public function deleteMyAlbum(Request $request)
    {
        UserAlbum::where('album_id', $request->album_id)->where('user_id', auth()->id())->delete();
    }
}

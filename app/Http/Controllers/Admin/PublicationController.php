<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Authorship;
use App\Models\Journal;
use App\Models\Publication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicationController extends Controller
{
    public function index(Request $request)
    {
        $publications = Publication::with(['journal', 'authors'])->paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/Publication/Index', [
            'publications' => $publications
        ]);
    }

    public function create()
    {
        $journals = Journal::get();
        $authors = Author::get();
        return Inertia::render('Admin/Publication/Create', [
            'journals' => $journals,
            'authors' => $authors,
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'publication_year' => 'required|date_format:Y',
            'publication_type' => 'required',
            'journal_id' => 'required|exists:journals,id',
            'doi' => 'required|string|max:100',
        ]);

        $publication = Publication::create($data);
        foreach ($request->authors as $author) {
            Authorship::create([
                'publication_id' => $publication->id,
                'author_id' => $author['author_id'],
                'role' => $author['role'],
            ]);
        }
        return redirect()->route('admin.publications.index')->with('success', 'Сәтті қосылды');
    }

    public function edit(Publication $publication)
    {
        $journals = Journal::get();
        $authors = Author::get();
        $publication->load('authors');
        return Inertia::render('Admin/Publication/Edit', [
            'publicationn' => $publication,
            'journals' => $journals,
            'authors' => $authors,
        ]);
    }

    public function update(Request $request, Publication $publication)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'publication_year' => 'required|date_format:Y',
            'publication_type' => 'required',
            'journal_id' => 'required|exists:journals,id',
            'doi' => 'required|string|max:100',
        ]);

        $publication->update($data);
        Authorship::where('publication_id', $publication->id)->delete();
        foreach ($request->authors as $author) {
            Authorship::create([
                'publication_id' => $publication->id,
                'author_id' => $author['author_id'],
                'role' => $author['role'],
            ]);
        }

        return redirect()->route('admin.publications.index')->with('success', 'Сәтті сақталды');
    }

    public function destroy(Publication $publication)
    {
        Authorship::where('publication_id', $publication->id)->delete();
        $publication->delete();

        return redirect()->back()->withSuccess('Сәтті жойылды');
    }
}

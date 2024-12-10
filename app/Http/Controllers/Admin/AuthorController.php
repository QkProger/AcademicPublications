<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Authorship;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AuthorController extends Controller
{
    public function index(Request $request)
    {
        $authors = Author::paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/Author/Index', [
            'authors' => $authors
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Author/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'position' => 'nullable|string|max:100',
            'degree' => 'nullable|string|max:100',
            'orcid' => 'nullable|string|max:50',
        ]);

        Author::create($data);
        return redirect()->route('admin.authors.index')->with('success', 'Сәтті қосылды');
    }

    public function edit(Author $author)
    {
        return Inertia::render('Admin/Author/Edit', [
            'author' => $author
        ]);
    }

    public function update(Request $request, Author $author)
    {
        $data = $request->validate([
            'full_name' => 'required|string|max:255',
            'position' => 'nullable|string|max:100',
            'degree' => 'nullable|string|max:100',
            'orcid' => 'nullable|string|max:50',
        ]);

        $author->update($data);

        return redirect()->route('admin.authors.index')->with('success', 'Сәтті сақталды');
    }

    public function destroy(Author $author)
    {
        Authorship::where('author_id', $author->id)->delete();
        $author->delete();

        return redirect()->back()->withSuccess('Сәтті жойылды');
    }
}
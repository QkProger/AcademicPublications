<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Authorship;
use App\Models\Journal;
use App\Models\Publication;
use Illuminate\Http\Request;
use Inertia\Inertia;

class JournalController extends Controller
{
    public function index(Request $request)
    {
        $journals = Journal::paginate($request->input('per_page', 20))
            ->appends($request->except('page'));
        return Inertia::render('Admin/Journal/Index', [
            'journals' => $journals
        ]);
    }

    public function create()
    {
        return Inertia::render('Admin/Journal/Create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'impact_factor' => 'nullable|numeric|min:0|max:999.99',
            'issn' => 'nullable|string|max:20',
        ]);

        Journal::create($data);
        return redirect()->route('admin.journals.index')->with('success', 'Сәтті қосылды');
    }

    public function edit(Journal $journal)
    {
        return Inertia::render('Admin/Journal/Edit', [
            'journal' => $journal
        ]);
    }

    public function update(Request $request, Journal $journal)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'impact_factor' => 'nullable|numeric|min:0|max:999.99',
            'issn' => 'nullable|string|max:20',
        ]);

        $journal->update($data);

        return redirect()->route('admin.journals.index')->with('success', 'Сәтті сақталды');
    }

    public function destroy(Journal $journal)
    {
        $publicationIds = Publication::where('journal_id', $journal->id)->pluck('id');
        Authorship::whereIn('publication_id', $publicationIds)->delete();
        Publication::whereIn('id', $publicationIds)->delete();
        $journal->delete();

        return redirect()->back()->withSuccess('Сәтті жойылды');
    }
}

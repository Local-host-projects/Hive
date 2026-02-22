<?php
namespace App\Http\Controllers;

use App\Models\Journals;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JournalController extends Controller
{
    
    public function index()
    {
        $journals = Journals::where('user', Auth::id())->get();
        return view('journal.main', compact('journals'));
    }

    public function updatepage($id){
        $journal = Journals::find($id);
        return view('journal.update',compact('journal'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'condition' => 'required|string|max:255',
            'story'     => 'required|string',
        ]);

        Journals::create([
            'user'      => Auth::id(),
            'condition' => $validated['condition'],
            'story'     => $validated['story'],
        ]);

        return redirect()->back()->with('success', 'Journal entry saved successfully!');
    }

    /**
     * Display the specified journal.
     */
    public function update(Request $request, $id)
    {
        //update journal entry
        $id = Journals::findOrFail($id);
        $validated = $request->validate([
            'condition' => 'required|string|max:255',
            'story'     => 'required|string',
        ]); 
        $id->update([
            'condition' => $validated['condition'],
            'story'     => $validated['story'],
        ]);
        return redirect()->back()->with('success', 'Journal entry updated successfully!');
    }   
    public function destroy($id)
    {
        $id = Journals::findOrFail($id);
        $id->delete();
        return redirect()->back()->with('success', 'Journal entry deleted successfully!');
    }
}
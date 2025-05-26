<?php

namespace App\Http\Controllers;

use App\Models\Snapshot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SnapshotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();

        $snapshots = $user->snapshots;

        return view('dashboard', [
            'snapshots' => $snapshots,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('images/' . $user->id, 'private');
        }

        Snapshot::create([
            'user_id' => $user->id,
            'title' => $request->input('title'),
            'path' => $imagePath,
        ]);

        return redirect()->route('dashboard')->with('success', 'Snapshot saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /**
     * Display the user's snapshots.
     */
    public function showImage(Snapshot $snapshot)
    {
        if ($snapshot->user_id !== Auth::user()->id) {
            abort(403);
        }

        $path = Storage::disk('private')->path($snapshot->path);


        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}

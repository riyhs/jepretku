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
        $user = Auth::guard('web')->user();

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
        $user = Auth::guard('web')->user();

        $request->validate([
            'title' => 'nullable|string|max:255',
            'image' => 'required|string',
        ]);

        $image = $request->input('image');

        if (preg_match('/^data:image\/(\w+);base64,/', $image, $type)) {
            $image = substr($image, strpos($image, ',') + 1);
            $type = strtolower($type[1]);

            if (!in_array($type, ['jpg', 'jpeg', 'png', 'gif'])) {
                throw new \Exception('Invalid image type.');
            }

            $image = base64_decode($image);
            if ($image === false) {
                throw new \Exception('Base64 decode failed.');
            }
        } else {
            throw new \Exception('Did not match data URL format.');
        }

        $filename = uniqid() . '.' . $type;

        Storage::disk('private')->put('images/' . $user->id . '/' . $filename, $image);

        Snapshot::create([
            'user_id' => $user->id,
            'title' => $request->input('title'),
            'path' => 'images/' . $user->id . '/' . $filename,
        ]);

        return response()->json(['success' => true, 'message' => 'Snapshot saved successfully!']);
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
        if ($snapshot->user_id !== Auth::guard('web')->user()->id) {
            abort(403);
        }

        $path = Storage::disk('private')->path($snapshot->path);


        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }
}

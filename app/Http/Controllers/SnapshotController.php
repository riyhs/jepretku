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

        return response()->json(['success' => true, 'message' => 'Foto Berhasil Disimpan!']);
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
    public function update(Request $request, Snapshot $snapshot)
    {
        if ($snapshot->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized.'], 403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $snapshot->update([
            'title' => $validated['title'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Judul berhasil diperbarui.',
            'new_title' => $snapshot->title
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Snapshot $snapshot)
    {
        // 1. Keamanan: Pastikan hanya pemilik foto yang bisa menghapus
        if ($snapshot->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.'], 403);
        }

        // 2. Hapus file fisik dari storage terlebih dahulu
        if (Storage::disk('private')->exists($snapshot->path)) {
            Storage::disk('private')->delete($snapshot->path);
        }

        // 3. Hapus record dari database
        $snapshot->delete();

        // 4. Kirim response sukses dalam format JSON
        return response()->json(['success' => true, 'message' => 'Foto berhasil dihapus.']);
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

    public function download(Snapshot $snapshot)
    {

        if (!Auth::check() || $snapshot->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        if (!Storage::disk('private')->exists($snapshot->path)) {
            abort(404, 'File not found.'); 
        }

        $originalFilename = basename($snapshot->path);
        $suggestedFilename = 'photobooth-' . \Illuminate\Support\Str::slug($snapshot->title ?: 'image') . '-' . $originalFilename;
        $filePath = Storage::disk('private')->path($snapshot->path);

        return response()->download($filePath, $suggestedFilename);
    }
}

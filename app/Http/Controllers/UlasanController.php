<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UlasanController extends Controller
{
    public function Ulasan(Request $request)
    {
        $request->validate([
            'buku_id' => 'required|exists:buku,id',
            'ulasan' => 'required|string|max:500',
        ]);

        Ulasan::create([
            'users_id' => Auth::id(),
            'buku_id' => $request->buku_id,
            'ulasan' => $request->ulasan,
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'ulasan' => 'required|string|max:500',
        ]);

        $ulasan = Ulasan::findOrFail($id);

        // Pastikan hanya pemilik ulasan yang bisa edit
        if ($ulasan->users_id !== auth()->id()) {
            return redirect()->back()->with('error', 'Anda tidak berhak mengedit ulasan ini.');
        }

        $ulasan->update(['ulasan' => $request->ulasan]);

        return redirect()->back()->with('success', 'Ulasan berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $review = Ulasan::find($id);

        if (!$review) {
            return response()->json(['success' => false, 'message' => 'Ulasan tidak ditemukan'], 404);
        }

        $review->delete();

        return response()->json(['success' => true, 'message' => 'Ulasan berhasil dihapus']);
    }
}

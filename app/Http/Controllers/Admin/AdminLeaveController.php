<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;

class AdminLeaveController extends Controller
{
    public function index(Request $request)
    {
        $query = Leave::with('user');

        if ($request->filled('search')) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->search . '%');
            });
        }

        $leaves = $query->orderByDesc('created_at')->paginate(10)->withQueryString();

        return view('_admin.leaves.index', compact('leaves'));
    }

    public function update(Request $request, $id)
    {
        $leave = Leave::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $leave->update([
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Status cuti berhasil diperbarui.');
    }

}

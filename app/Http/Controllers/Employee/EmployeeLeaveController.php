<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Leave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class EmployeeLeaveController extends Controller
{
    public function index(Request $request)
    {
        $agent = new Agent();

        if ($agent->isDesktop()) {
            throw new NotFoundHttpException();
        }

        $query = Leave::where('user_id', Auth::id());

        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        $leaves = $query->orderByDesc('created_at')->paginate(10);

        return view('_employee.leave.index', compact('leaves'));
    }


    public function create()
    {
        $agent = new Agent();

        if ($agent->isDesktop()) {
            throw new NotFoundHttpException();
        }

        return view('_employee.leave.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'type' => 'required|in:sick,annual,personal,other',
            'reason' => 'required|string|max:1000',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png,doc,docx|max:2048',
        ]);

        $leave = new Leave();
        $leave->user_id = Auth::id();
        $leave->start_date = $validated['start_date'];
        $leave->end_date = $validated['end_date'];
        $leave->type = $validated['type'];
        $leave->reason = $validated['reason'];

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('attachments', 'public');
            $leave->attachment_path = $path;
        }

        $leave->save();

        return redirect()->route('employee.leave.create')->with('success', 'Pengajuan izin berhasil dikirim.');
    }
}

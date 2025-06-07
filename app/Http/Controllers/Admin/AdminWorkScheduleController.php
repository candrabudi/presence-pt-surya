<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WorkSchedule;

class AdminWorkScheduleController extends Controller
{
    public function index()
    {
        $schedules = WorkSchedule::orderByRaw("FIELD(day, 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu')")->get();
        return view('_admin.work_schedules.index', compact('schedules'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'day' => 'required|string',
            'start_time' => 'nullable|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after_or_equal:start_time',
        ]);

        $schedule = WorkSchedule::findOrFail($id);

        $schedule->update([
            'day' => $request->day,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->back()->with('success', 'Jadwal kerja berhasil diperbarui.');
    }
}

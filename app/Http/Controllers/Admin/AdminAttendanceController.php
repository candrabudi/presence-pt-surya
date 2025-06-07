<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $statusFilter = $request->input('status');

        $query = User::where('role', 'employee');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('username', 'like', "%{$search}%");
            });
        }

        if ($statusFilter) {
            $query->where('status', $statusFilter);
        }

        $employees = $query->orderBy('full_name')->paginate(10);

        $year = date('Y');
        $month = date('m');
        $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;

        $attendancesRaw = Attendance::whereIn('user_id', $employees->pluck('id'))
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        $attendances = $attendancesRaw->groupBy('user_id');

        return view('_admin.attendance.index', compact('employees', 'daysInMonth', 'year', 'month', 'attendances'));
    }

}

<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\WorkSchedule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class EmployeeDashboardController extends Controller
{
    public function index()
    {
        $agent = new Agent();

        if ($agent->isDesktop()) {
            throw new NotFoundHttpException();
        }

        $user = Auth::user();
        $today = Carbon::today();
        $now = Carbon::now();

        $daysIndo = [
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu',
            'Sunday' => 'Minggu',
        ];

        $englishDay = $today->format('l');
        $indoDay = $daysIndo[$englishDay];

        $holiday = Holiday::whereDate('date', $today)->first();

        $leave = Leave::where('user_id', $user->id)
            ->where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->first();

        $schedule = WorkSchedule::where('day', $indoDay)->first();

        $attendance = Attendance::where('user_id', $user->id)
            ->whereDate('date', $today)
            ->first();

        $monthlyHolidays = Holiday::whereMonth('date', $today->month)
            ->whereYear('date', $today->year)
            ->orderBy('date')
            ->get();

        $startOfWeek = $today->copy()->startOfWeek(Carbon::MONDAY);
        $endOfWeek = $today->copy()->endOfWeek(Carbon::SUNDAY);

        $weeklyAttendances = Attendance::where('user_id', $user->id)
            ->whereBetween('date', [$startOfWeek, $endOfWeek])
            ->orderBy('date')
            ->get()
            ->keyBy(function ($item) {
                return Carbon::parse($item->date)->format('Y-m-d');
            });

        return view('_employee.dashboard.index', compact(
            'attendance',
            'holiday',
            'leave',
            'schedule',
            'now',
            'monthlyHolidays',
            'weeklyAttendances'
        ));
    }
}

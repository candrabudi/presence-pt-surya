<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $startOfMonth = Carbon::now()->startOfMonth()->toDateString();
        $endOfMonth = Carbon::now()->endOfMonth()->toDateString();

        $attendanceStats = Attendance::select(DB::raw('DATE(date) as day'), DB::raw('COUNT(DISTINCT user_id) as total'))
            ->whereBetween('date', [$startOfMonth, $endOfMonth])
            ->whereIn('status', ['present', 'late', 'half'])
            ->groupBy('day')
            ->orderBy('day')
            ->get();

        $days = [];
        $totals = [];

        $period = Carbon::parse($startOfMonth)->daysUntil($endOfMonth);
        foreach ($period as $date) {
            $formatted = $date->format('Y-m-d');
            $days[] = $date->format('d M');
            $totals[] = (int) ($attendanceStats->firstWhere('day', $formatted)->total ?? 0);
        }

        $today = Carbon::today();

        $attendanceCount = Attendance::whereDate('date', $today)
            ->whereIn('status', ['present', 'half'])
            ->distinct('user_id')
            ->count('user_id');

        $lateCount = Attendance::whereDate('date', $today)
            ->where('status', 'late')
            ->distinct('user_id')
            ->count('user_id');

        $absentCount = Attendance::whereDate('date', $today)
            ->where('status', 'absent')
            ->distinct('user_id')
            ->count('user_id');

        $leaveApplyCount = Leave::where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->distinct('user_id')
            ->count('user_id');


        $genderData = User::where('role', 'employee')
            ->selectRaw('gender, COUNT(*) as total')
            ->groupBy('gender')
            ->pluck('total', 'gender')
            ->toArray();

        $genderChart = [
            'male' => $genderData['male'] ?? 0,
            'female' => $genderData['female'] ?? 0,
            'other' => $genderData['other'] ?? 0,
        ];

        $year = date('Y');
        $attendanceData = [];
        $leaveData = [];

        for ($m = 1; $m <= 12; $m++) {
            $attendanceCount = Attendance::whereYear('date', $year)
                ->whereMonth('date', $m)
                ->where('status', 'absent')
                ->count();

            $leaveCount = Leave::where('status', 'approved')
                ->whereYear('start_date', '<=', $year)
                ->whereYear('end_date', '>=', $year)
                ->where(function ($query) use ($m, $year) {
                    $query->where(function ($q) use ($m, $year) {
                        $q->whereYear('start_date', $year)->whereMonth('start_date', '<=', $m);
                    })->where(function ($q) use ($m, $year) {
                        $q->whereYear('end_date', $year)->whereMonth('end_date', '>=', $m);
                    });
                })
                ->count();

            $attendanceData[] = $attendanceCount;
            $leaveData[] = $leaveCount;
        }
        $totalApplications = User::where('role', 'employee')->count();

        $totalInterviews = 246;
        $totalHired = User::where('role', 'employee')->where('status', 'active')->count();

        $today = Carbon::today()->toDateString();
        $attendanceToday = Attendance::where('date', $today)
            ->whereIn('status', ['present', 'late', 'half'])
            ->count();

        return view('_admin.dashboard.index', compact(
            'days',
            'totals',
            'attendanceCount',
            'lateCount',
            'absentCount',
            'leaveApplyCount',
            'days',
            'totals',
            'genderChart',
            'attendanceData',
            'leaveData',
            'year',
            'totalApplications',
            'totalInterviews',
            'totalHired',
            'attendanceToday'
        ));
    }
}

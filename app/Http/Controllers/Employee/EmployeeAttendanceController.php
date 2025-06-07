<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class EmployeeAttendanceController extends Controller
{
    public function index(Request $request)
    {
        $agent = new Agent();

        if ($agent->isDesktop()) {
            throw new NotFoundHttpException();
        }

        $userId = Auth::id();
        $startDate = Carbon::parse($request->get('start', now()->startOfWeek()));
        $endDate = Carbon::parse($request->get('end', now()->endOfWeek()));

        $attendances = Attendance::where('user_id', $userId)
            ->whereBetween('date', [$startDate, $endDate])
            ->get()
            ->keyBy(fn($item) => $item->date->format('Y-m-d'));

        $dates = collect();
        for ($date = $startDate->copy(); $date->lte($endDate); $date->addDay()) {
            $dates->push($date->copy());
        }

        return view('_employee.attendance.index', compact('dates', 'attendances'));
    }

    public function showForm()
    {
        $agent = new Agent();

        if ($agent->isDesktop()) {
            throw new NotFoundHttpException();
        }

        $attendance = Attendance::where('user_id', auth()->id())
            ->whereDate('date', now()->toDateString())
            ->first();

        return view('_employee.attendance.form', compact('attendance'));
    }

  public function checkin(Request $request)
    {
        $request->validate([
            'photo' => 'required|string',
        ]);

        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString();

        $existing = Attendance::where('user_id', auth()->id())
            ->where('date', $today)
            ->first();

        if ($existing && $existing->check_in) {
            return response()->json(['error' => 'Anda sudah melakukan check-in hari ini.'], 422);
        }

        $isOnLeave = \App\Models\Leave::where('user_id', auth()->id())
            ->where('status', 'approved')
            ->whereDate('start_date', '<=', $today)
            ->whereDate('end_date', '>=', $today)
            ->exists();

        if ($isOnLeave) {
            return response()->json(['error' => 'Anda sedang cuti hari ini, tidak bisa check-in.'], 422);
        }

        $image = $this->saveBase64Image($request->photo);
        $status = 'present';

        Attendance::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'date' => $today,
            ],
            [
                'date' => $today,
                'check_in' => $now->format('H:i:s'),
                'check_in_photo' => $image,
                'status' => $status,
            ]
        );

        return response()->json(['success' => true]);
    }


    public function checkout(Request $request)
    {
        $request->validate([
            'photo' => 'required|string',
        ]);

        $now = Carbon::now('Asia/Jakarta');
        $today = $now->toDateString();

        $attendance = Attendance::where('user_id', auth()->id())
            ->where('date', $today)
            ->first();

        if (!$attendance || !$attendance->check_in) {
            return response()->json(['error' => 'Anda belum melakukan check-in hari ini.'], 422);
        }

        if ($attendance->check_out) {
            return response()->json(['error' => 'Anda sudah melakukan check-out hari ini.'], 422);
        }

        if ($now->format('H:i:s') < $attendance->check_in) {
            return response()->json(['error' => 'Waktu check-out tidak boleh sebelum check-in.'], 422);
        }

        $image = $this->saveBase64Image($request->photo);

        $attendance->update([
            'check_out' => $now->format('H:i:s'),
            'check_out_photo' => $image,
        ]);

        return response()->json(['success' => true]);
    } 

    private function saveBase64Image($base64)
    {
        $base64 = str_replace('data:image/jpeg;base64,', '', $base64);
        $base64 = str_replace(' ', '+', $base64);
        $filename = 'attendance/' . uniqid() . '.jpg';

        Storage::disk('public')->put($filename, base64_decode($base64));

        return $filename;
    }

}

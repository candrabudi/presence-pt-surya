<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Jenssegers\Agent\Agent;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
class EmployeeProfileController extends Controller
{
    public function index()
    {
        $agent = new Agent();

        if ($agent->isDesktop()) {
            throw new NotFoundHttpException();
        }
        return view('_employee.profile.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'full_name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'position' => 'nullable|string|max:100',
            'gender' => 'nullable|in:male,female,other',
            'birth_date' => 'nullable|date',
        ];

        if ($request->filled('password')) {
            $rules['current_password'] = ['required'];
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        $validated = $request->validate($rules);

        $user->fill($validated);

        if ($request->filled('password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors(['current_password' => 'Password lama tidak cocok'])->withInput();
            }

            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }
}

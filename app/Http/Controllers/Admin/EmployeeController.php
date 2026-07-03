<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\EmployeeRequest;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->keyword;

        $employees = Employee::with('services')
            ->search($keyword)
            ->latest()->paginate(9)->withQueryString();

        return view('admin.employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $services = Service::all();
        return view('admin.employees.create', compact('services'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmployeeRequest $request)
    {
        $employee = Employee::create([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        // Lưu quan hệ vào bảng employee_services
        $employee->services()->sync($request->service_ids);
        return redirect()->route('admin.employees.index')
            ->with('success', 'Thêm nhân viên thành công.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Employee $employee)
    {
        $services = Service::all();
        return view('admin.employees.edit', compact('employee', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmployeeRequest $request, Employee $employee)
    {
        $employee->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email
        ]);

        $employee->services()->sync($request->service_ids);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Cập nhật nhân viên thành công.');
    }

    /**
     * Remove the specified resource from storage.
     */
    // public function destroy(Employee $employee)
    // {
    //     $employee->services()->detach();
    //     $employee->delete();
    //     return redirect()->route('admin.employees.index')
    //         ->with('success', 'Xóa nhân viên thành công.');
    // }

    public function destroy(Employee $employee)
    {
        $hasAppointment = $employee->appointments()
            ->whereIn('status', [
                'confirmed',
                'completed',
            ])
            ->exists();

        if ($hasAppointment) {
            return back()->with(
                'error',
                'Không thể xóa nhân viên vì đã hoặc đang được phân công thực hiện lịch hẹn.'
            );
        }

        $employee->services()->detach();
        $employee->delete();

        return redirect()
            ->route('admin.employees.index')
            ->with('success', 'Xóa nhân viên thành công.');
    }
}

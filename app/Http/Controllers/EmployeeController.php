<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use App\Http\Resources\EmployeeResource;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployeesExport;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{


    public function index(Request $request)
    {
        $query = Employee::query();

        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('position', 'like', "%$search%");
            });
        }

        if ($sort = $request->get('sort')) {
            $dir = $request->get('dir', 'asc');
            $query->orderBy($sort, $dir);
        }

        $perPage = $request->get('perPage', 10);
        $employees = $query->paginate($perPage);

        return EmployeeResource::collection($employees);
    }

    public function store(Request $request)
    {
        //return $request;

        $data = $request->validate([
        'firstName' => 'required|string|max:100',
        'lastName' => 'required|string|max:100',
        'email' => 'required|email|unique:employees,email',
        'phone' => 'nullable|string|max:30',
        'position' => 'nullable|string|max:120',
        'salary' => 'nullable|numeric',
        'hiredAt' => 'nullable|date',
        'status' => 'in:active,inactive'
        ]);


        $employee = Employee::create([
            'firstName' => $data['firstName'],
            'lastName' => $data['lastName'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'position' => $data['position'] ?? null,
            'salary' => $data['salary'] ?? 0,
            'hired_at' => $data['hiredAt'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);
        return response()->json($employee, 201);

        // return new EmployeeResource($employee);
    }

    public function update(Request $request, Employee $employee)
    {
        $data = $request->validate([
            'firstName' => 'sometimes|string|max:100',
            'lastName' => 'sometimes|string|max:100',
            'email' => 'sometimes|email|unique:employees,email,' . $employee->id,
            'phone' => 'nullable|string|max:30',
            'position' => 'nullable|string|max:120',
            'salary' => 'nullable|numeric',
            'hiredAt' => 'nullable|date',
            'status' => 'in:active,inactive'
        ]);

        $employee->update([
            'first_name' => $data['firstName'] ?? $employee->first_name,
            'last_name' => $data['lastName'] ?? $employee->last_name,
            'email' => $data['email'] ?? $employee->email,
            'phone' => $data['phone'] ?? $employee->phone,
            'position' => $data['position'] ?? $employee->position,
            'salary' => $data['salary'] ?? $employee->salary,
            'hired_at' => $data['hiredAt'] ?? $employee->hired_at,
            'status' => $data['status'] ?? $employee->status,
        ]);

        return new EmployeeResource($employee);
    }

    public function destroy($id)
    {
        $employee = Employee::find($id);

        if (!$employee) {
            return response()->json(['message' => 'Employee not found'], 404);
        }

        $employee->delete();

        return response()->json(['message' => 'Employee deleted successfully']);
    }
    public function show($id)
    {
        $employee = \App\Models\Employee::findOrFail($id);

        return response()->json([
            'id' => $employee->id,
            'firstName' => $employee->first_name,
            'lastName' => $employee->last_name,
            'email' => $employee->email,
            'phone' => $employee->phone,
            'position' => $employee->position,
            'salary' => $employee->salary,
            'hiredAt' => $employee->hired_at ? $employee->hired_at->format('Y-m-d') : null,
            'status' => $employee->status,
            'updatedAt' => $employee->updated_at->toIso8601String(),
        ]);
    }


    public function export(Request $request)
    {
        return Excel::download(new EmployeesExport($request), 'employees.xlsx');
    }
}

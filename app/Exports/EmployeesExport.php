<?php

namespace App\Exports;

use App\Models\Employee;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class EmployeesExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = Employee::query();

        // Search
        if ($search = $this->request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('email', 'like', "%$search%");
            });
        }

        // Sorting
        $allowedSorts = ['last_name','position','salary','hired_at','status','updated_at'];
        if ($sort = $this->request->get('sort')) {
            $dir = $this->request->get('dir', 'asc');
            if (in_array($sort, $allowedSorts)) {
                $query->orderBy($sort, $dir);
            }
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'First Name',
            'Last Name',
            'Email',
            'Phone',
            'Position',
            'Salary',
            'Hired At',
            'Status',
            'Updated At',
        ];
    }

    public function map($employee): array
    {
        return [
            $employee->id,
            $employee->firstName,
            $employee->lastName,
            $employee->email,
            $employee->phone,
            $employee->position,
            (float) number_format($employee->salary, 2, '.', ''),
            $employee->hired_at ? $employee->hired_at->format('Y-m-d') : null,
            $employee->status,
            $employee->updated_at ? $employee->updated_at->toIso8601String() : null,
        ];
    }
}

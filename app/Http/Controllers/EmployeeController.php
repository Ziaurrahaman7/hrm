<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Skill;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::with(['department', 'skills'])->get();
        $departments = Department::all();
        return view('employees.index', compact('employees', 'departments'));
    }

    public function create()
    {
        $departments = Department::all();
        $skills = Skill::all();
        return view('employees.create', compact('departments', 'skills'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email',
            'department_id' => 'required|exists:departments,id',
            'skills' => 'array',
            'skills.*' => 'exists:skills,id',
            'custom_skills' => 'array',
            'custom_skills.*' => 'string|max:255'
        ]);

        $employee = Employee::create($request->only(['first_name', 'last_name', 'email', 'department_id']));
        
        $skillIds = $request->skills ?? [];
        
        // Create custom skills and add to skill IDs
        if ($request->has('custom_skills')) {
            foreach ($request->custom_skills as $skillName) {
                if (!empty(trim($skillName))) {
                    $skill = Skill::firstOrCreate(['name' => trim($skillName)]);
                    $skillIds[] = $skill->id;
                }
            }
        }
        
        if (!empty($skillIds)) {
            $employee->skills()->sync($skillIds);
        }

        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        $employee->load(['department', 'skills']);
        return view('employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        $departments = Department::all();
        $skills = Skill::all();
        $employee->load('skills');
        return view('employees.edit', compact('employee', 'departments', 'skills'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:employees,email,' . $employee->id,
            'department_id' => 'required|exists:departments,id',
            'skills' => 'array',
            'skills.*' => 'exists:skills,id',
            'custom_skills' => 'array',
            'custom_skills.*' => 'string|max:255'
        ]);

        $employee->update($request->only(['first_name', 'last_name', 'email', 'department_id']));
        
        $skillIds = $request->skills ?? [];
        
        // Create custom skills and add to skill IDs
        if ($request->has('custom_skills')) {
            foreach ($request->custom_skills as $skillName) {
                if (!empty(trim($skillName))) {
                    $skill = Skill::firstOrCreate(['name' => trim($skillName)]);
                    $skillIds[] = $skill->id;
                }
            }
        }
        
        $employee->skills()->sync($skillIds);

        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }

    public function filterByDepartment($departmentId)
    {
        $employees = Employee::with(['department', 'skills'])
            ->where('department_id', $departmentId)
            ->get();
        return response()->json($employees);
    }

    public function checkEmail(Request $request)
    {
        $exists = Employee::where('email', $request->email)
            ->where('id', '!=', $request->employee_id)
            ->exists();
        return response()->json(['exists' => $exists]);
    }
}

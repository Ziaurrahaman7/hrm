<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::withCount('employees')->get();
        return view('departments.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name'
        ]);

        Department::create($request->only('name'));
        return redirect()->route('departments.index')->with('success', 'Department created successfully.');
    }
    
    public function update(Request $request, Department $department)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:departments,name,' . $department->id
        ]);

        $department->update($request->only('name'));
        return redirect()->route('departments.index')->with('success', 'Department updated successfully.');
    }
    
    public function destroy(Department $department)
    {
        $department->delete();
        return redirect()->route('departments.index')->with('success', 'Department deleted successfully.');
    }
}

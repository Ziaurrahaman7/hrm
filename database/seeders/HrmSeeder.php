<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Skill;
use App\Models\Employee;
use Illuminate\Database\Seeder;

class HrmSeeder extends Seeder
{
    public function run(): void
    {
        // Create Departments
        $departments = [
            'Human Resources',
            'Information Technology', 
            'Finance',
            'Marketing',
            'Operations'
        ];
        
        foreach ($departments as $dept) {
            Department::create(['name' => $dept]);
        }
        
        // Create Skills
        $skills = [
            'PHP', 'Laravel', 'JavaScript', 'React', 'Vue.js',
            'Project Management', 'Communication', 'Leadership',
            'Accounting', 'Digital Marketing', 'Data Analysis'
        ];
        
        foreach ($skills as $skill) {
            Skill::create(['name' => $skill]);
        }
        
        // Create Sample Employees
        $employees = [
            ['first_name' => 'John', 'last_name' => 'Doe', 'email' => 'john@company.com', 'department_id' => 2],
            ['first_name' => 'Jane', 'last_name' => 'Smith', 'email' => 'jane@company.com', 'department_id' => 1],
            ['first_name' => 'Mike', 'last_name' => 'Johnson', 'email' => 'mike@company.com', 'department_id' => 3],
        ];
        
        foreach ($employees as $emp) {
            $employee = Employee::create($emp);
            $employee->skills()->attach([1, 2, 6]); // Assign some skills
        }
    }
}

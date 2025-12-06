<x-app-layout>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Employees</h1>
            <a href="{{ route('employees.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add Employee</a>
        </div>

        <!-- Filter -->
        <div class="bg-white p-4 rounded-lg shadow">
            <label class="block text-sm font-medium text-gray-700 mb-2">Filter by Department:</label>
            <select id="departmentFilter" class="border border-gray-300 rounded-md px-3 py-2">
                <option value="">All Departments</option>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Employees Table -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Department</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Skills</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody id="employeeTableBody" class="bg-white divide-y divide-gray-200">
                    @foreach($employees as $employee)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $employee->full_name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $employee->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $employee->department->name }}</td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            @foreach($employee->skills as $skill)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">{{ $skill->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <a href="{{ route('employees.show', $employee) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                            <a href="{{ route('employees.edit', $employee) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                            <form action="{{ route('employees.destroy', $employee) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        const originalTableBody = $('#employeeTableBody').html();
        
        $('#departmentFilter').change(function() {
            const departmentId = $(this).val();
            
            // Show loading
            $('#employeeTableBody').html('<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">Loading...</td></tr>');
            
            if (departmentId) {
                $.get(`/employees/filter/${departmentId}`)
                    .done(function(employees) {
                        let html = '';
                        if (employees.length === 0) {
                            html = '<tr><td colspan="5" class="px-6 py-4 text-center text-gray-500">No employees found in this department.</td></tr>';
                        } else {
                            employees.forEach(employee => {
                                let skills = employee.skills.map(skill => 
                                    `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 mr-1">${skill.name}</span>`
                                ).join('');
                                
                                html += `<tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">${employee.first_name} ${employee.last_name}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${employee.email}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${employee.department.name}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">${skills}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="/employees/${employee.id}" class="text-indigo-600 hover:text-indigo-900 mr-3">View</a>
                                        <a href="/employees/${employee.id}/edit" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                        <form action="/employees/${employee.id}" method="POST" class="inline">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>`;
                            });
                        }
                        $('#employeeTableBody').html(html);
                    })
                    .fail(function() {
                        $('#employeeTableBody').html('<tr><td colspan="5" class="px-6 py-4 text-center text-red-500">Error loading employees.</td></tr>');
                    });
            } else {
                // Show all employees (restore original)
                $('#employeeTableBody').html(originalTableBody);
            }
        });
    </script>
</x-app-layout>
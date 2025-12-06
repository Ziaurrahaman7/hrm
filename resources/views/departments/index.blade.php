<x-app-layout>
    <div class="space-y-6">
        <div class="flex justify-between items-center">
            <h1 class="text-2xl font-bold text-gray-900">Departments</h1>
        </div>

        <!-- Add Department Form -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Add New Department</h3>
            <form action="{{ route('departments.store') }}" method="POST" class="space-y-3">
                @csrf
                <div class="flex gap-4">
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Department Name" class="flex-1 border border-gray-300 rounded-md px-3 py-2" required>
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Add Department</button>
                </div>
                @error('name')<div class="text-red-500 text-sm">{{ $message }}</div>@enderror
            </form>
        </div>

        <!-- Departments List -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Employees Count</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($departments as $department)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $department->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $department->employees_count }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="editDepartment({{ $department->id }}, '{{ $department->name }}')" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                            <form action="/departments/{{ $department->id }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Edit Modal -->
        <div id="editModal" class="hidden fixed inset-0 z-50" onclick="closeModal()">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="fixed inset-0 bg-black bg-opacity-50"></div>
                <div class="relative bg-white rounded-lg shadow-lg w-96" onclick="event.stopPropagation()">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Edit Department</h3>
                        <form id="editForm" method="POST">
                            @csrf @method('PUT')
                            <input type="text" id="editName" name="name" 
                                class="w-full border border-gray-300 rounded-md px-3 py-2 mb-4 focus:outline-none focus:ring-2 focus:ring-blue-500" 
                                placeholder="Department name" required>
                            <div class="flex justify-end space-x-3">
                                <button type="button" onclick="closeModal()" 
                                    class="px-4 py-2 text-gray-600 hover:text-gray-800">
                                    Cancel
                                </button>
                                <button type="submit" 
                                    class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function editDepartment(id, name) {
                document.getElementById('editName').value = name;
                document.getElementById('editForm').action = '/departments/' + id;
                document.getElementById('editModal').classList.remove('hidden');
            }
            
            function closeModal() {
                document.getElementById('editModal').classList.add('hidden');
            }
        </script>
    </div>
</x-app-layout>
<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Add New Employee</h1>

        <form action="{{ route('employees.store') }}" method="POST" class="bg-white shadow rounded-lg p-6">
            @csrf
            
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                    @error('first_name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                    @error('last_name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                <div id="emailCheck" class="text-sm mt-1"></div>
                @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Department</label>
                <select name="department_id" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                    <option value="">Select Department</option>
                    @foreach($departments as $department)
                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>{{ $department->name }}</option>
                    @endforeach
                </select>
                @error('department_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Skills</label>
                <div id="skillsContainer">
                    @foreach($skills as $skill)
                        <label class="inline-flex items-center mr-4 mb-2">
                            <input type="checkbox" name="skills[]" value="{{ $skill->id }}" class="rounded border-gray-300 text-blue-600">
                            <span class="ml-2 text-sm text-gray-700">{{ $skill->name }}</span>
                        </label>
                    @endforeach
                </div>
                <button type="button" id="addSkillBtn" class="mt-2 text-blue-600 hover:text-blue-800 text-sm">+ Add Custom Skill</button>
                <div id="customSkills"></div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('employees.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Save Employee</button>
            </div>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Real-time email validation
        $('#email').on('blur', function() {
            const email = $(this).val();
            if (email) {
                $.post('/check-email', {
                    email: email,
                    _token: '{{ csrf_token() }}'
                }, function(response) {
                    if (response.exists) {
                        $('#emailCheck').html('<span class="text-red-500">Email already exists!</span>');
                    } else {
                        $('#emailCheck').html('<span class="text-green-500">Email available</span>');
                    }
                });
            }
        });

        // Dynamic skill addition
        $('#addSkillBtn').click(function() {
            const skillHtml = `
                <div class="flex items-center mt-2 skill-input">
                    <input type="text" name="custom_skills[]" class="flex-1 border border-gray-300 rounded-md px-3 py-2 mr-2" placeholder="Enter skill name">
                    <button type="button" class="bg-red-500 text-white px-3 py-2 rounded-md hover:bg-red-600 remove-skill">Remove</button>
                </div>
            `;
            $('#customSkills').append(skillHtml);
        });

        $(document).on('click', '.remove-skill', function() {
            $(this).closest('.skill-input').remove();
        });
    </script>
</x-app-layout>
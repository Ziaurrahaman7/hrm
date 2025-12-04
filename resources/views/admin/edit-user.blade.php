<x-app-layout>
    <div class="max-w-2xl mx-auto">
        <h1 class="text-2xl font-bold text-gray-900 mb-6">Edit User</h1>

        <form action="{{ route('admin.users.update', $user) }}" method="POST" class="bg-white shadow rounded-lg p-6">
            @csrf @method('PUT')
            
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                @error('name')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border border-gray-300 rounded-md px-3 py-2" required>
                @error('email')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Password (leave blank to keep current)</label>
                <input type="password" name="password" class="w-full border border-gray-300 rounded-md px-3 py-2">
                @error('password')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-2">Confirm Password</label>
                <input type="password" name="password_confirmation" class="w-full border border-gray-300 rounded-md px-3 py-2">
            </div>

            <div class="mb-6">
                <label class="inline-flex items-center">
                    <input type="checkbox" name="is_admin" value="1" {{ $user->is_admin ? 'checked' : '' }} class="rounded border-gray-300 text-blue-600">
                    <span class="ml-2 text-sm text-gray-700">Admin User</span>
                </label>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('admin.users') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg hover:bg-gray-400">Cancel</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Update User</button>
            </div>
        </form>
    </div>
</x-app-layout>
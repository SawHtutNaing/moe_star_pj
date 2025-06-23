<div>
    <div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl p-6 transition-all duration-300">
            <h1 class="text-2xl font-semibold text-gray-800 mb-6 sm:text-3xl">User Management</h1>

            @if ($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 px-4 py-3 rounded-lg mb-6 animate-fade-in">
                    {!! implode('', $errors->all('<div>:message</div>')) !!}
                </div>
            @endif

            <a href="{{ route('users.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg mb-6 transition-colors duration-200 inline-flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Create New User
            </a>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Name</th>
                            <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Email</th>
                            <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Role</th>
                            <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Status</th>
                            <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($users as $user)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $user->name }}</td>
                                <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $user->email }}</td>
                                <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $user->role }}</td>
                                <td class="px-4 py-4 sm:px-6 text-sm {{ $user->status ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $user->status ? 'Enabled' : 'Disabled' }}
                                </td>
                                <td class="px-4 py-4 sm:px-6 flex flex-col sm:flex-row gap-2 flex-wrap">
                                    <a href="{{ route('users.edit', $user->id) }}"
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-1 px-3 rounded-lg transition-colors duration-200 text-xs text-center">
                                        Edit
                                    </a>
                                    <button wire:click="toggleStatus({{ $user->id }})"
                                            class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded-lg transition-colors duration-200 text-xs text-center">
                                        {{ $user->status ? 'Disable' : 'Enable' }}
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fade-in {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    .animate-fade-in {
        animation: fade-in 0.3s ease-in;
    }
</style>

</div>

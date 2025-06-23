<div>
    <div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl p-6 transition-all duration-300">
            <h2 class="text-2xl font-semibold text-gray-800 mb-6 sm:text-3xl">Driver Management</h2>

            <button wire:click="create" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg mb-6 transition-colors duration-200 flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Add Driver
            </button>

            @if (session()->has('message'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6 animate-fade-in">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Modal -->
            @if ($isOpen)
                <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 px-4 sm:px-0">
                    <div class="bg-white p-6 rounded-xl w-full max-w-lg shadow-2xl animate-slide-up">
                        <h3 class="text-xl font-semibold text-gray-800 mb-6">{{ $driver_id ? 'Edit Driver' : 'Add Driver' }}</h3>
                        <form wire:submit.prevent="store">
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                                <input type="text" wire:model="name" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-5">
                                <label class="block text-sm font-medium text-gray-700 mb-1">NRC Number</label>
                                <input type="text" wire:model="nrc_number" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                @error('nrc_number') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" wire:click="closeModal" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm">Cancel</button>
                                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Name</th>
                            <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">NRC Number</th>
                            <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($drivers as $driver)
                            <tr class="hover:bg-gray-50 transition-colors duration-200">
                                <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $driver->name }}</td>
                                <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $driver->nrc_number }}</td>
                                <td class="px-4 py-4 sm:px-6 flex gap-2 flex-wrap">
                                    <button wire:click="edit({{ $driver->id }})" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-1 px-3 rounded-lg transition-colors duration-200 text-xs">Edit</button>
                                    <button wire:click="delete({{ $driver->id }})" class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded-lg transition-colors duration-200 text-xs">Delete</button>
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
    @keyframes slide-up {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }
    .animate-slide-up {
        animation: slide-up 0.3s ease-out;
    }
</style>
</div>

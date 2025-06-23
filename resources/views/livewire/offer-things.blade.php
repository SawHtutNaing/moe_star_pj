<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            <h2 class="text-2xl font-bold mb-4">Offer Things Management</h2>

            <button wire:click="create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">Add Offer Thing</button>

            @if (session()->has('message'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('message') }}
                </div>
            @endif

            <!-- Modal -->
            @if ($isOpen)
                <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded-lg w-full max-w-md">
                        <h3 class="text-lg font-bold mb-4">{{ $offer_thing_id ? 'Edit Offer Thing' : 'Add Offer Thing' }}</h3>
                        <form wire:submit.prevent="store">
                            <div class="mb-4">
                                <label class="block text-gray-700">Name</label>
                                <input type="text" wire:model="name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label class="block text-gray-700">Pricing</label>
                                <input type="number" step="0.01" wire:model="pricing" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                @error('pricing') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div class="mb-4">
                                <label class="flex items-center">
                                    <input type="checkbox" wire:model="is_active" class="mr-2">
                                    <span class="text-gray-700">Active</span>
                                </label>
                            </div>
                            <div class="flex justify-end">
                                <button type="button" wire:click="closeModal" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancel</button>
                                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead>
                        <tr>
                            <th class="px-6 py-3 border-b text-left text-gray-700">Name</th>
                            <th class="px-6 py-3 border-b text-left text-gray-700">Pricing</th>
                            <th class="px-6 py-3 border-b text-left text-gray-700">Active</th>
                            <th class="px-6 py-3 border-b text-left text-gray-700">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($offer_things as $offer_thing)
                            <tr>
                                <td class="px-6 py-4 border-b">{{ $offer_thing->name }}</td>
                                <td class="px-6 py-4 border-b">{{ $offer_thing->pricing }}</td>
                                <td class="px-6 py-4 border-b">{{ $offer_thing->is_active ? 'Yes' : 'No' }}</td>
                                <td class="px-6 py-4 border-b">
                                    <button wire:click="edit({{ $offer_thing->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</button>
                                    <button wire:click="delete({{ $offer_thing->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

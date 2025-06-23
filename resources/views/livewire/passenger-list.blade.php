<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 py-6">
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
        <h2 class="text-2xl font-bold mb-4">Passengers for Trip Starting {{ $trip->start_time->format('Y-m-d H:i') }}</h2>

        <button wire:click="create" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4">Add Passenger</button>
        <a href="{{ route('trips') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mb-4 ml-2">Back to Trips</a>

        @if (session()->has('message'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('message') }}
            </div>
        @endif

        <!-- Modal -->
        @if ($isOpen)
            <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-lg w-full max-w-md">
                    <h3 class="text-lg font-bold mb-4">{{ $passenger_id ? 'Edit Passenger' : 'Add Passenger' }}</h3>
                    <form wire:submit.prevent="store">
                        <div class="mb-4">
                            <label class="block text-gray-700">Passenger Name</label>
                            <input type="text" wire:model="passenger_name" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @error('passenger_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Passenger Phone</label>
                            <input type="text" wire:model="passenger_phone" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @error('passenger_phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Passenger NRC</label>
                            <input type="text" wire:model="passenger_nrc" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                            @error('passenger_nrc') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="flex items-center">
                                <input type="checkbox" wire:model="car_front_cabin" class="mr-2">
                                <span class="text-gray-700">Car Front Cabin (သူပါရင် passenger တွေအားလုံးရဲ့ price ကို 5000 တိုးပါတယ်)</span>
                            </label>
                            @error('car_front_cabin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Passenger Type</label>
                            <select wire:model="passenger_type_id" class="w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
                                <option value="">Select Passenger Type</option>
                                @foreach ($passenger_types as $type)
                                    <option value="{{ $type->id }}">{{ $type->type }} ({{ $type->pricing }})</option>
                                @endforeach
                            </select>
                            @error('passenger_type_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-4">
                            <label class="block text-gray-700">Offer Things</label>
                            @foreach ($offer_things as $offer_thing)
                                <label class="flex items-center mb-2">
                                    <input type="checkbox" wire:model="offer_thing_ids" value="{{ $offer_thing->id }}" class="mr-2">
                                    <span>{{ $offer_thing->name }} ({{ $offer_thing->pricing }})</span>
                                </label>
                            @endforeach
                            @error('offer_thing_ids') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                        <th class="px-6 py-3 border-b text-left text-gray-700">Phone</th>
                        <th class="px-6 py-3 border-b text-left text-gray-700">NRC</th>
                        <th class="px-6 py-3 border-b text-left text-gray-700">Car Front Cabin</th>
                        <th class="px-6 py-3 border-b text-left text-gray-700">Passenger Type</th>
                        <th class="px-6 py-3 border-b text-left text-gray-700">Type Pricing</th>
                        <th class="px-6 py-3 border-b text-left text-gray-700">Offer Things</th>
                        <th class="px-6 py-3 border-b text-left text-gray-700">Total Pricing</th>
                        <th class="px-6 py-3 border-b text-left text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($trip->passengers as $passenger)
                        <tr>
                            <td class="px-6 py-4 border-b">{{ $passenger->passenger_name }}</td>
                            <td class="px-6 py-4 border-b">{{ $passenger->passenger_phone }}</td>
                            <td class="px-6 py-4 border-b">{{ $passenger->passenger_nrc }}</td>
                            <td class="px-6 py-4 border-b">{{ $passenger->car_front_cabin ? 'Yes' : 'No' }}</td>
                            <td class="px-6 py-4 border-b">{{ $passenger->passenger_type }}</td>
                            <td class="px-6 py-4 border-b">{{ $passenger->passenger_type_pricing }}</td>
                            <td class="px-6 py-4 border-b">
                                @php
                                    $offerThings = json_decode($passenger->offer_things, true);
                                    if (is_array($offerThings)) {
                                        echo implode(', ', array_map(function($item) { return $item['name'] . ' (' . $item['pricing'] . ')'; }, $offerThings));
                                    }
                                @endphp
                            </td>
                            <td class="px-6 py-4 border-b">{{ $passenger->total_pricing }}</td>
                            <td class="px-6 py-4 border-b">
                                <button wire:click="edit({{ $passenger->id }})" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-2 rounded">Edit</button>
                                <button wire:click="deletePassenger({{ $passenger->id }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 rounded">Delete</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

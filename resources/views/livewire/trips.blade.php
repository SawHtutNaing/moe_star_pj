<div>
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-xl p-6 transition-all duration-300">
                <h2 class="text-2xl font-semibold text-gray-800 mb-6 sm:text-3xl">Trip Management</h2>

                <button wire:click="create" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg mb-6 transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add Trip
                </button>

                @if (session()->has('message'))
                    <div class="bg-green-50 border-l-4 border-green-500 text-green-700 px-4 py-3 rounded-lg mb-6 animate-fade-in">
                        {{ session('message') }}
                    </div>
                @endif

                <!-- Trip Modal -->
                @if ($isOpen)
                    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 px-4 sm:px-0">
                        <div class="bg-white p-6 rounded-xl w-full max-w-3xl shadow-2xl animate-slide-up">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">{{ $trip_id ? 'Edit Trip' : 'Add Trip' }}</h3>
                            <form wire:submit.prevent="store">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Time</label>
                                        <input type="datetime-local" wire:model="start_time" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                        @error('start_time') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Driver</label>
                                        <select wire:model="driver_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                            <option value="">Select Driver</option>
                                            @foreach ($drivers as $driver)
                                                <option value="{{ $driver->id }}">{{ $driver->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('driver_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Car</label>
                                        <select wire:model="car_id" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                            <option value="">Select Car</option>
                                            @foreach ($cars as $car)
                                                <option value="{{ $car->id }}">{{ $car->name }} ({{ $car->license_plate ?? 'N/A' }})</option>
                                            @endforeach
                                        </select>
                                        @error('car_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Start Car Gate</label>
                                        <select wire:model="start_car_gate" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                            <option value="">Select Car Gate</option>
                                            @foreach ($car_gates as $car_gate)
                                                <option value="{{ $car_gate->name }}">{{ $car_gate->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('start_car_gate') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">End Car Gate</label>
                                        <select wire:model="end_gate" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                            <option value="">Select Car Gate</option>
                                            @foreach ($car_gates as $car_gate)
                                                <option value="{{ $car_gate->name }}">{{ $car_gate->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('end_gate') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Fee for Driver</label>
                                        <input type="number" step="0.01" wire:model="fee_for_driver" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                        @error('fee_for_driver') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Car Oil Pricing</label>
                                        <input type="number" step="0.01" wire:model="car_oil_pricing" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                        @error('car_oil_pricing') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">Fee for Bridge Pass</label>
                                        <input type="number" step="0.01" wire:model="fee_for_bridge_pass" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                        @error('fee_for_bridge_pass') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Fee for Gate Pass</label>
                                    <input type="number" step="0.01" wire:model="fee_for_gate_pass" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                    @error('fee_for_gate_pass') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div class="mb-5">
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Deductions</label>
                                    <button type="button" wire:click="openDeductionModal" class="bg-green-600 hover:bg-green-700 text-white font-medium py-1 px-3 rounded-lg mb-2 transition-colors duration-200 text-sm">Add Deduction</button>
                                    @if (!empty($deductions))
                                        <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm mb-4">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Reason</th>
                                                    <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Amount</th>
                                                    <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                @foreach ($deductions as $index => $deduction)
                                                    <tr class="hover:bg-gray-50 transition-colors duration-200">
                                                        <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $deduction['reason'] }}</td>
                                                        <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $deduction['amount'] }}</td>
                                                        <td class="px-4 py-4 sm:px-6">
                                                            <button wire:click="removeDeduction({{ $index }})" class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded-lg transition-colors duration-200 text-xs">Remove</button>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endif
                                </div>
                                <div class="flex justify-end gap-3">
                                    <button type="button" wire:click="closeModal" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm">Cancel</button>
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endif

                <!-- Deduction Modal -->
                @if ($isDeductionModalOpen)
                    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center z-50 px-4 sm:px-0">
                        <div class="bg-white p-6 rounded-xl w-full max-w-lg shadow-2xl animate-slide-up">
                            <h3 class="text-xl font-semibold text-gray-800 mb-6">Add Deduction</h3>
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-5">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                                    <input type="text" wire:model="deduction_reason" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                    @error('deduction_reason') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Amount</label>
                                    <input type="number" step="0.01" wire:model="deduction_amount" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 transition-all duration-200 text-sm">
                                    @error('deduction_amount') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                                </div>
                            </div>
                            <div class="flex justify-end gap-3">
                                <button type="button" wire:click="closeDeductionModal" class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm">Cancel</button>
                                <button wire:click="addDeduction" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 text-sm">Add</button>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Start Time</th>
                                <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Start Car Gate</th>
                                <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">End Car Gate</th>
                                <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Driver</th>
                                <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Car</th>
                                <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Fee for Driver</th>
                                <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Car Oil Pricing</th>
                                <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Bridge Pass Fee</th>
                                <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Gate Pass Fee</th>
                                <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Deductions</th>
                                <th class="px-4 py-3 sm:px-6 text-left text-sm font-medium text-gray-700 tracking-wide">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach ($trips as $trip)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $trip->start_time->format('Y-m-d H:i') }}</td>
                                    <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $trip->start_car_gate }}</td>
                                    <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $trip->end_gate }}</td>
                                    <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $trip->driver ? $trip->driver->name : 'N/A' }}</td>
                                    <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $trip->car ? $trip->car->name : 'N/A' }}</td>
                                    <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $trip->fee_for_driver }}</td>
                                    <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $trip->car_oil_pricing }}</td>
                                    <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $trip->fee_for_bridge_pass }}</td>
                                    <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">{{ $trip->fee_for_gate_pass }}</td>
                                    <td class="px-4 py-4 sm:px-6 text-sm text-gray-900">
                                        @if ($trip->deductions)
                                            @foreach ($trip->deductions as $deduction)
                                                {{ $deduction['reason'] }}: {{ $deduction['amount'] }}<br>
                                            @endforeach
                                        @else
                                            <span class="text-gray-500">None</span>
                                        @endif
                                    </td>
                                    <td class="px-4 py-4 sm:px-6 flex gap-2 flex-wrap">
                                        <button wire:click="edit({{ $trip->id }})" class="bg-yellow-500 hover:bg-yellow-600 text-white font-medium py-1 px-3 rounded-lg transition-colors duration-200 text-xs">Edit</button>
                                        <button wire:click="delete({{ $trip->id }})" class="bg-red-500 hover:bg-red-600 text-white font-medium py-1 px-3 rounded-lg transition-colors duration-200 text-xs">Delete</button>
                                        <a href="{{ route('passenger-list', $trip->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-1 px-3 rounded-lg transition-colors duration-200 text-xs">View Passengers</a>
                                        <button wire:click="exportVoucher({{ $trip->id }})" class="bg-green-600 hover:bg-green-700 text-white font-medium py-1 px-3 rounded-lg transition-colors duration-200 text-xs">Export Voucher</button>
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

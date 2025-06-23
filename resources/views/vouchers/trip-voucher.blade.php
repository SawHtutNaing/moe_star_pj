<div style="max-width: 800px; margin: 0 auto; padding: 20px; font-family: noto_sans_myanmar, sans-serif;">
    <h1 style="font-size: 24px; font-weight: bold; text-align: center; margin-bottom: 20px;">Trip Voucher</h1>

    <!-- Trip Details Table -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr>
                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Field</th>
                <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Value</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">From Gate</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ mb_convert_encoding($trip->start_car_gate, 'UTF-8', 'auto') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">To Gate</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ mb_convert_encoding($trip->end_gate, 'UTF-8', 'auto') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">Driver Name</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $trip->driver ? mb_convert_encoding($trip->driver->name, 'UTF-8', 'auto') : 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">Car Name</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $trip->car ? mb_convert_encoding($trip->car->name, 'UTF-8', 'auto') : 'N/A' }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">Start Time</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ $trip->start_time->format('Y-m-d H:i') }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">Car Oil Pricing</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ number_format($trip->car_oil_pricing, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">Fee for Bridge Pass</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ number_format($trip->fee_for_bridge_pass, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">Fee for Gate Pass</td>
                <td style="padding: 8px; border: 1px solid #ddd;">{{ number_format($trip->fee_for_gate_pass, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">From Gate Passenger Total</td>
                <td style="padding: 8px; border: 1px solid #ddd;">
                    {{ $trip->passengers->where('passenger_type', 'from_gate')->count() }}
                    (Cabin: {{ $trip->passengers->where('car_front_cabin', true)->where('passenger_type', 'from_gate')->count() }},
                    Normal: {{ $trip->passengers->where('passenger_type', 'from_gate')->where('car_front_cabin', false)->count() }})
                </td>
            </tr>
            <tr>
                <td style="padding: 8px; border: 1px solid #ddd;">From Route Passenger Total</td>
                <td style="padding: 8px; border: 1px solid #ddd;">
                    {{ $trip->passengers->where('passenger_type', 'from_route')->count() }}
                    (Cabin: {{ $trip->passengers->where('car_front_cabin', true)->where('passenger_type', 'from_route')->count() }},
                    Normal: {{ $trip->passengers->where('passenger_type', 'from_route')->where('car_front_cabin', false)->count() }})
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Offer Things Total -->
    <div style="margin-bottom: 20px;">
        <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 8px;">Offer Things Total</h2>
        @php
            $offerThingsTotal = $trip->passengers->sum(function ($passenger) {
                return collect($passenger->offer_things)->sum('pricing');
            });
        @endphp
        <p>Total Offer Things Fee: {{ number_format($offerThingsTotal, 2) }}</p>
    </div>

    <!-- Deductions Table -->
    <div style="margin-bottom: 20px;">
        <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 8px;">Deductions</h2>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr>
                    <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Reason</th>
                    <th style="padding: 8px; border: 1px solid #ddd; text-align: left;">Amount</th>
                </tr>
            </thead>
            <tbody>
                @if ($trip->deductions)
                    @foreach ($trip->deductions as $deduction)
                        <tr>
                            <td style="padding: 8px; border: 1px solid #ddd;">{{ mb_convert_encoding($deduction['reason'], 'UTF-8', 'auto') }}</td>
                            <td style="padding: 8px; border: 1px solid #ddd;">{{ number_format($deduction['amount'], 2) }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td style="padding: 8px; border: 1px solid #ddd;">No Deductions</td>
                        <td style="padding: 8px; border: 1px solid #ddd;">0.00</td>
                    </tr>
                @endif
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">Total Deductions</td>
                    <td style="padding: 8px; border: 1px solid #ddd; font-weight: bold;">{{ number_format(collect($trip->deductions)->sum('amount'), 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Total Calculation -->
    <div>
        <h2 style="font-size: 18px; font-weight: bold; margin-bottom: 8px;">Total Calculation</h2>
        @php
            $passengerPriceTotal = $trip->passengers->sum('total_pricing');
            $deductionTotal = collect($trip->deductions)->sum('amount');
            $total = $passengerPriceTotal - $deductionTotal - $offerThingsTotal;
        @endphp
        <ul style="list-style-type: disc; padding-left: 20px;">
            <li>Passenger Price Total: {{ number_format($passengerPriceTotal, 2) }}</li>
            <li>Deduction Total: {{ number_format($deductionTotal, 2) }}</li>
            <li>Offer Things Total: {{ number_format($offerThingsTotal, 2) }}</li>
            <li><strong>Total: {{ number_format($total, 2) }}</strong></li>
        </ul>
    </div>
</div>

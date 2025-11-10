@extends('layouts.app')
@section('content')

<div class="space-y-6 p-6">
    <h1 class="text-2xl font-bold text-gray-800">Financial Report</h1>

    <!-- Summary Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="rounded-xl bg-gradient-to-r from-green-400 to-green-600 p-6 text-white shadow-lg">
            <h2 class="text-sm font-semibold uppercase">Total Revenue</h2>
            <p class="text-2xl font-bold mt-2">₦{{ number_format($totalRevenue,2) }}</p>
        </div>
        <div class="rounded-xl bg-gradient-to-r from-blue-400 to-blue-600 p-6 text-white shadow-lg">
            <h2 class="text-sm font-semibold uppercase">Total Paid</h2>
            <p class="text-2xl font-bold mt-2">₦{{ number_format($totalPaid,2) }}</p>
        </div>
        <div class="rounded-xl bg-gradient-to-r from-red-400 to-red-600 p-6 text-white shadow-lg">
            <h2 class="text-sm font-semibold uppercase">Outstanding</h2>
            <p class="text-2xl font-bold mt-2">₦{{ number_format($totalRevenue - $totalPaid,2) }}</p>
        </div>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Monthly Sales</h3>
            <canvas id="monthlyChart"></canvas>
        </div>

        <div class="bg-white rounded-xl p-6 shadow-lg">
            <h3 class="text-lg font-semibold mb-4">Quarterly Sales</h3>
            <canvas id="quarterlyChart"></canvas>
        </div>
    </div>

    <!-- Detailed Table -->
    <div class="bg-white rounded-xl p-6 shadow-lg">
        <h3 class="text-lg font-semibold mb-4">Yearly Breakdown</h3>
        <table class="w-full text-left border-collapse">
            <thead>
                <tr>
                    <th class="border-b p-3">Year</th>
                    <th class="border-b p-3">Invoice Count</th>
                    <th class="border-b p-3">Total Amount</th>
                    <th class="border-b p-3">Paid Amount</th>
                    <th class="border-b p-3">Outstanding</th>
                </tr>
            </thead>
            <tbody>
                @foreach($yearlySales as $year => $data)
                <tr>
                    <td class="border-b p-3">{{ $year }}</td>
                    <td class="border-b p-3">{{ $data['invoice_count'] }}</td>
                    <td class="border-b p-3">₦{{ number_format($data['total_amount'],2) }}</td>
                    <td class="border-b p-3">₦{{ number_format($data['paid_amount'],2) }}</td>
                    <td class="border-b p-3">₦{{ number_format($data['total_amount'] - $data['paid_amount'],2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const monthlyLabels = {!! json_encode($monthlySales->keys()) !!};
const monthlyData = {!! json_encode($monthlySales->pluck('total_amount')) !!};

const quarterlyLabels = {!! json_encode($quarterlySales->keys()) !!};
const quarterlyData = {!! json_encode($quarterlySales->pluck('total_amount')) !!};

new Chart(document.getElementById('monthlyChart'), {
    type: 'line',
    data: {
        labels: monthlyLabels,
        datasets: [{
            label: 'Total Sales',
            data: monthlyData,
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.2)',
            tension: 0.4
        }]
    }
});

new Chart(document.getElementById('quarterlyChart'), {
    type: 'bar',
    data: {
        labels: quarterlyLabels,
        datasets: [{
            label: 'Total Sales',
            data: quarterlyData,
            backgroundColor: '#10b981'
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});
</script>
@endsection

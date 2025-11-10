@extends('layouts.app')
@section('content')
   <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Unit Management</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .hover-lift {
            transition: all 0.3s ease;
        }
        .hover-lift:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.1);
        }
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="gradient-bg min-h-screen">
    @if (session('success'))
<div class="bg-green-100 text-green-800 px-4 py-2 rounded-lg mb-4">
    {{ session('success') }}
</div>
@endif

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8 max-w-7xl">
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between mb-8 gap-4 fade-in">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Units Management</h1>
                <p class="text-gray-600 mt-2">Manage and organize your units efficiently</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="relative">
                    <input type="text" placeholder="Search units..." class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full lg:w-64">
                    <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
                <button class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium py-2 px-4 rounded-lg flex items-center gap-2 transition-all duration-300 hover-lift shadow-md">
                    <i class="fas fa-plus-circle"></i>
                    New Unit
                </button>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8 fade-in">
            <div class="glass-effect rounded-xl p-6 shadow-sm hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Total Units</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ count($units) }}</h3>
                    </div>
                    <div class="bg-blue-100 p-3 rounded-full">
                        <i class="fas fa-cubes text-blue-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-green-500">
                    <i class="fas fa-arrow-up mr-1"></i>
                    <span>2 new this week</span>
                </div>
            </div>

            <div class="glass-effect rounded-xl p-6 shadow-sm hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Active Units</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">{{ count($units) - 2 }}</h3>
                    </div>
                    <div class="bg-green-100 p-3 rounded-full">
                        <i class="fas fa-check-circle text-green-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-gray-500">
                    <i class="fas fa-info-circle mr-1"></i>
                    <span>All systems operational</span>
                </div>
            </div>

            <div class="glass-effect rounded-xl p-6 shadow-sm hover-lift">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-gray-500 text-sm">Recently Added</p>
                        <h3 class="text-2xl font-bold text-gray-800 mt-1">2</h3>
                    </div>
                    <div class="bg-purple-100 p-3 rounded-full">
                        <i class="fas fa-clock text-purple-600 text-xl"></i>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm text-blue-500">
                    <i class="fas fa-sync-alt mr-1"></i>
                    <span>Updated just now</span>
                </div>
            </div>
        </div>

        <!-- Units Table -->
        <div class="bg-white rounded-xl shadow-sm overflow-hidden fade-in">
            <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
                <h2 class="text-lg font-semibold text-gray-800">All Units</h2>
                <div class="flex items-center gap-3">
                    <button class="text-gray-500 hover:text-gray-700 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-filter"></i>
                    </button>
                    <button class="text-gray-500 hover:text-gray-700 p-2 rounded-lg hover:bg-gray-100 transition-colors">
                        <i class="fas fa-sort"></i>
                    </button>
                </div>
            </div>

            @if($units && count($units) > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Short Name</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Last Updated</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($units as $unit)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-cube text-blue-600"></i>
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $unit->name }}</div>
                                        <div class="text-sm text-gray-500">ID: {{ $unit->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ $unit->short_name }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Active
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($unit->updated_at)->format('M j, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">

                                         <a href="{{ route("unit.edit",$unit->id) }}" class="text-indigo-600 hover:text-indigo-900 bg-indigo-50 hover:bg-indigo-100 p-2 rounded-lg transition-colors">
                                        <i class="fas fa-edit"></i>
                                        </a>

                                    <form action="{{ route("unit.destroy",$unit->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                                        @method("DELETE")
                                        @csrf
                                        <button class="text-red-600 hover:text-red-900 bg-red-50 hover:bg-red-100 p-2 rounded-lg transition-colors">
                                        <i class="fas fa-trash"></i>
                                    </button>

                                    </form>

                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="px-6 py-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between">
                <div class="text-sm text-gray-700 mb-4 sm:mb-0">
                    Showing <span class="font-medium">1</span> to <span class="font-medium">10</span> of <span class="font-medium">{{ count($units) }}</span> results
                </div>
                <div class="flex space-x-2">
                    <button class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Previous
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700">
                        1
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        2
                    </button>
                    <button class="px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-50">
                        Next
                    </button>
                </div>
            </div>
            @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-cubes text-gray-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">No units yet</h3>
                <p class="text-gray-500 max-w-md mx-auto mb-6">Get started by creating your first unit to organize your inventory.</p>
                <a href="{{ route("unit.create") }}" class="bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 text-white font-medium py-2 px-4 rounded-lg inline-flex items-center gap-2 transition-all duration-300 hover-lift shadow-md">
                    <i class="fas fa-plus-circle"></i>
                    Create Your First Unit
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Add Unit Modal -->
    <div class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4 z-50 hidden" id="addUnitModal">
        <div class="bg-white rounded-xl shadow-2xl max-w-md w-full transform transition-all duration-300 scale-95 opacity-0">
            <div class="p-6 border-b border-gray-200">
                <h3 class="text-xl font-semibold text-gray-800">Add New Unit</h3>
            </div>
            <div class="p-6">
                <form method="POST" action="{{ route("unit.store") }}">
                    @csrf
                    <div class="mb-4">
                        <label for="unitName" class="block text-sm font-medium text-gray-700 mb-1">Unit Name</label>
                        <input type="text" id="unitName" name="name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter unit name">
                    </div>
                    <div class="mb-6">
                        <label for="shortName" class="block text-sm font-medium text-gray-700 mb-1">Short Name</label>
                        <input type="text" id="shortName" name="short_name" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter short name">
                    </div>
                    <div class="flex justify-end space-x-3">
                        <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 border border-gray-300 rounded-lg hover:bg-gray-200 transition-colors">
                            Cancel
                        </button>
                        <button type="submit" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 border border-transparent rounded-lg hover:bg-blue-700 transition-colors">
                            Add Unit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Simple script to handle modal display
        document.addEventListener('DOMContentLoaded', function() {
            const addButton = document.querySelector('button.bg-gradient-to-r');
            const modal = document.getElementById('addUnitModal');

            if (addButton && modal) {
                addButton.addEventListener('click', function() {
                    modal.classList.remove('hidden');
                    setTimeout(() => {
                        modal.querySelector('.transform').classList.remove('scale-95', 'opacity-0');
                    }, 10);
                });

                // Close modal when clicking outside or on cancel
                modal.addEventListener('click', function(e) {
                    if (e.target === modal || e.target.classList.contains('cancel-modal')) {
                        modal.querySelector('.transform').classList.add('scale-95', 'opacity-0');
                        setTimeout(() => {
                            modal.classList.add('hidden');
                        }, 300);
                    }
                });
            }

            // Add fade-in animation to table rows
            const tableRows = document.querySelectorAll('tbody tr');
            tableRows.forEach((row, index) => {
                row.style.animationDelay = `${index * 0.05}s`;
                row.classList.add('fade-in');
            });
        });
    </script>
</body>
</html>
@endsection

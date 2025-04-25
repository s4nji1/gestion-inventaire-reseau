@extends('layouts.app')

@section('content')
<div class="w-full px-4">
    <div class="flex flex-col mb-6">
        <div class="w-full">
            <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
            <p class="mt-1 mb-4 text-gray-600">Welcome to the UM6P Network Inventory System</p>
        </div>
    </div>

    <!-- Horizontal Stats Cards Row -->
    <div class="bg-white rounded-lg shadow mb-6 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 divide-y lg:divide-y-0 lg:divide-x divide-gray-200">
            <!-- Total Equipment Card -->
            <div class="p-6 flex items-center">
                <div class="flex-shrink-0 rounded-full bg-blue-100 p-3 mr-4">
                    <i class="fas fa-desktop text-xl text-blue-600"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-blue-600 uppercase mb-1">Total Equipment</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $equipmentCount ?? 0 }}</div>
                </div>
            </div>

            <!-- Maintenance Count Card -->
            <div class="p-6 flex items-center">
                <div class="flex-shrink-0 rounded-full bg-yellow-100 p-3 mr-4">
                    <i class="fas fa-tools text-xl text-yellow-600"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-yellow-600 uppercase mb-1">In Maintenance</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $maintenanceCount ?? 0 }}</div>
                </div>
            </div>

            <!-- Category Count Card -->
            <div class="p-6 flex items-center">
                <div class="flex-shrink-0 rounded-full bg-green-100 p-3 mr-4">
                    <i class="fas fa-tags text-xl text-green-600"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-green-600 uppercase mb-1">Categories</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $categoryCount ?? 0 }}</div>
                </div>
            </div>

            <!-- Recent Movements Card -->
            <div class="p-6 flex items-center">
                <div class="flex-shrink-0 rounded-full bg-cyan-100 p-3 mr-4">
                    <i class="fas fa-exchange-alt text-xl text-cyan-600"></i>
                </div>
                <div>
                    <div class="text-xs font-bold text-cyan-600 uppercase mb-1">Recent Movements</div>
                    <div class="text-2xl font-bold text-gray-800">{{ $recentMovementsCount ?? 0 }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Charts Row -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Equipment by Status Chart -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <h6 class="font-bold text-blue-600">Equipment by Status</h6>
                <div class="flex space-x-2">
                    <button id="statusChartTypeBar" class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-xs font-medium hover:bg-blue-200">Bar</button>
                    <button id="statusChartTypePie" class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium hover:bg-blue-100">Pie</button>
                </div>
            </div>
            <div class="p-4">
                <div class="w-full h-64">
                    <canvas id="equipmentByStatusChart"></canvas>
                </div>
            </div>
        </div>

        <br>

        <!-- Equipment by Category Pie Chart -->
        <div class="bg-white rounded-lg shadow">
            <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                <h6 class="font-bold text-blue-600">Equipment by Category</h6>
                <div class="flex space-x-2">
                    <button id="categoryChartTypePie" class="px-2 py-1 bg-blue-100 text-blue-600 rounded text-xs font-medium hover:bg-blue-200">Pie</button>
                    <button id="categoryChartTypeBar" class="px-2 py-1 bg-gray-100 text-gray-600 rounded text-xs font-medium hover:bg-blue-100">Bar</button>
                </div>
            </div>
            <div class="p-4">
                <div class="w-full h-64 pt-2">
                    <canvas id="equipmentByCategoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Latest Maintenance Records -->
        <div>
            <div class="bg-white rounded-lg shadow">
                <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                    <h6 class="font-bold text-blue-600">Latest Maintenance Records</h6>
                    <a href="{{ route('maintenance.index') }}" class="text-sm text-blue-600 hover:underline">View All</a>
                </div>
                <div class="p-4 overflow-auto">
                    <div class="overflow-x-auto">
                        <table class="w-full text-center bg-white border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 border-b text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Equipment</th>
                                    <th class="px-4 py-2 border-b text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-4 py-2 border-b text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-4 py-2 border-b text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Start Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($latestMaintenanceRecords ?? [] as $record)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm text-gray-800 text-center">{{ $record->equipment->name }}</td>
                                    <td class="px-4 py-2 text-sm text-gray-800 text-center">{{ $record->maintenance_type }}</td>
                                    <td class="px-4 py-2 text-sm text-center">
                                        @switch($record->status)
                                            @case('pending')
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Pending</span>
                                                @break
                                            @case('in_progress')
                                                <span class="px-2 py-1 text-xs rounded-full bg-blue-100 text-blue-800">In Progress</span>
                                                @break
                                            @case('completed')
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Completed</span>
                                                @break
                                            @case('cancelled')
                                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Cancelled</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-800 text-center">{{ $record->start_date->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500 text-center">No maintenance records found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <br>

        <!-- Latest Equipment Movements -->
        <div>
            <div class="bg-white rounded-lg shadow">
                <div class="px-4 py-3 border-b border-gray-200 flex items-center justify-between">
                    <h6 class="font-bold text-blue-600">Latest Equipment Movements</h6>
                    <a href="{{ route('movement.index') }}" class="text-sm text-blue-600 hover:underline">View All</a>
                </div>
                <div class="p-4 overflow-auto">
                    <div class="overflow-x-auto">
                        <table class="w-full text-center bg-white border border-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 border-b text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Equipment</th>
                                    <th class="px-4 py-2 border-b text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-4 py-2 border-b text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Status Change</th>
                                    <th class="px-4 py-2 border-b text-center text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($latestMovements ?? [] as $movement)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 text-sm text-gray-800 text-center">{{ $movement->equipment->name }}</td>
                                    <td class="px-4 py-2 text-sm text-center">
                                        @switch($movement->type)
                                            @case('entry')
                                                <span class="px-2 py-1 text-xs rounded-full bg-green-100 text-green-800">Entry</span>
                                                @break
                                            @case('exit')
                                                <span class="px-2 py-1 text-xs rounded-full bg-red-100 text-red-800">Exit</span>
                                                @break
                                            @case('maintenance')
                                                <span class="px-2 py-1 text-xs rounded-full bg-yellow-100 text-yellow-800">Maintenance</span>
                                                @break
                                        @endswitch
                                    </td>
                                    <td class="px-4 py-2 text-sm text-center">
                                        @if($movement->from_status_id)
                                            <span class="text-sm font-medium">{{ $movement->fromStatus->name }}</span>
                                        @else
                                            <span class="text-sm text-gray-500">--</span>
                                        @endif
                                        →
                                        <span class="text-sm font-medium">{{ $movement->toStatus->name }}</span>
                                    </td>
                                    <td class="px-4 py-2 text-sm text-gray-800 text-center">{{ $movement->created_at->format('M d, Y') }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-3 text-center text-sm text-gray-500 text-center">No movements found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Make sure Chart.js is loaded
    if (typeof Chart === 'undefined') {
        console.error('Chart.js is not loaded!');
        return;
    }
    
    // Predefined colors that work well with dark text
    const chartColors = [
        '#4361ee', '#3a0ca3', '#4895ef', '#4cc9f0', 
        '#f72585', '#b5179e', '#7209b7', '#560bad',
        '#f94144', '#f3722c', '#f8961e', '#f9c74f',
        '#90be6d', '#43aa8b', '#4d908e', '#577590'
    ];
    
    // Sample data in case API data is missing
    const sampleStatusLabels = ['Active', 'Maintenance', 'In Storage', 'Reserved', 'Decommissioned'];
    const sampleStatusCounts = [15, 5, 3, 2, 1];
    
    const sampleCategoryLabels = ['Switches', 'Routers', 'Access Points', 'Servers', 'Firewalls'];
    const sampleCategoryData = [12, 8, 5, 3, 2];
    
    // Status Chart Data
    let statusLabels = @json($statusLabels ?? []);
    let statusCounts = @json($statusCounts ?? []);
    let statusColors = @json($statusColors ?? []);
    
    // Use sample data if no real data exists
    if (!statusLabels || !statusLabels.length || !statusCounts || !statusCounts.length) {
        statusLabels = sampleStatusLabels;
        statusCounts = sampleStatusCounts;
        statusColors = chartColors.slice(0, statusLabels.length);
    }
    
    // Ensure we have enough colors
    if (!statusColors || statusColors.length < statusLabels.length) {
        statusColors = [];
        for (let i = 0; i < statusLabels.length; i++) {
            statusColors.push(chartColors[i % chartColors.length]);
        }
    }
    
    // Category Chart Data
    let categoryLabels = @json($categoryLabels ?? []);
    let categoryData = @json($categoryData ?? []);
    
    // Use sample data if no real data exists
    if (!categoryLabels || !categoryLabels.length || !categoryData || !categoryData.length) {
        categoryLabels = sampleCategoryLabels;
        categoryData = sampleCategoryData;
    }
    
    // Category chart colors
    let categoryColors = [];
    for (let i = 0; i < categoryLabels.length; i++) {
        categoryColors.push(chartColors[i % chartColors.length]);
    }
    
    // Common chart options
    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    boxWidth: 12,
                    usePointStyle: true,
                }
            },
            tooltip: {
                backgroundColor: 'rgba(255, 255, 255, 0.9)',
                titleColor: '#333',
                bodyColor: '#666',
                borderColor: '#ddd',
                borderWidth: 1,
                padding: 12,
                boxPadding: 3,
                usePointStyle: true,
                callbacks: {
                    label: function(context) {
                        let value = context.raw;
                        return ` ${context.label}: ${value}`;
                    }
                }
            }
        }
    };
    
    // Status Chart
    const statusChartElement = document.getElementById('equipmentByStatusChart');
    let statusChart;
    
    if (statusChartElement) {
        const statusData = {
            labels: statusLabels,
            datasets: [{
                label: 'Equipment Count',
                data: statusCounts,
                backgroundColor: statusColors,
                borderWidth: 0,
                hoverOffset: 4
            }]
        };
        
        const statusOptions = {
            ...commonOptions,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { 
                        precision: 0,
                        color: '#666',
                    },
                    grid: {
                        color: '#e5e7eb',
                        drawBorder: false
                    }
                },
                x: {
                    ticks: {
                        color: '#666',
                    },
                    grid: {
                        display: false
                    }
                }
            }
        };
        
        statusChart = new Chart(statusChartElement, {
            type: 'bar',
            data: statusData,
            options: statusOptions
        });
        
        // Chart type toggle handlers
        document.getElementById('statusChartTypeBar').addEventListener('click', function() {
            statusChart.destroy();
            statusChart = new Chart(statusChartElement, {
                type: 'bar',
                data: statusData,
                options: statusOptions
            });
            this.classList.remove('bg-gray-100', 'text-gray-600');
            this.classList.add('bg-blue-100', 'text-blue-600');
            document.getElementById('statusChartTypePie').classList.remove('bg-blue-100', 'text-blue-600');
            document.getElementById('statusChartTypePie').classList.add('bg-gray-100', 'text-gray-600');
        });
        
        document.getElementById('statusChartTypePie').addEventListener('click', function() {
            statusChart.destroy();
            statusChart = new Chart(statusChartElement, {
                type: 'pie',
                data: statusData,
                options: {
                    ...commonOptions,
                    plugins: {
                        ...commonOptions.plugins,
                        legend: {
                            ...commonOptions.plugins.legend,
                            position: 'right'
                        }
                    }
                }
            });
            this.classList.remove('bg-gray-100', 'text-gray-600');
            this.classList.add('bg-blue-100', 'text-blue-600');
            document.getElementById('statusChartTypeBar').classList.remove('bg-blue-100', 'text-blue-600');
            document.getElementById('statusChartTypeBar').classList.add('bg-gray-100', 'text-gray-600');
        });
    }
    
    // Category Chart
    const categoryChartElement = document.getElementById('equipmentByCategoryChart');
    let categoryChart;
    
    if (categoryChartElement) {
        const categoryChartData = {
            labels: categoryLabels,
            datasets: [{
                label: 'Equipment Count',
                data: categoryData,
                backgroundColor: categoryColors,
                borderWidth: 0,
                hoverOffset: 4
            }]
        };
        
        categoryChart = new Chart(categoryChartElement, {
            type: 'doughnut',
            data: categoryChartData,
            options: {
                ...commonOptions,
                cutout: '40%',
                plugins: {
                    ...commonOptions.plugins,
                    legend: {
                        ...commonOptions.plugins.legend,
                        position: 'right',
                    }
                }
            }
        });
        
        // Chart type toggle handlers
        document.getElementById('categoryChartTypePie').addEventListener('click', function() {
            categoryChart.destroy();
            categoryChart = new Chart(categoryChartElement, {
                type: 'doughnut',
                data: categoryChartData,
                options: {
                    ...commonOptions,
                    cutout: '40%',
                    plugins: {
                        ...commonOptions.plugins,
                        legend: {
                            ...commonOptions.plugins.legend,
                            position: 'right'
                        }
                    }
                }
            });
            this.classList.remove('bg-gray-100', 'text-gray-600');
            this.classList.add('bg-blue-100', 'text-blue-600');
            document.getElementById('categoryChartTypeBar').classList.remove('bg-blue-100', 'text-blue-600');
            document.getElementById('categoryChartTypeBar').classList.add('bg-gray-100', 'text-gray-600');
        });
        
        document.getElementById('categoryChartTypeBar').addEventListener('click', function() {
            categoryChart.destroy();
            categoryChart = new Chart(categoryChartElement, {
                type: 'bar',
                data: categoryChartData,
                options: {
                    ...commonOptions,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { 
                                precision: 0,
                                color: '#666',
                            },
                            grid: {
                                color: '#e5e7eb',
                                drawBorder: false
                            }
                        },
                        x: {
                            ticks: {
                                color: '#666',
                            },
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            });
            this.classList.remove('bg-gray-100', 'text-gray-600');
            this.classList.add('bg-blue-100', 'text-blue-600');
            document.getElementById('categoryChartTypePie').classList.remove('bg-blue-100', 'text-blue-600');
            document.getElementById('categoryChartTypePie').classList.add('bg-gray-100', 'text-gray-600');
        });
    }
});
</script>
@endsection
@yield('scripts')
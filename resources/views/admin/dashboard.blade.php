<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="pt-12 pb-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-6">Login Statistics</h1>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                        {{-- Daily Logins Chart --}}
                        <div class="bg-white p-4 md:p-6 rounded-lg shadow border border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-700 mb-4">Daily Logins (Last 7 Days)</h2>
                            <div class="h-64 md:h-80">
                                <canvas id="dailyLoginsChart"></canvas>
                            </div>
                        </div>

                        {{-- Monthly Logins Chart --}}
                        <div class="bg-white p-4 md:p-6 rounded-lg shadow border border-gray-200">
                            <h2 class="text-lg font-semibold text-gray-700 mb-4">Monthly Logins (Last 12 Months)</h2>
                            <div class="h-64 md:h-80">
                                <canvas id="monthlyLoginsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="pt-6 pb-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-800 mb-6">User List</h1>

                    <div class="overflow-x-auto shadow-md rounded-lg border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 bg-white">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        ID
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Name
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Email
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Register Date
                                    </th>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Snapshots Count
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse ($users as $user)
                                    <tr class="hover:bg-gray-100 transition-colors duration-150">
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                            {{ $user->id }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $user->name }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $user->email }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                                            {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700 text-center">
                                            {{ $user->snapshots_count ?? 0 }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5"
                                            class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No users found.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    @if ($users->hasPages())
                        <div class="mt-8">
                            {{ $users->links() }}
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Data from the controller
            const dailyLoginStats = @json($dailyLoginStats ?? ['labels' => [], 'data' => []]);
            const monthlyLoginStats = @json($monthlyLoginStats ?? ['labels' => [], 'data' => []]);

            console.log('Daily Login Stats:', dailyLoginStats);
            console.log('Monthly Login Stats:', monthlyLoginStats);

            // Daily Logins Chart
            const dailyCtx = document.getElementById('dailyLoginsChart');
            if (dailyCtx && dailyLoginStats.labels.length > 0) {
                new Chart(dailyCtx, {
                    type: 'bar',
                    data: {
                        labels: dailyLoginStats.labels,
                        datasets: [{
                            label: 'Logins',
                            data: dailyLoginStats.data,
                            backgroundColor: 'rgba(59, 130, 246, 0.5)',
                            borderColor: 'rgba(59, 130, 246, 1)',
                            borderWidth: 1,
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                },
                                grid: {
                                    color: 'rgba(209, 213, 219, 0.4)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(31, 41, 55, 0.9)',
                                titleFont: {
                                    size: 14
                                },
                                bodyFont: {
                                    size: 12
                                },
                                padding: 10,
                                cornerRadius: 4
                            }
                        }
                    }
                });
            }

            // Monthly Logins Chart
            const monthlyCtx = document.getElementById('monthlyLoginsChart');
            if (monthlyCtx && monthlyLoginStats.labels.length > 0) {
                new Chart(monthlyCtx, {
                    type: 'bar',
                    data: {
                        labels: monthlyLoginStats.labels,
                        datasets: [{
                            label: 'Logins',
                            data: monthlyLoginStats.data,
                            backgroundColor: 'rgba(16, 185, 129, 0.5)',
                            borderColor: 'rgba(16, 185, 129, 1)',
                            borderWidth: 1,
                            borderRadius: 4,
                            barPercentage: 0.6,
                            categoryPercentage: 0.7
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    precision: 0
                                },
                                grid: {
                                    color: 'rgba(209, 213, 219, 0.4)'
                                }
                            },
                            x: {
                                grid: {
                                    display: false
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                display: false
                            },
                            tooltip: {
                                backgroundColor: 'rgba(31, 41, 55, 0.9)',
                                titleFont: {
                                    size: 14
                                },
                                bodyFont: {
                                    size: 12
                                },
                                padding: 10,
                                cornerRadius: 4
                            }
                        }
                    }
                });
            }
        });
    </script>

</x-admin-layout>

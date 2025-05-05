<x-layouts.app title="Dashboard">
    <div class="container mt-5">
        <!-- Statistics Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Approved Applications Card -->
            <div class="rounded-lg border border-neutral-200 bg-green-500 p-4 flex flex-col items-center justify-center shadow-md hover:bg-green-600 transition duration-300 transform hover:scale-105">
                <h2 class="text-2xl font-semibold text-white">{{ \App\Models\Application::whereStatus('approved')->count() }}</h2>
                <p class="text-white text-sm mt-1">Approved Applications</p>
                <svg class="text-white w-5 h-5 mt-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <!-- Pending Applications Card -->
            <div class="rounded-lg border border-neutral-200 bg-blue-500 p-4 flex flex-col items-center justify-center shadow-md hover:bg-blue-600 transition duration-300 transform hover:scale-105">
                <h2 class="text-2xl font-semibold text-white">{{ \App\Models\Application::whereStatus('pending')->count() }}</h2>
                <p class="text-white text-sm mt-1">Pending Applications</p>
                <svg class="text-white w-5 h-5 mt-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v18h14V3H5z" />
                </svg>
            </div>

            <!-- Declined Applications Card -->
            <div class="rounded-lg border border-neutral-200 bg-red-500 p-4 flex flex-col items-center justify-center shadow-md hover:bg-red-600 transition duration-300 transform hover:scale-105">
                <h2 class="text-2xl font-semibold text-white">{{ \App\Models\Application::whereStatus('declined')->count() }}</h2>
                <p class="text-white text-sm mt-1">Declined Applications</p>
                <svg class="text-white w-5 h-5 mt-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </div>
        </div>

        <!-- Active Users and Chart Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">
            <!-- Active Users Section -->
            <div class="bg-white rounded-xl border p-6 shadow-lg">
                <h3 class="text-xl font-bold text-gray-800 text-center mb-6">Active Users</h3>
                <div class="space-y-4">
                    @foreach ([
                        ['name' => 'John Doe', 'status' => 'active', 'avatar' => 'https://i.pravatar.cc/40?img=1'],
                        ['name' => 'Jane Smith', 'status' => 'active', 'avatar' => 'https://i.pravatar.cc/40?img=2'],
                        ['name' => 'Emily Williams', 'status' => 'inactive', 'avatar' => 'https://i.pravatar.cc/40?img=3'],
                        ['name' => 'Michael Brown', 'status' => 'active', 'avatar' => 'https://i.pravatar.cc/40?img=4'],
                    ] as $user)
                        <div class="flex items-center gap-3 border-b pb-3">
                            <div class="w-10 h-10">
                                <img class="rounded-full w-full h-full object-cover ring-2 ring-white shadow" src="{{ $user['avatar'] }}" alt="{{ $user['name'] }}">
                            </div>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-800">{{ $user['name'] }}</p>
                                <div class="flex items-center space-x-2">
                                    <span class="inline-block w-3 h-3 rounded-full {{ $user['status'] === 'active' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                    <span class="text-xs text-gray-600 capitalize">{{ $user['status'] }}</span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Chart Section -->
            <div class="border border-neutral-300 rounded-lg p-4 shadow-lg">
                <div class="flex justify-end space-x-2 mb-3">
                    <button onclick="filterChart('high')" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded-md text-sm">High Collection</button>
                    <button onclick="filterChart('medium')" class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded-md text-sm">Moderate Collection</button>
                    <button onclick="filterChart('overall')" class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md text-sm">Overall Collection</button>
                </div>
                <div id="chart"></div>
            </div>
        </div>
    </div>

    <!-- Include ApexCharts Library -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        const allData = {
            high: {
                labels: ['Irosin', 'Bulusan', 'Bulan'],
                approved: [700, 650, 800],  // **High values for high collection**
                users: [150, 180, 170]
            },
            medium: {
                labels: ['Magallanes', 'Matnog', 'Juban'],
                approved: [120, 130, 140],  // **Lower values for moderate collection**
                users: [45, 50, 55]
            },
            overall: {
                labels: ['Irosin', 'Magallanes', 'Bulusan', 'Matnog', 'Bulan', 'Juban'],
                approved: [700, 120, 650, 130, 800, 140],  // **Combine both high and moderate**
                users: [150, 45, 180, 50, 170, 55]
            }
        };

        let chart;

        function renderChart(data) {
            const options = {
                series: [
                    {
                        name: 'Approved',
                        type: 'column',
                        data: data.approved
                    },
                    {
                        name: 'Active Users',
                        type: 'line',
                        data: data.users
                    }
                ],
                chart: {
                    height: 350,
                    type: 'line',
                    stacked: false,
                },
                stroke: {
                    width: [0, 3],
                    curve: 'smooth'
                },
                plotOptions: {
                    bar: {
                        columnWidth: '50%'
                    }
                },
                fill: {
                    opacity: [0.85, 0.75]
                },
                labels: data.labels,
                xaxis: {
                    categories: data.labels
                },
                yaxis: {
                    title: {
                        text: 'Collection / Users'
                    }
                },
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function (y) {
                            return typeof y !== "undefined" ? y.toFixed(0) : y;
                        }
                    }
                }
            };

            if (chart) {
                chart.updateOptions(options);
            } else {
                chart = new ApexCharts(document.querySelector("#chart"), options);
                chart.render();
            }
        }

        function filterChart(level) {
            if (level === 'high') {
                renderChart(allData.high);  // Show high collection
            } else if (level === 'medium') {
                renderChart(allData.medium);  // Show moderate collection
            } else if (level === 'overall') {
                renderChart(allData.overall);  // Show overall collection (high + moderate)
            }
        }

        // Initial chart render
        renderChart(allData.high);  // Default to high collection
    </script>
</x-layouts.app>

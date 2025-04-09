<x-layouts.app title="Dashboard">
    <div class="container mt-5">
        <!-- Statistics Cards Section -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Approved Applications Card -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-green-500 p-6 flex flex-col items-center justify-center dark:border-neutral-700 hover:bg-green-600 transition duration-300 ease-in-out shadow-lg">
                <h2 class="text-3xl font-semibold text-white">{{ \App\Models\Application::whereStatus('approved')->count() }}</h2>
                <p class="text-white">Total Approved Applications</p>
            </div>

            <!-- Pending Applications Card -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-blue-500 p-6 flex flex-col items-center justify-center dark:border-neutral-700 hover:bg-blue-600 transition duration-300 ease-in-out shadow-lg">
                <h2 class="text-3xl font-semibold text-white">{{ \App\Models\Application::whereStatus('pending')->count() }}</h2>
                <p class="text-white">Pending Applications</p>
            </div>

            <!-- Declined Applications Card -->
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-red-500 p-6 flex flex-col items-center justify-center dark:border-neutral-700 hover:bg-red-600 transition duration-300 ease-in-out shadow-lg">
                <h2 class="text-3xl font-semibold text-white">{{ \App\Models\Application::whereStatus('declined')->count() }}</h2>
                <p class="text-white">Declined Applications</p>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-5">
            <!-- Chart for Approved Applications -->
            <div class="box">
                <div id="approved-chart"></div>
            </div>

            <!-- Chart for Pending Applications -->
            <div class="box">
                <!-- Wrapping chart in a border box with padding and shadow -->
                <div class="border border-neutral-300 rounded-lg p-4 shadow-lg">
                    <div id="chart"></div> <!-- This is the chart container -->
                </div>
            </div>
        </div>
    </div>

    <!-- Include ApexCharts Library -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        // New chart options as per your provided configuration
        var options = {
            series: [{
                name: 'TEAM A',
                type: 'column',
                data: [23, 11, 22, 27, 13, 22, 37, 21, 44, 22, 30]
            }, {
                name: 'TEAM B',
                type: 'area',
                data: [44, 55, 41, 67, 22, 43, 21, 41, 56, 27, 43]
            }, {
                name: 'TEAM C',
                type: 'line',
                data: [30, 25, 36, 30, 45, 35, 64, 52, 59, 36, 39]
            }],
            chart: {
                height: 350,
                type: 'line',
                stacked: false,
            },
            stroke: {
                width: [0, 2, 5],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '50%'
                }
            },
            fill: {
                opacity: [0.85, 0.25, 1],
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100, 100, 100]
                }
            },
            labels: ['01/01/2003', '02/01/2003', '03/01/2003', '04/01/2003', '05/01/2003', '06/01/2003', '07/01/2003', '08/01/2003', '09/01/2003', '10/01/2003', '11/01/2003'],
            markers: {
                size: 0
            },
            xaxis: {
                type: 'datetime'
            },
            yaxis: {
                title: {
                    text: 'Points',
                }
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0) + " points";
                        }
                        return y;
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();
    </script>
</x-layouts.app>





<!--  <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <!-- Approved Applications Card 
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-green-500 p-6 flex flex-col items-center justify-center dark:border-neutral-700 hover:bg-green-600 transition duration-300 ease-in-out shadow-lg">
                <h2 class="text-3xl font-semibold text-white">{{ \App\Models\Application::whereStatus('approved')->count() }}</h2>
                <p class="text-white">Total Approved Applications</p>
            </div>

            <!-- Pending Applications Card 
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-blue-500 p-6 flex flex-col items-center justify-center dark:border-neutral-700 hover:bg-blue-600 transition duration-300 ease-in-out shadow-lg">
                <h2 class="text-3xl font-semibold text-white">{{ \App\Models\Application::whereStatus('pending')->count() }}</h2>
                <p class="text-white">Pending Applications</p>
            </div>

            <!-- Declined Applications Card 
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 bg-red-500 p-6 flex flex-col items-center justify-center dark:border-neutral-700 hover:bg-red-600 transition duration-300 ease-in-out shadow-lg">
                <h2 class="text-3xl font-semibold text-white">{{ \App\Models\Application::whereStatus('declined')->count() }}</h2>
                <p class="text-white">Declined Applications</p>
            </div>
        </div>
    </div> -->

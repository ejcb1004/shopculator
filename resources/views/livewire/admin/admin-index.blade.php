<div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div x-data="tabs" class="pt-8">
            <div class="grid grid-cols-2 cursor-pointer font-bold">
                <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(1) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(1)">Registered shoppers over time</div>
                <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(2) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(2)">Registered markets over time</div>
            </div>
            <div class="min-w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-b-lg">
                <div x-show="isActive(1)" x-transition:enter.duration.500ms>
                    <canvas id="chart1"></canvas>
                </div>
                <div x-show="isActive(2)" x-transition:enter.duration.500ms>
                    <canvas id="chart2"></canvas>
                </div>
            </div>
        </div>
    </div>
    <script>
        function tabs() {
            return {
                active: 1,
                isActive(tab) {
                    return tab == this.active;
                },
                setActive(value) {
                    this.active = value;
                }
            }
        }

        var chartdata1 = {
            type: 'line',
            data: {
                labels: <?php echo json_encode($shoppers['periods']); ?>,
                datasets: [{
                    label: '# of shoppers',
                    backgroundColor: '#a7f3d0',
                    borderColor: "#10b981",
                    data: <?php echo json_encode($shoppers['data']); ?>
                }]
            },
            options: {
                scales: {
                    y: {
                        suggestedMin: 0,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        }
        var ctx = document.getElementById('chart1').getContext('2d');
        new Chart(ctx, chartdata1);

        var chartdata2 = {
            type: 'line',
            data: {
                labels: <?php echo json_encode($markets['periods']); ?>,
                datasets: [{
                    label: '# of markets',
                    backgroundColor: '#a7f3d0',
                    borderColor: "#10b981",
                    data: <?php echo json_encode($markets['data']); ?>
                }]
            },
            options: {
                scales: {
                    y: {
                        suggestedMin: 0,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        }
        var ctx = document.getElementById('chart2').getContext('2d');
        new Chart(ctx, chartdata2);
    </script>
</div>
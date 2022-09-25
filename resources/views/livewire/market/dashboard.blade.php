<div>
    @if (!empty($labels) && !empty($data))
    <div class="max-w-7xl mx-auto px-3 pb-4 sm:px-6 lg:px-8">
        <div x-data="tabs" class="pt-8">
            <div class="grid grid-cols-3 cursor-pointer font-bold">
                <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(1) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(1)">Most trending</div>
                <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(2) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(2)">Most trending (Top 10)</div>
                <div class="border-r border-gray-100 rounded-t-lg px-4 py-1 text-center" :class="isActive(3) ? 'bg-white text-emerald-600': 'bg-emerald-600 text-white'" @click="setActive(3)">Least trending</div>
            </div>
            <div class="min-w-full sm:max-w-md px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-b-lg">
                <div x-show="isActive(1)" x-transition:enter.duration.500ms>
                    <canvas id="chart1"></canvas>
                </div>
                <div x-show="isActive(2)" x-transition:enter.duration.500ms>
                    <canvas id="chart2"></canvas>
                </div>
                <div x-show="isActive(3)" x-transition:enter.duration.500ms>
                    <canvas id="chart3"></canvas>
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
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels[0]); ?>,
                datasets: [{
                    label: 'Total transactions',
                    backgroundColor: [
                        "#25CCF7", "#FD7272", "#54a0ff", "#00d2d3",
                        "#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e",
                        "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
                        "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6",
                        "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d",
                        "#55efc4", "#81ecec", "#74b9ff", "#a29bfe", "#dfe6e9",
                        "#00b894", "#00cec9", "#0984e3", "#6c5ce7", "#ffeaa7",
                        "#fab1a0", "#ff7675", "#fd79a8", "#fdcb6e", "#e17055",
                        "#d63031", "#feca57", "#5f27cd", "#54a0ff", "#01a3a4"
                    ],
                    borderWidth: 1,
                    data: <?php echo json_encode($data[0]); ?>,
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
                },
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            // This more specific font property overrides the global property
                            font: {
                                size: 13
                            }
                        }
                    }
                }
            }
        }
        var ctx = document.getElementById('chart1').getContext('2d');
        new Chart(ctx, chartdata1);

        var chartdata2 = {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels[1]); ?>,
                datasets: [{
                    label: 'Total transactions',
                    backgroundColor: [
                        "#25CCF7", "#FD7272", "#54a0ff", "#00d2d3",
                        "#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e",
                        "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
                        "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6",
                        "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d",
                        "#55efc4", "#81ecec", "#74b9ff", "#a29bfe", "#dfe6e9",
                        "#00b894", "#00cec9", "#0984e3", "#6c5ce7", "#ffeaa7",
                        "#fab1a0", "#ff7675", "#fd79a8", "#fdcb6e", "#e17055",
                        "#d63031", "#feca57", "#5f27cd", "#54a0ff", "#01a3a4"
                    ],
                    borderWidth: 1,
                    data: <?php echo json_encode($data[1]); ?>,
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
                },
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            // This more specific font property overrides the global property
                            font: {
                                size: 13
                            }
                        }
                    }
                }
            }
        }
        var ctx = document.getElementById('chart2').getContext('2d');
        new Chart(ctx, chartdata2);

        var chartdata3 = {
            type: 'bar',
            data: {
                labels: <?php echo json_encode($labels[2]); ?>,
                datasets: [{
                    label: 'Total transactions',
                    backgroundColor: [
                        "#25CCF7", "#FD7272", "#54a0ff", "#00d2d3",
                        "#1abc9c", "#2ecc71", "#3498db", "#9b59b6", "#34495e",
                        "#16a085", "#27ae60", "#2980b9", "#8e44ad", "#2c3e50",
                        "#f1c40f", "#e67e22", "#e74c3c", "#ecf0f1", "#95a5a6",
                        "#f39c12", "#d35400", "#c0392b", "#bdc3c7", "#7f8c8d",
                        "#55efc4", "#81ecec", "#74b9ff", "#a29bfe", "#dfe6e9",
                        "#00b894", "#00cec9", "#0984e3", "#6c5ce7", "#ffeaa7",
                        "#fab1a0", "#ff7675", "#fd79a8", "#fdcb6e", "#e17055",
                        "#d63031", "#feca57", "#5f27cd", "#54a0ff", "#01a3a4"
                    ],
                    borderWidth: 1,
                    data: <?php echo json_encode($data[2]); ?>,
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
                },
                plugins: {
                    legend: {
                        position: 'right',
                        labels: {
                            // This more specific font property overrides the global property
                            font: {
                                size: 13
                            }
                        }
                    }
                }
            }
        }
        var ctx = document.getElementById('chart3').getContext('2d');
        new Chart(ctx, chartdata3);
    </script>
    @endif
</div>
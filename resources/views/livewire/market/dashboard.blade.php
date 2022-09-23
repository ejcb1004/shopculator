<div>
    <div class="max-w-7xl mx-auto px-3 pb-4 sm:px-6 lg:px-8">
        <div class="mt-4 mx-auto h-3/5 w-3/5">
            <canvas id="chart"></canvas>
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
        var chartdata = {
            type: 'doughnut',
            data: {
                labels: <?php echo json_encode($labels); ?>,
                datasets: [{
                    label: 'Trending products',
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
                    data: <?php echo json_encode($data); ?>,
                    position: 'bottom'
                }]
            },
            options: {
                plugins: {
                    legend: {
                        labels: {
                            // This more specific font property overrides the global property
                            font: {
                                size: 14
                            }
                        }
                    }
                }
            }
        }
        var ctx = document.getElementById('chart').getContext('2d');
        new Chart(ctx, chartdata);
    </script>
</div>
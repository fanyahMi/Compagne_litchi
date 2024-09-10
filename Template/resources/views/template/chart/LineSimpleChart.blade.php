<div class="masonry-item col-12">
    <!-- #Site Visits ==================== -->
        <div class="bd bgc-white">
        <div class="peers fxw-nw@lg+ ai-s">
            <div class="peer peer-greed w-70p@lg+ w-100@lg- p-20"@style("margin-left: 16%;")>
            <div class="layers">
                <div class="layer w-100 mB-10">
                <h6 class="lh-1">LineChart</h6>
                </div>
                <div class="layer w-100">
                    <canvas id="lineChart" height="220"></canvas>
                </div>
            </div>
            </div>
            <div class="peer bdL p-20 w-30p@lg+ w-100p@lg-">

            </div>
        </div>
    </div>

</div>

<script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('/chart-lineSimpleChartData') }}",
            type: "GET",
            success: function(data) {
                var lineCtx = document.getElementById('lineChart').getContext('2d');
                var lineChart = new Chart(lineCtx, {
                    type: 'line',
                    data: {
                        labels: data.labels,
                        datasets: [{
                            label: 'Ventes par mois',
                            data: data.data,
                            fill: false,
                            borderColor: data.borderColor,
                            borderWidth: 1
                        }]
                    },
                    options: {
                        scales: {
                            yAxes: [{
                                ticks: {
                                    beginAtZero: true
                                }
                            }]
                        }
                    }
                });
            }
        });
    });
</script>

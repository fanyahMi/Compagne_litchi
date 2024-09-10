<div class="masonry-item col-12">
    <!-- #Site Visits ==================== -->
        <div class="bd bgc-white">
        <div class="peers fxw-nw@lg+ ai-s">
            <div class="peer peer-greed w-70p@lg+ w-100@lg- p-20" @style("margin-left: 16%;")>
            <div class="layers">
                <div class="layer w-100 mB-10">
                <h6 class="lh-1">LineChart 2</h6>
                </div>
                <div class="layer w-100">
                    <canvas id="lineChart2" height="220"></canvas>
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
                url: "{{ url('/chart-linePlusData') }}",
                type: "GET",
                success: function(data) {
                    var lineCtx2 = document.getElementById('lineChart2').getContext('2d');
                    var lineChart2 = new Chart(lineCtx2, {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: data.datasets,
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


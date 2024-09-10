<div class="masonry-item col-12">
    <!-- #Site Visits ==================== -->
    <div class="bd bgc-white">
      <div class="peers fxw-nw@lg+ ai-s">
        <div class="peer peer-greed w-70p@lg+ w-100@lg- p-20">
          <div class="layers">
            <div class="layer w-100 mB-10">
              <h6 class="lh-1">Batton</h6>
            </div>
            <div class="layer w-100">
                <canvas id="barChart" height="220"></canvas>
            </div>
          </div>
        </div>
        <div class="peer bdL p-20 w-30p@lg+ w-100p@lg-">
          <div class="layers">
            <div class="layer w-100">

              @include('template.chart.DonuntChart')

              <hr> <br>

              @include('template.chart.SecteurChart')


            </div>
          </div>
        </div>
      </div>
    </div>

 </div>
 <script>
    $(document).ready(function() {
        $.ajax({
            url: "{{ url('/chart-barChartData') }}",
            type: "GET",
            success: function(data) {
                console.log(data);
                var barCtx = document.getElementById('barChart').getContext('2d');
                var barChart = new Chart(barCtx, {
                    type: 'bar',
                    data: {
                        labels: data.labels,
                        datasets: data.datasets.map(function(dataset) {
                            return {
                                label: dataset.label,
                                data: dataset.data,
                                backgroundColor: dataset.backgroundColor,
                                borderColor: dataset.borderColor,
                                borderWidth: 1
                            };
                        })
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

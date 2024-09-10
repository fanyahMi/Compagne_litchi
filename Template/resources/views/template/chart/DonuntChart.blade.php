<div class="layers">
    <div class="layer w-100 mB-10">
        <h6 class="lh-1">DonuntChart</h6>
    </div>
    <div class="layer w-100">
        <canvas id="donutChart" height="220"></canvas>
    </div>
</div>

<script>
    $.ajax({
        url: "{{ url('/chart-donutData') }}",
        type: "GET",
        success: function(response) {
            var donutCtx = document.getElementById('donutChart').getContext('2d');
            var donutChart = new Chart(donutCtx, {
                type: 'doughnut',
                data: {
                    labels: response.labels,
                    datasets: [{
                        data: response.data,
                        backgroundColor: response.backgroundColors,
                        borderColor: response.borderColors,
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false
                }
            });
        }
    });
</script>

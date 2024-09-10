<div class="layers">
    <div class="layer w-100 mB-10">
        <h6 class="lh-1">SecteurChart</h6>
    </div>
    <div class="layer w-100">
        <canvas id="pieChart1" height="220"></canvas>
    </div>
</div>

<script>
    $.ajax({
        url: "{{ url('/chart-secteureData') }}",
        type: "GET",
        success: function(response) {
            var donutCtx = document.getElementById('pieChart1').getContext('2d');
            var donutChart = new Chart(donutCtx, {
                type: 'pie',
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

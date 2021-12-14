<script>
    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, { 
            type: 'bar',
            data: {
                labels: ['Feb 2020', 'Mar 2020', 'Abr 2020', 'May 2020'],
                datasets: [{
                    label: 'Nuevos usuarios',
                    data: [50, 100, 150, 200],
                    backgroundColor: [
                        '#12C9E5',  
                        '#12C9E5',
                        '#12C9E5',
                        '#111B54'
                    ],
                    maxBarThickness: 30,
                    maxBarLength: 2
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
</script>
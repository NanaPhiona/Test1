<div class="container card pt-5 mb-5" id="chart-description">
    <div class="row" id="chart-content">
        <div class="col-12" id="heading">
            <h5 class="text-center">PWDs Education Status by Gender</h5>
        </div>
    </div>
    <div class="chart-container">
        <canvas id="educationGenderData"></canvas>
    </div>
</div>

<script>
    var educationData = @json($educationData);
    var gender = @json($gender).filter(label => label !== null && label !== 'N/A');
    var educationLevels = @json($educationLevels).filter(educ_levels => educ_levels != 'Unknown');

    var data = {
        labels: educationLevels,
        datasets: gender.map(g => ({
            label: g,
            backgroundColor: g === 'Male' ? 'skyblue' : 'green',
            data: educationLevels.map(level => {
                const found = educationData.find(d => d.education_level === level && d
                    .sex ===
                    g);
                return found ? found.count : 0;
            })
        }))
    };

    var configs = {
        type: 'bar',
        data: data,
        options: {
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true
                },
                x: {
                    ticks: {
                        autoSkip: false,
                        maxRotation: 45,
                        minRotation: 40
                    }
                }
            },
            plugins: {
                legend: {
                    display: true
                }
            }
        }
    };

    new Chart(document.getElementById("educationGenderData"), configs);
</script>

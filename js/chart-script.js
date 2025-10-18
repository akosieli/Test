document.addEventListener("DOMContentLoaded", async () => {
    const ctx = document.getElementById("moodChart").getContext("2d");

    try {
        // Fetch data from PHP
        const response = await fetch("../Components/mood_chart.php");
        const data = await response.json();

        if (!Array.isArray(data)) {
            console.error("Invalid data:", data);
            return;
        }

        // Extract info
        const dates = data.map(item => item.mood_date);
        const moodValues = data.map(item => item.mood_value);
        const moods = data.map(item => item.mood);

        // Create chart
        new Chart(ctx, {
            type: 'line', // or 'bar'
            data: {
                labels: dates,
                datasets: [{
                    label: 'Mood Intensity (1–10)',
                    data: moodValues,
                    backgroundColor: 'rgba(1, 136, 223, 0.6)',
                    borderColor: '#444d53',
                    borderWidth: 2,
                    tension: 0.3,
                    fill: true,
                    pointRadius: 5,
                    pointHoverRadius: 7
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 10,
                        title: {   
                            display: true, 
                            text: 'Mood Intensity',
                            color: '#0188df',
                            font: {
                                size: 20,
                                family: 'Titan One',
                                weight: 'lighter'
                            },
                        }
                    },
                    x: {
                        title: { 
                            display: true,
                            text: 'Date',
                            color: '#0188df',
                            font: {
                                size: 20,
                                family: 'Titan One',
                                weight: 'lighter'
                            }, 
                        }
                    }
                },
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: (ctx) => moods[ctx.dataIndex] + " (" + ctx.formattedValue + ")"
                        }
                    },
                    title: {
                        display: true,
                        text: 'Daily Mood Tracker',
                        color: '#0188df',
                        font: {
                            size: 20,
                            family: 'Titan One',
                            weight: 'lighter'
                        },
                    }
                }
            }
        });
    } catch (error) {
        console.error("Error loading mood data:", error);
    }
});

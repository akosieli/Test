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
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    borderColor: 'rgba(75, 192, 192, 1)',
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
                        title: { display: true, text: 'Mood Intensity' }
                    },
                    x: {
                        title: { display: true, text: 'Date' }
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
                        text: 'Daily Mood Tracker'
                    }
                }
            }
        });
    } catch (error) {
        console.error("Error loading mood data:", error);
    }
});

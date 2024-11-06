// Water Usage Chart (No changes)
const ctx = document.getElementById('water-usage-chart').getContext('2d');
const waterUsageChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
            label: 'Water Consumption (litres)',
            data: [120, 150, 180, 130, 140, 170, 160, 150, 140, 130, 120, 110],
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2,
            fill: false
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

// Live Consumption Gauge (No changes)
var liveGauge = new JustGage({
    id: "live-consumption-gauge",
    value: 0,
    min: 0,
    max: 200,
    title: "Gallons",
    label: "Water Consumption",
    gaugeWidthScale: 0.6,
    counter: true,
    pointer: true,
    levelColors: ["#a9d70b", "#f9c802", "#ff0000"]
});

// Function to generate random values
function getRandomValue(min, max) {
    return Math.floor(Math.random() * (max - min) + min);
}

// Function to update all consumption values
function updateRandomConsumptionValues() {
    // Generate random values for each consumption type
    var newLiveConsumption = getRandomValue(0, 200); // Live Consumption
    var newMonthlyConsumption = getRandomValue(1000, 5000); // Monthly Consumption
    var newAverageConsumption = getRandomValue(30, 150); // Average Daily Consumption
    var newYearlyConsumption = getRandomValue(12000, 60000); // Yearly Consumption

    // Debug: Log the values being generated
    console.log("Generated Values:");
    console.log("Live Consumption: " + newLiveConsumption);
    console.log("Monthly Consumption: " + newMonthlyConsumption);
    console.log("Average Consumption: " + newAverageConsumption);
    console.log("Yearly Consumption: " + newYearlyConsumption);

    // Update live gauge
    liveGauge.refresh(newLiveConsumption);

    // Update the other values on the page
    document.getElementById('monthly-consumption').innerText = `${newMonthlyConsumption} litres`;
    document.getElementById('average-consumption').innerText = `${newAverageConsumption} litres/day`;
    document.getElementById('yearly-consumption').innerText = `${newYearlyConsumption} litres`;

    // Send the values to the backend via AJAX to update in the database
    const xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_consumption.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            console.log('Consumption data updated successfully.');
        } else {
            console.error('Error updating consumption data:', xhr.statusText);
        }
    };

    // Send the consumption data to the server
    xhr.send(
        `live_consumption=${newLiveConsumption}&monthly_consumption=${newMonthlyConsumption}&average_consumption=${newAverageConsumption}&yearly_consumption=${newYearlyConsumption}`
    );
}

// Update consumption values every 5 seconds for all values
setInterval(updateRandomConsumptionValues, 5000);

// Function to animate numbers
function animateNumber(element) {
    const target = +element.getAttribute('data-target');
    const updateCount = () => {
        const current = +element.innerText;
        const increment = target / 200;

        if (current < target) {
            element.innerText = Math.ceil(current + increment);
            setTimeout(updateCount, 10);
        } else {
            element.innerText = target;
        }
    };

    updateCount();
}

// Function to animate impact stats on scroll
function animateImpactStats() {
    const stats = document.querySelectorAll('.stat-item');
    const triggerBottom = window.innerHeight * 0.8;

    stats.forEach(stat => {
        const statTop = stat.getBoundingClientRect().top;

        if (statTop < triggerBottom) {
            stat.classList.add('active');
            animateNumber(stat.querySelector('h3 span'));
        }
    });
}

// Trigger impact stats animation on scroll
window.addEventListener('scroll', animateImpactStats);

// Ensure impact stats get animated when DOM content is fully loaded
document.addEventListener('DOMContentLoaded', function() {
    const loginForm = document.getElementById('login-form');
    const dashboard = document.querySelector('.dashboard');
    const greeting = document.createElement('div');
    greeting.id = 'greeting';

    if (loginForm) {
        loginForm.addEventListener('submit', function(event) {
            event.preventDefault();
            const username = document.getElementById('username').value;
            greeting.innerText = `Hello, ${username}`;
            dashboard.insertBefore(greeting, dashboard.firstChild);
            loginForm.style.display = 'none';
        });
    }
});

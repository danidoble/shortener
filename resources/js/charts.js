import {Chart} from "chart.js/auto";
function donutRefererChart(labels, data = []) {
    console.log(labels,data)
    const ctx = document.getElementById('refererChart');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                hoverOffset: 4
            }]
        },
        labels: {
            display: false,
        },
    });
}

window.donutRefererChart = donutRefererChart;

$('.overview-year').on('change', function () {
    let year = $(this).val();
    visitorOverview(year);
    //updateUserOverviewChart(year)
})

$(document).ready(function() {
    getYearlyStatistics();
    //updateUserOverviewChart();
})

let userOverView = false;

// Function to update the User Overview chart
function updateUserOverviewChart(year = new Date().getFullYear()) {
    if (userOverView) {
        userOverView.destroy();
    }
    Chart.defaults.elements.arc.roundedCornersFor = {
        "start": 0,
        "end": 0
    };
    Chart.defaults.datasets.doughnut.cutout = '65%';
    let url = $('#get-user-overview').val();
    $.ajax({
        url: url += '?year=' + year,
        type: 'GET',
        dataType: 'json',
        success: function (data) {
            let totalFreeUsers = data.free_user;
            let totalSubscription = data.subscription;
            let inMonths = $("#ShareProfit");
            userOverView = new Chart(inMonths, {
                type: 'doughnut',
                data: {
                    labels: ["Free Users: " + totalFreeUsers, "Subscribed Users: " + totalSubscription],
                    datasets: [{
                        label: "Total Users",
                        borderWidth: 0,
                        data: [totalFreeUsers, totalSubscription],
                        backgroundColor: [
                            "#2CE78D",
                            "#F87C15",
                        ],
                        borderColor: [
                            "#2CE78D",
                            "#2CE78D",
                        ],
                    }]
                },
                plugins: [{
                    afterUpdate: function (chart) {
                        if (chart.options.elements.arc.roundedCornersFor !== undefined) {
                            var arcValues = Object.values(chart.options.elements.arc.roundedCornersFor);

                            arcValues.forEach(function (arcs) {
                                arcs = Array.isArray(arcs) ? arcs : [arcs];
                                arcs.forEach(function (i) {
                                    var arc = chart.getDatasetMeta(0).data[i];
                                    arc.round = {
                                        x: (chart.chartArea.left + chart.chartArea
                                            .right) / 2,
                                        y: (chart.chartArea.top + chart.chartArea
                                            .bottom) / 2,
                                        radius: (arc.outerRadius + arc
                                            .innerRadius) / 2,
                                        thickness: (arc.outerRadius - arc
                                            .innerRadius) / 2,
                                        backgroundColor: arc.options.backgroundColor
                                    }
                                });
                            });
                        }
                    },
                    afterDraw: (chart) => {

                        if (chart.options.elements.arc.roundedCornersFor !== undefined) {
                            var {
                                ctx,
                                canvas
                            } = chart;
                            var arc,
                                roundedCornersFor = chart.options.elements.arc.roundedCornersFor;
                            for (var position in roundedCornersFor) {
                                var values = Array.isArray(roundedCornersFor[position]) ?
                                    roundedCornersFor[position] : [roundedCornersFor[position]];
                                values.forEach(p => {
                                    arc = chart.getDatasetMeta(0).data[p];
                                    var startAngle = Math.PI / 2 - arc.startAngle;
                                    var endAngle = Math.PI / 2 - arc.endAngle;
                                    ctx.save();
                                    ctx.translate(arc.round.x, arc.round.y);
                                    ctx.fillStyle = arc.options.backgroundColor;
                                    ctx.beginPath();
                                    if (position == "start") {
                                        ctx.arc(arc.round.radius * Math.sin(startAngle), arc
                                            .round.radius * Math.cos(startAngle), arc.round
                                            .thickness, 0, 2 * Math.PI);
                                    } else {
                                        ctx.arc(arc.round.radius * Math.sin(endAngle), arc.round
                                            .radius * Math.cos(endAngle), arc.round
                                            .thickness, 0, 2 * Math.PI);
                                    }
                                    ctx.closePath();
                                    ctx.fill();
                                    ctx.restore();
                                });

                            }
                            ;
                        }
                    }
                }],
                options: {
                    responsive: true,
                    tooltips: {
                        displayColors: true,
                        zIndex: 999999,
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 10
                            }
                        },
                        title: {
                            // display: true,
                        }
                    },
                    scales: {
                        x: {
                            display: false,
                            stacked: true,
                        },
                        y: {
                            display: false,
                            stacked: true,
                        }
                    },
                }
            });
        },
        error: function (xhr, textStatus, errorThrown) {
            console.log('Error fetching user overview data: ' + textStatus);
        }
    });
}

// PRINT TOP DATA
getDashboardData();
function getDashboardData() {
    var url = $('#get-dashboard').val();
    $.ajax({
        type: "GET",
        url: url,
        dataType: "json",
        success: function (res) {
            $('#app_visitor').text(res.app_visitor);
            $('#app_blog').text(res.app_blog);
            $('#app_message').text(res.app_message);
            $('#app_comment').text(res.app_comment);

        }
    });
}

function getMonthNameFromIndex(index) {
    console.log('getMonthNameFromIndex - index:', index);
    var months = [
        "January", "February", "March", "April", "May", "June",
        "July", "August", "September", "October", "November", "December"
    ];
    console.log('getMonthNameFromIndex - months:', months);
    return months[index - 1];
}
/*******  ecbb3e1c-0fd2-4912-9d51-ee78f65fdd99  *******/


function getYearlyStatistics(year = new Date().getFullYear()) {
var url = $('#yearly-generates-url').val();
//totalSalesChart()
totalVisitorChart()
}

let statiSticsValu = false;

function visitorOverview(year = null) {
    const baseUrl = $('#get-visitor-overview').val();
    const url = year ? `${baseUrl}?year=${year}` : baseUrl;

    $.ajax({
        url: url,
        method: 'GET',
        dataType: 'json',
        success: function (res) {
            if (res?.data) {
                updateChartData(res.data, res.total_visitor);
                //console.log(res.data.data); // Just visitor data array
            } else {
                console.error('Invalid response format:', res);
            }
        },
        error: function (xhr, status, error) {
            console.error('Error fetching visitor data:', status, error);
        }
    });
}

function updateChartData(newData, totalVisitors) {
    statiSticsValu.data.labels = newData.name;
    statiSticsValu.data.datasets[0].data = newData.data;
    statiSticsValu.data.datasets[0].label = `Total Visitors: ${totalVisitors}`;
    statiSticsValu.update();
}
$(document).ready(function () {
    //initChart();        // First, create the chart
    visitorOverview();  // Then, fetch and push data
});

function totalVisitorChart(total_texts, total_images) {
if (statiSticsValu) {
    statiSticsValu.destroy();
}

var ctx = document.getElementById('monthly-statistics').getContext('2d');
var gradient = ctx.createLinearGradient(0, 100, 10, 280);
gradient.addColorStop(0, '#2DB0F6');
gradient.addColorStop(1, 'rgba(50, 130, 241, 0)');

var gradient2 = ctx.createLinearGradient(0, 0, 0, 290);
gradient2.addColorStop(0, 'rgba(255, 68, 5, 1)');
gradient2.addColorStop(1, 'rgba(255, 68, 5, 0)');

statiSticsValu = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
                backgroundColor: gradient,
                label: "Total Visitor:00",
                fill: true,
                borderWidth: 1,
                borderColor: "#2DB0F6",
                data: [10, 20, 10, 30, 20, 10, 20, 50, 40, 70, 60, 10],
            }
        ]
    },

    options: {
        responsive: true,
        tension: 0.3,
        tooltips: {
            displayColors: true,
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 30
                }
            },
            title: {
                // display: true,
            }
        },
        scales: {
            x: {
                display: true,
            },
            y: {
                display: true,
                beginAtZero: true
            }
        },
    },
});
};
function totalSalesChart(total_texts, total_images) {
if (statiSticsValu) {
    statiSticsValu.destroy();
}

var ctx = document.getElementById('monthly-statistics').getContext('2d');
var gradient = ctx.createLinearGradient(0, 100, 10, 280);
gradient.addColorStop(0, '#2DB0F6');
gradient.addColorStop(1, 'rgba(50, 130, 241, 0)');

var gradient2 = ctx.createLinearGradient(0, 0, 0, 290);
gradient2.addColorStop(0, 'rgba(255, 68, 5, 1)');
gradient2.addColorStop(1, 'rgba(255, 68, 5, 0)');

statiSticsValu = new Chart(ctx, {
    type: 'line',
    data: {
        labels: ['Jan', 'Feb', 'March', 'April', 'May', 'June', 'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
        datasets: [{
                backgroundColor: gradient,
                label: "Total Visitor:00",
                fill: true,
                borderWidth: 1,
                borderColor: "#2DB0F6",
                data: [10, 20, 10, 30, 20, 10, 20, 50, 40, 70, 60, 10],
            }
        ]
    },

    options: {
        responsive: true,
        tension: 0.3,
        tooltips: {
            displayColors: true,
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    usePointStyle: true,
                    padding: 30
                }
            },
            title: {
                // display: true,
            }
        },
        scales: {
            x: {
                display: true,
            },
            y: {
                display: true,
                beginAtZero: true
            }
        },
    },
});
};

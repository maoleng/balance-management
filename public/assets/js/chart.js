function formatValue(value)
{
    if (Math.abs(value) >= 1e6) {
        return (Math.abs(value) / 1e6).toFixed(1) + 'm';
    } else if (Math.abs(value) >= 1e3) {
        return (Math.abs(value) / 1e3).toFixed(1) + 'k';
    } else {
        return value.toString();
    }
}

function getPieOptions()
{
    return {
        series: [],
        labels: [],
        chart: {
            height: 350,
            type: 'pie',
            foreColor: 'grey',
        },
        colors: [],
        fill: {
            type: 'image',
            opacity: 0.85,
            image: {
                src: [],
                width: 25,
                imagedHeight: 25
            },
        },
        title: {
            text: 'Pie Chart',
            align: 'center'
        },
        stroke: {
            width: 4
        },
        dataLabels: {
            enabled: true,
            style: {
                colors: ['#111']
            },
            background: {
                enabled: true,
                foreColor: '#fff',
                borderWidth: 0
            }
        },
        tooltip: {
            enabled: true,
            y: {
                formatter: function (val) {
                    return formatValue(val);
                }
            }
        },
        responsive: [{
            breakpoint: 480,
            options: {
                chart: {
                    width: 200
                },
                legend: {
                    position: 'bottom'
                }
            }
        }]
    };
}

function getTreeMapOptions()
{
    return {
        series: [],
        legend: {
            show: false
        },
        chart: {
            height: 350,
            type: 'treemap',
            foreColor: 'grey',
        },
        title: {
            text: 'Tree Map Chart',
            align: 'center'
        },
        colors: [],
        plotOptions: {
            treemap: {
                distributed: true,
                enableShades: false
            }
        },
        tooltip: {
            enabled: true,
            style: {
                fontSize: '12px',
                fontFamily: undefined
            },
            y: {
                formatter: function (val) {
                    return formatValue(val);
                }
            }
        },

    };
}

function getStackedBarOptions() {
    return {
        series: [],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            foreColor: 'grey'
        },
        plotOptions: {
            bar: {
                horizontal: true,
                dataLabels: {
                    total: {
                        enabled: true,
                        offsetX: 0,
                        style: {
                            fontSize: '13px',
                            fontWeight: 900
                        },
                        formatter: function (val) {
                            return formatValue(val);
                        }
                    }
                }
            },
        },
        stroke: {
            width: 1,
            colors: ['#fff']
        },
        title: {
            text: 'Stacked Bar Chart',
            align: 'center',
        },
        xaxis: {
            categories: [],
            labels: {
                formatter: function (val) {
                    return formatValue(val);
                }
            }
        },
        yaxis: {
            title: {
                text: undefined
            },
            labels: {
                formatter: function (val) {
                    return formatValue(val);
                }
            }
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return formatValue(val);
                }
            }
        },
        fill: {
            opacity: 1
        },
        legend: {
            position: 'top',
            horizontalAlign: 'left',
            offsetX: 40
        },
        dataLabels: {
            formatter: function (val) {
                return formatValue(val);
            }
        }
    };
}

function getStackedAreaOptions() {
    return {
        chart: {
            height: 300,
            type: 'area',
            stacked: true,
            toolbar: {
                show: false,
            },
            events: {
                selection: function(chart, e) {
                    console.log(new Date(e.xaxis.min))
                }
            },
            foreColor: 'grey',
        },
        colors: ['blue', 'yellow', 'red'],
        dataLabels: {
            enabled: false
        },
        series: [],
        fill: {
            type: 'gradient',
            gradient: {
                opacityFrom: 0.6,
                opacityTo: 0.8,
            }
        },
        legend: {
            position: 'top',
            horizontalAlign: 'right',
            show: true,
        },
        xaxis: {
            type: 'datetime',
        },
        yaxis: {
            labels: {
                formatter: function(val) {
                    return formatValue(val);
                }
            },
        },
        grid: {
            yaxis: {
                lines: {
                    show: false,
                }
            },
            padding: {
                top: 20,
                right: 0,
                bottom: 0,
                left: 0
            },
        },
        stroke: {
            show: true,
            curve: 'smooth',
            width: 2,
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return formatValue(val);
                }
            }
        }
    };
}


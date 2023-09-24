function getPieOptions()
{
    return {
        series: [],
        labels: [],
        chart: {
            height: 350,
            type: 'pie',
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
            type: 'treemap'
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
        }
    };
}

function getStackedBarOptions()
{
    return {
        series: [],
        chart: {
            type: 'bar',
            height: 350,
            stacked: true,
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
                    return val + "đ"
                }
            }
        },
        yaxis: {
            title: {
                text: undefined
            },
        },
        tooltip: {
            y: {
                formatter: function (val) {
                    return val + "đ"
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
        }
    };
}

$(document).ready(function () {

    // =====================================================
    // GLOBAL DEFAULT (WAJIB)
    // =====================================================
    Chart.defaults.color = '#d1d5db'; // text abu terang
    Chart.defaults.borderColor = 'rgba(255,255,255,0.12)';
    Chart.defaults.font.family = 'Inter, system-ui, -apple-system';

    Chart.defaults.scale.grid.color = 'rgba(255,255,255,0.08)';
    Chart.defaults.scale.ticks.color = '#cbd5e1';

    Chart.defaults.plugins.legend.labels.color = '#e5e7eb';

    Chart.defaults.plugins.tooltip.backgroundColor = 'rgba(15,23,42,0.95)';
    Chart.defaults.plugins.tooltip.titleColor = '#f8fafc';
    Chart.defaults.plugins.tooltip.bodyColor = '#e5e7eb';
    Chart.defaults.plugins.tooltip.borderColor = 'rgba(255,255,255,0.15)';
    Chart.defaults.plugins.tooltip.borderWidth = 1;

    // =====================================================
    // SALES & PURCHASES (BAR)
    // =====================================================
    let salesPurchasesBar = document.getElementById('salesPurchasesChart');

    $.get('/sales-purchases/chart-data', function (response) {
        new Chart(salesPurchasesBar, {
            type: 'bar',
            data: {
                labels: response.sales.original.days,
                datasets: [
                    {
                        label: 'Sales',
                        data: response.sales.original.data,
                        backgroundColor: '#6366F1',
                        borderColor: '#6366F1',
                        borderWidth: 1
                    },
                    {
                        label: 'Purchases',
                        data: response.purchases.original.data,
                        backgroundColor: '#A5B4FC',
                        borderColor: '#A5B4FC',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255,255,255,0.06)'
                        },
                        ticks: {
                            color: '#cbd5e1'
                        }
                    },
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: 'rgba(255,255,255,0.06)'
                        },
                        ticks: {
                            color: '#cbd5e1'
                        }
                    }
                }
            }
        });
    });

    // =====================================================
    // CURRENT MONTH (DOUGHNUT)
    // =====================================================
    let overviewChart = document.getElementById('currentMonthChart');

    $.get('/current-month/chart-data', function (response) {
        new Chart(overviewChart, {
            type: 'doughnut',
            data: {
                labels: ['Sales', 'Purchases', 'Expenses'],
                datasets: [{
                    data: [response.sales, response.purchases, response.expenses],
                    backgroundColor: [
                        '#F59E0B',
                        '#0284C7',
                        '#EF4444',
                    ],
                    borderColor: 'rgba(255,255,255,0.15)',
                    borderWidth: 1,
                }]
            },
            options: {
                cutout: '70%',
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            color: '#e5e7eb'
                        }
                    }
                }
            }
        });
    });

    // =====================================================
    // PAYMENT FLOW (LINE)
    // =====================================================
    let paymentChart = document.getElementById('paymentChart');

    $.get('/payment-flow/chart-data', function (response) {
        new Chart(paymentChart, {
            type: 'line',
            data: {
                labels: response.months,
                datasets: [
                    {
                        label: 'Payment Sent',
                        data: response.payment_sent,
                        borderColor: '#EA580C',
                        backgroundColor: 'rgba(234,88,12,0.15)',
                        tension: 0.3
                    },
                    {
                        label: 'Payment Received',
                        data: response.payment_received,
                        borderColor: '#2563EB',
                        backgroundColor: 'rgba(37,99,235,0.15)',
                        tension: 0.3
                    }
                ]
            },
            options: {
                scales: {
                    x: {
                        grid: {
                            color: 'rgba(255,255,255,0.06)'
                        },
                        ticks: {
                            color: '#cbd5e1'
                        }
                    },
                    y: {
                        grid: {
                            color: 'rgba(255,255,255,0.06)'
                        },
                        ticks: {
                            color: '#cbd5e1'
                        }
                    }
                }
            }
        });
    });

});

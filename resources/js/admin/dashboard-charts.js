/**
 * AzkaMandiri ERP - Executive Dashboard Highcharts Module
 * Handles high-fidelity financial analytics, sales trends, and asset valuation charts.
 */

document.addEventListener('DOMContentLoaded', function () {
    if (typeof Highcharts === 'undefined') return;

    function formatIDR(amount) {
        return 'Rp ' + (amount || 0).toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    Highcharts.setOptions({
        lang: {
            thousandsSep: '.',
            decimalPoint: ',',
            months: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
            shortMonths: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            weekdays: ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'],
            exportButtonTitle: "Ekspor Grafik",
            printButtonTitle: "Cetak Grafik"
        },
        credits: { enabled: false },
        exporting: {
            enabled: false // Custom trigger via window.exportChartMain
        }
    });

    let mainChartInstance = null;

    // 1. Highcharts Main Multi-Axis Spline & Column Chart (Sales & Profit)
    const salesEl = document.getElementById('highcharts-sales-container');
    if (salesEl) {
        const categories = JSON.parse(salesEl.dataset.categories || '[]');
        const salesData = JSON.parse(salesEl.dataset.sales || '[]');
        const profitData = JSON.parse(salesEl.dataset.profit || '[]');
        const purchasesData = JSON.parse(salesEl.dataset.purchases || '[]');
        const trxCountData = JSON.parse(salesEl.dataset.trxCount || '[]');
        const selectedYear = salesEl.dataset.year || new Date().getFullYear();

        mainChartInstance = Highcharts.chart('highcharts-sales-container', {
            chart: {
                backgroundColor: 'transparent',
                style: { fontFamily: 'Inter, system-ui, sans-serif' },
                spacingTop: 15,
                spacingBottom: 15
            },
            title: { text: null },
            xAxis: {
                categories: categories,
                crosshair: {
                    width: 1,
                    color: 'rgba(214, 168, 79, 0.4)',
                    dashStyle: 'ShortDot'
                },
                labels: {
                    style: { color: '#64748b', fontSize: '11px', fontWeight: '600' }
                },
                lineColor: '#e2e8f0'
            },
            yAxis: [{
                title: {
                    text: 'Nominal Keuangan (Rp)',
                    style: { color: '#172B4D', fontSize: '11px', fontWeight: 'bold' }
                },
                labels: {
                    formatter: function() {
                        if (this.value >= 1000000) {
                            return (this.value / 1000000).toFixed(1) + ' Jt';
                        } else if (this.value >= 1000) {
                            return (this.value / 1000).toFixed(0) + ' Rb';
                        }
                        return this.value;
                    },
                    style: { color: '#64748b', fontSize: '11px' }
                },
                gridLineColor: '#f1f5f9',
                min: 0
            }, {
                title: {
                    text: 'Jumlah Transaksi',
                    style: { color: '#0284c7', fontSize: '11px', fontWeight: 'bold' }
                },
                labels: {
                    style: { color: '#0284c7', fontSize: '11px' },
                    format: '{value} nota'
                },
                opposite: true,
                gridLineWidth: 0,
                min: 0
            }],
            tooltip: {
                shared: true,
                useHTML: true,
                backgroundColor: '#101D33',
                borderColor: '#D6A84F',
                borderRadius: 12,
                borderWidth: 1.5,
                shadow: { color: 'rgba(16, 29, 51, 0.3)', offsetX: 0, offsetY: 4, width: 8 },
                style: { color: '#ffffff', fontSize: '12px' },
                formatter: function () {
                    let html = '<div class="p-2 min-w-[210px]">';
                    html += '<div class="font-bold text-[#D6A84F] text-xs pb-1 mb-1.5 border-b border-white/10">Bulan: ' + this.x + ' ' + selectedYear + '</div>';
                    this.points.forEach(function (point) {
                        if (point.series.name === 'Total Transaksi') {
                            html += '<div class="flex justify-between my-1 text-sky-300"><span style="color:' + point.color + '">● ' + point.series.name + ':</span> <strong>' + point.y + ' order</strong></div>';
                        } else {
                            html += '<div class="flex justify-between my-1"><span style="color:' + point.color + '">● ' + point.series.name + ':</span> <strong class="font-mono">' + formatIDR(point.y) + '</strong></div>';
                        }
                    });
                    html += '</div>';
                    return html;
                }
            },
            legend: {
                align: 'center',
                verticalAlign: 'bottom',
                itemStyle: { color: '#334155', fontWeight: '600', fontSize: '12px' },
                itemHoverStyle: { color: '#172B4D' }
            },
            plotOptions: {
                spline: {
                    lineWidth: 3,
                    marker: {
                        radius: 4,
                        lineWidth: 2,
                        lineColor: '#ffffff'
                    }
                },
                column: {
                    borderRadius: 4,
                    borderWidth: 0,
                    opacity: 0.65
                }
            },
            series: [{
                name: 'Omzet Penjualan',
                type: 'spline',
                yAxis: 0,
                data: salesData,
                color: '#172B4D',
                marker: { symbol: 'circle' }
            }, {
                name: 'Laba Kotor',
                type: 'spline',
                yAxis: 0,
                data: profitData,
                color: '#D6A84F',
                marker: { symbol: 'diamond', radius: 5 }
            }, {
                name: 'Belanja Material',
                type: 'spline',
                yAxis: 0,
                data: purchasesData,
                color: '#7c3aed',
                marker: { symbol: 'triangle', radius: 4 }
            }, {
                name: 'Total Transaksi',
                type: 'column',
                yAxis: 1,
                data: trxCountData,
                color: '#0284c7'
            }]
        });
    }

    window.exportChartMain = function() {
        if (mainChartInstance) {
            const salesEl = document.getElementById('highcharts-sales-container');
            const selectedYear = (salesEl && salesEl.dataset.year) ? salesEl.dataset.year : new Date().getFullYear();
            mainChartInstance.exportChart({
                type: 'image/png',
                filename: 'Grafik-Kinerja-AzkaMandiri-' + selectedYear
            });
        }
    };

    // 2. Highcharts Donut Chart (Sales Composition)
    const pieEl = document.getElementById('highcharts-pie-container');
    if (pieEl) {
        const retailVal = parseFloat(pieEl.dataset.retail) || 0.01;
        const customVal = parseFloat(pieEl.dataset.custom) || 0.01;

        Highcharts.chart('highcharts-pie-container', {
            chart: {
                type: 'pie',
                backgroundColor: 'transparent',
                style: { fontFamily: 'Inter, system-ui, sans-serif' },
                spacingTop: 10,
                spacingBottom: 10
            },
            title: { text: null },
            tooltip: {
                useHTML: true,
                backgroundColor: '#101D33',
                borderColor: '#D6A84F',
                borderRadius: 10,
                style: { color: '#ffffff', fontSize: '12px' },
                formatter: function() {
                    return '<div class="p-1"><strong>' + this.point.name + '</strong><br>' +
                           '<span class="font-mono text-[#D6A84F]">' + formatIDR(this.y) + '</span> (' + this.percentage.toFixed(1) + '%)</div>';
                }
            },
            plotOptions: {
                pie: {
                    innerSize: '65%',
                    allowPointSelect: true,
                    cursor: 'pointer',
                    dataLabels: { enabled: false },
                    showInLegend: true
                }
            },
            legend: {
                align: 'center',
                verticalAlign: 'bottom',
                layout: 'horizontal',
                itemStyle: { color: '#334155', fontWeight: '600', fontSize: '11px' }
            },
            series: [{
                name: 'Omzet',
                colorByPoint: true,
                data: [
                    { name: 'Penjualan Ritel', y: retailVal, color: '#172B4D' },
                    { name: 'Pesanan Custom', y: customVal, color: '#D6A84F' }
                ]
            }]
        });
    }

    // 3. Highcharts Column Chart (Category Inventory Valuation)
    const catEl = document.getElementById('highcharts-category-container');
    if (catEl) {
        const catCategories = JSON.parse(catEl.dataset.categories || '[]');
        const catCostValues = JSON.parse(catEl.dataset.costValues || '[]');
        const catRetailValues = JSON.parse(catEl.dataset.retailValues || '[]');

        Highcharts.chart('highcharts-category-container', {
            chart: {
                type: 'column',
                backgroundColor: 'transparent',
                style: { fontFamily: 'Inter, system-ui, sans-serif' },
                spacingBottom: 10
            },
            title: { text: null },
            xAxis: {
                categories: catCategories,
                crosshair: true,
                labels: {
                    style: { color: '#475569', fontSize: '11px', fontWeight: '600' }
                }
            },
            yAxis: {
                min: 0,
                title: {
                    text: 'Nilai Aset (Rp)',
                    style: { color: '#172B4D', fontSize: '11px', fontWeight: 'bold' }
                },
                labels: {
                    formatter: function() {
                        if (this.value >= 1000000) {
                            return (this.value / 1000000).toFixed(1) + ' Jt';
                        } else if (this.value >= 1000) {
                            return (this.value / 1000).toFixed(0) + ' Rb';
                        }
                        return this.value;
                    },
                    style: { color: '#64748b', fontSize: '11px' }
                },
                gridLineColor: '#f1f5f9'
            },
            tooltip: {
                shared: true,
                useHTML: true,
                backgroundColor: '#101D33',
                borderColor: '#D6A84F',
                borderRadius: 10,
                style: { color: '#ffffff', fontSize: '12px' },
                formatter: function () {
                    let html = '<div class="p-1">';
                    html += '<strong class="text-[#D6A84F]">' + this.x + '</strong><br>';
                    this.points.forEach(function (point) {
                        html += '<span style="color:' + point.color + '">● ' + point.series.name + ':</span> <strong>' + formatIDR(point.y) + '</strong><br>';
                    });
                    html += '</div>';
                    return html;
                }
            },
            plotOptions: {
                column: {
                    borderRadius: 4,
                    borderWidth: 0
                }
            },
            legend: {
                align: 'right',
                verticalAlign: 'top',
                itemStyle: { color: '#334155', fontWeight: '600', fontSize: '11px' }
            },
            series: [{
                name: 'Aset Modal (HPP)',
                data: catCostValues,
                color: '#101D33'
            }, {
                name: 'Nilai Jual Retail',
                data: catRetailValues,
                color: '#D6A84F'
            }]
        });
    }
});

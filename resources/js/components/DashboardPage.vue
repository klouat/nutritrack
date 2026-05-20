<template>
    <div class="container mx-auto px-4">
        <h1 class="text-2xl font-semibold mb-6">Dashboard</h1>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Sugar Intake -->
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-4">Kadar Gula Harian</h2>
                <div class="flex justify-center">
                    <div ref="gulaChartRef" class="apex-chart"></div>
                </div>
               
                <div class="text-center mt-4">
                    <p class="text-gray-600 text-sm">
                        Total: {{ dailyData.total_gula }} dari {{ dailyData.max_gula }} gram
                    </p>
                </div>
            </div>
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-4">Kadar Kalori Harian</h2>
                <div class="flex justify-center">
                    <div ref="kaloriChartRef" class="apex-chart"></div>
                </div>
                <div class="text-center mt-4">
                    <p class="text-gray-600 text-sm">
                        Total: {{ dailyData.total_kalori }} dari {{ dailyData.max_kalori }} kalori
                    </p>
                </div>
            </div>
        </div>

        <div class="mt-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <div class="flex items-center justify-between mb-4 gap-4">
                    <div>
                        <h2 class="text-lg font-semibold">Riwayat Asupan Hari Ini</h2>
                        <p class="text-sm text-gray-500">Catatan konsumsi yang sudah kamu input hari ini.</p>
                    </div>
                    <span class="text-sm font-medium text-[#007AFF]">{{ todayAsupan.length }} catatan</span>
                </div>

                <div v-if="todayAsupan.length" class="space-y-3">
                    <div
                        v-for="item in todayAsupan"
                        :key="item.id"
                        class="rounded-lg border border-gray-100 bg-gray-50 p-4"
                    >
                        <div class="flex flex-col gap-3 md:flex-row md:items-start md:justify-between">
                            <div>
                                <h3 class="font-semibold text-gray-900">{{ item.nama }}</h3>
                                <p v-if="item.catatan" class="mt-1 text-sm text-gray-600">{{ item.catatan }}</p>
                                <p v-else class="mt-1 text-sm text-gray-400">Tidak ada catatan.</p>
                            </div>
                            <span class="inline-flex w-fit rounded-full bg-[#EAF4FF] px-3 py-1 text-sm font-medium text-[#007AFF]">
                                {{ item.waktu_konsumsi }}
                            </span>
                        </div>

                        <div class="mt-3 grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <div class="rounded-md bg-white px-3 py-2">
                                <p class="text-xs uppercase tracking-wide text-gray-400">Kadar Gula</p>
                                <p class="text-sm font-semibold text-gray-800">{{ formatNumber(item.kadar_gula) }} gram</p>
                            </div>
                            <div class="rounded-md bg-white px-3 py-2">
                                <p class="text-xs uppercase tracking-wide text-gray-400">Kadar Kalori</p>
                                <p class="text-sm font-semibold text-gray-800">{{ formatNumber(item.kadar_kalori) }} kalori</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-else class="rounded-lg border border-dashed border-gray-200 bg-gray-50 p-6 text-center text-sm text-gray-500">
                    Belum ada catatan asupan untuk hari ini.
                </div>
            </div>
        </div>

        <div class="mt-8">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold mb-4">Ringkasan Asupan Hari Ini</h2>
                <div class="flex justify-between items-center">
                    <div>
                        <p class="text-gray-700">
                            <i :class="gulaIcon.class + ' mr-2'"></i> {{ gulaIcon.text }}
                        </p>
                        <p class="text-gray-700 mt-2">
                            <i :class="kaloriIcon.class + ' mr-2'"></i> {{ kaloriIcon.text }}
                        </p>
                    </div>
                    <a :href="routeCreate" class="bg-gradient-to-r from-[#007AFF] to-[#00D26A] text-white py-2 px-4 rounded-lg shadow hover:shadow-lg transition duration-300">
                        <i class="fas fa-plus mr-2"></i> Catat Asupan Baru
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
const ApexCharts = window.ApexCharts;

export default {
    data() {
        return {
            dailyData: window.dailyData || {
                total_gula: 0,
                total_kalori: 0,
                gula_percentage: 0,
                kalori_percentage: 0,
                max_gula: 50,
                max_kalori: 2400
            },
            todayAsupan: window.todayAsupan || [],
            routeCreate: window.routeCreate || '/asupan',
            gulaChart: null,
            kaloriChart: null,
            refreshIntervalId: null
        };
    },
    computed: {
        gulaIcon() {
            const percent = this.dailyData.gula_percentage;
            if (percent < 75) return { class: 'fas fa-check-circle text-green-500', text: 'Konsumsi gula Anda masih dalam batas yang baik.' };
            if (percent < 100) return { class: 'fas fa-exclamation-circle text-yellow-500', text: 'Konsumsi gula Anda mendekati batas maksimal.' };
            return { class: 'fas fa-times-circle text-red-500', text: 'Konsumsi gula Anda sudah melebihi batas maksimal!' };
        },
        kaloriIcon() {
            const percent = this.dailyData.kalori_percentage;
            if (percent < 75) return { class: 'fas fa-check-circle text-green-500', text: 'Konsumsi kalori Anda masih dalam batas yang baik.' };
            if (percent < 100) return { class: 'fas fa-exclamation-circle text-yellow-500', text: 'Konsumsi kalori Anda mendekati batas maksimal.' };
            return { class: 'fas fa-times-circle text-red-500', text: 'Konsumsi kalori Anda sudah melebihi batas maksimal!' };
        }
    },
    mounted() {
        this.$nextTick(() => {
            this.renderCharts();
            this.fetchDashboardData();
            this.startAutoRefresh();
        });
    },
    beforeUnmount() {
        if (this.refreshIntervalId) {
            clearInterval(this.refreshIntervalId);
        }
        if (this.gulaChart) {
            this.gulaChart.destroy();
        }
        if (this.kaloriChart) {
            this.kaloriChart.destroy();
        }
    },
    methods: {
        startAutoRefresh() {
            this.refreshIntervalId = window.setInterval(() => {
                this.fetchDashboardData();
            }, 10000);
        },
        async fetchDashboardData() {
            try {
                const response = await window.axios.get('/api/dashboard');
                this.dailyData = {
                    ...this.dailyData,
                    ...response.data.summary,
                };
                this.todayAsupan = response.data.today_asupan || [];
                this.updateCharts();
            } catch (error) {
                console.error('Failed to refresh dashboard data:', error);
            }
        },
        formatNumber(value) {
            const parsedValue = Number(value);

            if (Number.isNaN(parsedValue)) {
                return value;
            }

            return new Intl.NumberFormat('id-ID', {
                minimumFractionDigits: 0,
                maximumFractionDigits: 2,
            }).format(parsedValue);
        },
        renderCharts() {
            if (!ApexCharts) {
                console.error('ApexCharts is not loaded');
                return;
            }

            const chartOptions = (percentage) => ({
                series: [percentage],
                chart: { type: 'radialBar', height: 250, offsetY: -10 },
                plotOptions: {
                    radialBar: {
                        startAngle: -90,
                        endAngle: 90,
                        hollow: { margin: 0, size: '70%' },
                        track: {
                            background: '#e7e7e7',
                            strokeWidth: '97%',
                            margin: 5,
                            dropShadow: { enabled: true, top: 2, blur: 4, opacity: 0.15 }
                        },
                        dataLabels: {
                            name: { show: false },
                            value: {
                                offsetY: -2,
                                fontSize: '22px',
                                formatter: (val) => val + '%'
                            }
                        }
                    }
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shade: 'dark',
                        type: 'horizontal',
                        gradientToColors: ['#00D26A'],
                        stops: [0, 100],
                        colorStops: [
                            { offset: 0, color: "#007AFF", opacity: 1 },
                            { offset: 100, color: "#00D26A", opacity: 1 }
                        ]
                    }
                },
                stroke: { lineCap: 'round' }
            });
            this.gulaChart = new ApexCharts(this.$refs.gulaChartRef, chartOptions(this.dailyData.gula_percentage));
            this.gulaChart.render();
            
            this.kaloriChart = new ApexCharts(this.$refs.kaloriChartRef, chartOptions(this.dailyData.kalori_percentage));
            this.kaloriChart.render();
        },
        updateCharts() {
            if (this.gulaChart) {
                this.gulaChart.updateSeries([this.dailyData.gula_percentage]);
            }

            if (this.kaloriChart) {
                this.kaloriChart.updateSeries([this.dailyData.kalori_percentage]);
            }
        }
    }
};
</script>

<style scoped>
.apex-chart {
    width: 100%;
    min-height: 250px;
}
</style>

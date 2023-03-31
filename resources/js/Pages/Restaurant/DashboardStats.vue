
<template>
    <DashLayout>

        <div>
      <canvas id="ordersByDayOfWeekChart" >
      </canvas>
      <p class="text-red-800" >{{ total_commandes }}</p>
    </div>
    </DashLayout>
</template>

  <script>
  import Chart from 'chart.js/auto';
import DashLayout from './DashLayout.vue';

  export default {
    props: {
        commandes_par_jour: {
            type: Array,
            default: () => []
        },
        total_commandes: {
            type: Number,
            default: () => null
        }
    },
    mounted() {
        this.createChart();
    },
    methods: {
        createChart() {
            const chartData = {
                labels: this.commandes_par_jour.map(order => order.dayOfWeek),
                datasets: [{
                        label: "Nombre de commandes",
                        data: this.commandes_par_jour.map(order => (order.totalOrders / this.total_commandes)),
                        backgroundColor: [
                            "#FF6384",
                            "#36A2EB",
                            "#FFCE56",
                            "#3D9970",
                            "#FF4136",
                            "#2ECC40",
                            "#F012BE"
                        ],
                        borderWidth: 1
                    }]
            };
            new Chart("ordersByDayOfWeekChart", {
                type: "bar",
                data: chartData,
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }
    },
    components: { DashLayout }
}
  </script>

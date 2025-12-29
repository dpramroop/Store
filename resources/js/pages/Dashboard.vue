<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { Line } from 'vue-chartjs';
import type { ChartOptions,ChartData } from 'chart.js';
import { dashboard } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import{ref,computed} from 'vue';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { Chart as ChartJS, Title, Tooltip, Legend, CategoryScale, LinearScale,LineElement,  PointElement } from 'chart.js'

ChartJS.register(Title, Tooltip, Legend, CategoryScale, LinearScale,LineElement,  PointElement)

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: dashboard().url,
    },
];

const props= defineProps({
    orders:{
        type:Array
    }
})
const totalprice=ref(0)
const orders= ref ([...props.orders ?? []])

const revenueByDate = computed(() => {
  const map = new Map<string, number>();

  orders.value.forEach((order:any) => {
    const date = new Date(order.created_at).toLocaleDateString();






    map.set(date, (map.get(date) ?? 0) + order.totalprice)
  });

  return Array.from(map.entries())
    .sort(([a], [b]) => new Date(a).getTime() - new Date(b).getTime());;
});

const totalRevenue = computed(() =>
  revenueByDate.value.reduce((sum, [, value]) => sum + value, 0)
);
const lineChartData: ChartData<'line'> = {
  labels: revenueByDate.value.map(([date]) => date),
  datasets: [
    {
      label: 'Orders',
      data:  revenueByDate.value.map(([,total]) => total),
      borderColor: '#4f46e5',     // indigo-600
      backgroundColor: 'rgba(79, 70, 229, 0.2)',
      tension: 0.4,               // smooth curve
      fill: true,
      pointRadius: 5,
      pointHoverRadius: 7
    }
  ]
};
const lineChartOptions : ChartOptions<'line'> = {
  responsive: true,
  maintainAspectRatio: false,
  plugins: {
    legend: {
      position: 'top'
    },
    title: {
      display: true,
      text: 'Monthly Revenue'
    }
  },
  scales: {
    y: {
      beginAtZero: true
    }
  }
};

</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div
            class="flex h-full flex-1 flex-col gap-4 overflow-x-auto rounded-xl p-4"
        >
            <div class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                  <h1>{{ totalprice }}</h1>
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
                    <PlaceholderPattern />
                </div>
                <div
                    class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border"
                >
              <Line :data="lineChartData" :options="lineChartOptions" />
                </div>
            </div>
            <div
                class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border"
            >


<Line :data="lineChartData" :options="lineChartOptions" />



            </div>
        </div>
    </AppLayout>
</template>

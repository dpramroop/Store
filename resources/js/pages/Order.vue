<script setup lang="ts">
// Your imports go here

// Your reactive variables, computed properties, and methods go here
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { order } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head,router } from '@inertiajs/vue3';
import OrderDetail from './Order/OrderDetail.vue';

const props = defineProps<{
  message?: string
  orders: Array<any>
}>()

const orderList = ref([...props.orders ?? []])

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Item',
        href: order().url,
    },
];



</script>
<template>
     <Head title="Order"/>

<app-layout :breadcrumbs="breadcrumbs">

    <div>{{JSON.stringify(orderList)}}</div>
    <div v-for="order in orderList" :key="order.id" class="mb-4">
      <OrderDetail
        :order="order" />

    </div>

</app-layout>
</template>



<style scoped>
/* Your component styles go here */
</style>

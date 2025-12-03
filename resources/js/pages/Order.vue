<script setup lang="ts">
// Your imports go here

// Your reactive variables, computed properties, and methods go here
import { defineProps,ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { order } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head,router } from '@inertiajs/vue3';

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
<h1>Hello</h1>

    <div v-for="order in orderList" :key="order.id" class="mb-4">
        <p>Order ID: {{ order.id }}</p>

        <p>Total Amount: ${{ order.totalprice }}</p>
        <hr />
    </div>

</app-layout>
</template>



<style scoped>
/* Your component styles go here */
</style>

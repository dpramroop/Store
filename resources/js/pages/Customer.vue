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
  customers: Array<any>
}>()

const orderList = ref([...props.customers ?? []])

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
<h1>Hello Customer</h1>


</app-layout>
</template>



<style scoped>
/* Your component styles go here */
</style>

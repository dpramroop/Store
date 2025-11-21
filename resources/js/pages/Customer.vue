<script setup lang="ts">
// Your imports go here

// Your reactive variables, computed properties, and methods go here
import { defineProps,ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { order } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head} from '@inertiajs/vue3';
import AddCustomer from './Customer/AddCustomer.vue';

const props = defineProps<{
  message?: string
  customers: Array<any>
}>()

const customerList = ref([...props.customers ?? []])

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Item',
        href: order().url,
    },
];

function addCustomer(customer: any) {

      customerList.value.push(customer)

    //   alert(JSON.stringify(item));
}

</script>
<template>
     <Head title="Order"/>

<app-layout :breadcrumbs="breadcrumbs">
<h1>Hello Customer</h1>
<AddCustomer v-on:customer-added="addCustomer"/>
<div>
    <!-- Your template content goes here -->

   <div v-for="customer in customerList" :key="customer.id" class="mb-4">
    <p>{{ customer.fname }} {{ customer.lname }} - {{ customer.email }} - {{ customer.contact_no }}</p>

   </div>
</div>

</app-layout>
</template>



<style scoped>
/* Your component styles go here */
</style>

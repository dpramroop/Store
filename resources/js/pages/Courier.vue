<script setup lang="ts">
// Your imports go here

// Your reactive variables, computed properties, and methods go here
import { defineProps,ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { order } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head} from '@inertiajs/vue3';
import AddCourier from './Courier/AddCourier.vue';
import ListCourier from './Courier/ListCourier.vue';

const props = defineProps<{
  message?: string
  couriers: Array<any>
}>()

const search=ref('')
const courierList = ref([...props.couriers ?? []])

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Item',
        href: order().url,
    },
];

function addCourier(customer: any) {

      courierList.value.push(customer)

    //   alert(JSON.stringify(item));
}

function updateCourier(courier: any) {

  courierList.value = courierList.value.map((it) =>
    it.id === courier.id ? { ...courier } : it
  )

  // Force Vue to see the change
  courierList.value = [...courierList.value]

}

function filterCouriers() {
    if (search.value.trim() === '') {
        courierList.value = [...props.couriers ?? []]
    } else {
        const searchTerm = search.value.toLowerCase()
        courierList.value = (props.couriers ?? []).filter((courier) =>
            courier.fname.toLowerCase().includes(searchTerm) ||
            courier.email.toLowerCase().includes(searchTerm)
        )
    }
}

</script>
<template>
     <Head title="Courier"/>

<app-layout :breadcrumbs="breadcrumbs">
<h1>Hello Courier</h1>
<AddCourier v-on:courier-added="addCourier"/>
<div>
    <!-- Your template content goes here -->
   <input type="text" v-model="search" placeholder="Search Couriers..." @change="filterCouriers" class="border p-2 mb-4 w-full"/>
   <div v-for="courier in courierList" :key="courier.id" class="mb-4">
    <ListCourier :courier="courier" v-on:courier-updated="updateCourier"/>

   </div>
</div>

</app-layout>
</template>



<style scoped>
/* Your component styles go here */
</style>

<script setup lang="ts">
// Your imports go here

// Your reactive variables, computed properties, and methods go here
import { defineProps,ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { order } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head} from '@inertiajs/vue3';
import AddCustomer from './Customer/AddCustomer.vue';
import ListCustomer from './Customer/ListCustomer.vue';
import AddOrder from './Order/AddOrder.vue';


const props = defineProps<{
  message?: string
  customers: Array<any>
  items:Array<any>
  courier:Array<any>
}>()
const modalKey = ref(0)
const search=ref('')
const customer=ref(Object)
const customerList = ref([...props.customers ?? []])
const showAddOrder=ref(false)
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Customer',
        href: order().url,
    },
];

function addCustomer(customer: any) {

      customerList.value.push(customer)

    //   alert(JSON.stringify(item));
}

function updateCustomer(item: any) {

  customerList.value = customerList.value.map((it) =>
    it.id === item.id ? { ...item } : it
  )

  // Force Vue to see the change
  customerList.value = [...customerList.value]

}

function openModal(chosencustomer:any)
{
modalKey.value++
      customer.value=chosencustomer
  showAddOrder.value=!showAddOrder.value

}
function filterCustomers() {
    if (search.value.trim() === '') {
        customerList.value = [...props.customers ?? []]
    } else {
        const searchTerm = search.value.toLowerCase()
        customerList.value = (props.customers ?? []).filter((customer) =>
            customer.fname.toLowerCase().includes(searchTerm) ||
            customer.email.toLowerCase().includes(searchTerm)
        )
    }
}

</script>
<template>
     <Head title="Order"/>

<app-layout :breadcrumbs="breadcrumbs">
<h1>Hello Customer</h1>
<AddCustomer v-on:customer-added="addCustomer"/>
<div v-show="showAddOrder">
<AddOrder :key="modalKey" :customer="customer" :items="items" v-on:close-ordermodal="openModal" />

</div>

<div>
    <!-- Your template content goes here -->
   <input type="text" v-model="search" placeholder="Search Customers..." @change="filterCustomers" class="border p-2 mb-4 w-full"/>
   <div v-for="customer in customerList" :key="customer.id" class="mb-4">
    <ListCustomer :customer="customer"   v-on:customer-updated="updateCustomer" v-on:open-modal="openModal"/>

   </div>
</div>

</app-layout>
</template>



<style scoped>
/* Your component styles go here */
</style>

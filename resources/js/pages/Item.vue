
<script setup lang="ts">
// Your imports go here

// Your reactive variables, computed properties, and methods go here
import { defineProps } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { item } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import AddPage from './Item/AddPage.vue';
const props = defineProps({
  message: String,
});


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Item',
        href: item().url,
    },
];


</script>
<template>
     <Head title="Item" />

<app-layout :breadcrumbs="breadcrumbs">
           <AddPage/>
    <div>
        <!-- Your template content goes here -->
        <p>{{ props.message }}</p>

    </div>
</app-layout>
</template>



<style scoped>
/* Your component styles go here */
</style>

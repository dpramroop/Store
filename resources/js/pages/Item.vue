<script setup lang="ts">
// Your imports go here

// Your reactive variables, computed properties, and methods go here
import { defineProps,ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { item } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import AddPage from './Item/AddPage.vue';
const props = defineProps({
  message: String,
  items: Array,
});

const itemList = ref([...props.items ?? []])
const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Item',
        href: item().url,
    },
];


</script>
<template>
     <Head title="Item"/>

<app-layout :breadcrumbs="breadcrumbs">
           <AddPage   :items="itemList"
  @item-added="itemList.push($event)"/>
    <div>
        <!-- Your template content goes here -->
        <p>{{ props.message }}</p>
        <ul>
          <li v-for="item in itemList" :key="item.id">
            {{ item.name }} - {{ item.description }} - {{ item.attributes[0].name }} {{ item.attributes[0].value }}

          </li>
        </ul>
    </div>
</app-layout>
</template>



<style scoped>
/* Your component styles go here */
</style>

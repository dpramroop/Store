<script setup lang="ts">
// Your imports go here

// Your reactive variables, computed properties, and methods go here
import { defineProps,ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { item } from '@/routes';
import { type BreadcrumbItem } from '@/types';
import { Head,router } from '@inertiajs/vue3';
import AddPage from './Item/AddPage.vue';
import ListItem from './Item/ListItem.vue';
const props = defineProps<{
  message?: string
  items: Array<any>
}>()

const itemList = ref([...props.items ?? []])

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Item',
        href: item().url,
    },
];

function addItem(item: any) {

      itemList.value.push(item)
  router.reload({ only: ['items'] })
      alert(JSON.stringify(item));
}

</script>
<template>
     <Head title="Item"/>

<app-layout :breadcrumbs="breadcrumbs">
           <AddPage v-on:item-added="addItem"/>
    <div>
        <!-- Your template content goes here -->
        <p>{{ props.message }}</p>
       <div v-for="item in itemList" :key="item.id" class="mb-4">
        <ListItem :item="item"/>

       </div>
    </div>
</app-layout>
</template>



<style scoped>
/* Your component styles go here */
</style>

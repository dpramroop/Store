<template>
    <article class="item-card" @keyup.enter="toggle" tabindex="0" role="button" :aria-expanded="open.toString()">
        <header class="item-header" @click="toggle">
            <h3 class="item-name">{{ customer.fname }} {{ customer.lname }}</h3>
            <button class="toggle-btn" @click.stop="toggle" :aria-pressed="open.toString()">
                <span v-if="!open">Show details</span>
                <span v-else>Hide details</span>
                <svg class="chev" viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M7 10l5 5 5-5" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>
            <UpdateCustomer :customer_given="customer" v-on:customer-updated="notifyUpdate"/>
              <button @click="openModal(customer)" class="border bg-indigo-700">Add Order</button>
        </header>

        <transition name="fade">
  <div v-if="open" class="details">
    <div class="field"><strong>Email:</strong> <span>{{ customer.email || '' }}</span></div>
  <div class="field"><strong>Contact Number:</strong> <span>{{ customer.contact_no || '' }}</span></div>

  </div>

        </transition>
    </article>
</template>

<script setup lang="ts">
import { ref,defineProps,defineEmits } from 'vue'
import UpdateCustomer from './UpdateCustomer.vue'
import AddOrder from '../Order/AddOrder.vue';
defineProps({
    customer: {
        type: Object,
        default: () => ({
            fname: 'Untitled Item',
            lname: '',
            email: '',
            contact_no: ''
        })
    }
}
)
const emits = defineEmits<{
    (e: 'customer-updated', customer: any): void,
    (e: 'open-modal', customer: any): void
}>()

const open = ref(false)
function toggle() {
    open.value = !open.value
}
function notifyUpdate(updatedCustomer: any) {
    emits('customer-updated', updatedCustomer)
}

function openModal(id:any) {
  emits('open-modal', id)
}
</script>

<style scoped>
.item-card {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 12px;
    max-width: 520px;
    background: #fff;
    box-shadow: 0 1px 2px rgba(0,0,0,0.03);
    cursor: pointer;
    outline: none;
}
.item-card:focus {
    box-shadow: 0 0 0 3px rgba(59,130,246,0.2);
}

.item-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 12px;
}
.item-name {
    margin: 0;
    font-size: 1.05rem;
    font-weight: 600;
    color: #111827;
}

.toggle-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f3f4f6;
    border: 1px solid transparent;
    padding: 6px 10px;
    border-radius: 6px;
    font-size: 0.9rem;
    cursor: pointer;
}
.toggle-btn:hover { background: #e5e7eb; }
.toggle-btn:active { transform: translateY(1px); }

.chev {
    width: 16px;
    height: 16px;
    transition: transform 0.2s ease;
}
.toggle-btn[aria-pressed="true"] .chev {
    transform: rotate(180deg);
}

.details {
    margin-top: 10px;
    padding-top: 8px;
    border-top: 1px dashed #e6edf3;
    color: #374151;
}
.field {
    margin: 6px 0;
    font-size: 0.95rem;
}

.fade-enter-active, .fade-leave-active {
    transition: opacity 160ms ease, transform 160ms ease;
}
.fade-enter-from, .fade-leave-to {
    opacity: 0;
    transform: translateY(-6px);
}
</style>

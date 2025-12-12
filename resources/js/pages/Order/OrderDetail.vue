
<template>
    <div class="item-card">
        <div class="item-header">
            <h2 class="item-name">Order #{{ order.id }}</h2>
                  <span class="text-black"> - {{ order.status }}</span>
            <button
                class="toggle-btn"
                @click="toggle"
            >
                <span>{{ open ? 'Hide' : 'Show' }} Details</span>
                <svg
                    class="chev"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                >
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>
        <transition name="fade">
            <div v-if="open" class="details">
                <div class="field"><strong>Customer:</strong> {{ order.customer.fname }}</div>
                <div class="field"><strong>Total Amount:</strong> ${{ order.totalcost.toFixed(2) }}</div>
                <div class="field"><strong>Status:</strong> {{ order.status }}</div>
                <button @click="openModal(order.customer.id)">View Customer Details</button>

            </div>
        </transition>
    </div>
</template>

<script setup lang="ts">
import { ref } from 'vue'

const props =defineProps({
    order: {
        type: Object,
        required: true
    }

})

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

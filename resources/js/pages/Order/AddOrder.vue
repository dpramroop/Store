<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref, defineProps,defineEmits } from 'vue';
import {store} from '@/actions/App/Http/Controllers/ItemController';

// Dialog visibility
const showDialog = ref(false)

// Form state

const props=defineProps<{
    items:any
    customer:any
}>()

const barcode=ref('')

const categoryOptions = new Set (props.items.map((item: any) => item.category));
const emit = defineEmits<{ (e: 'close-ordermodal', item: any): void

 }>()
const form = useForm({
  name: '',
  description: '',
  brand: '',
  category: '',
  quantity: '',
  price: '',

})



// const form = reactive({
//   name: '',
//   description: '',
//   brand: '',
//   category: '',
//   stockquantity: '',
//   attributes: [] as Attribute[]
// })



// Add attribute


// Submit form
function closeModal()
{
    emit('close-ordermodal','')
}
function submitForm() {
  if (!form.name.trim()) {
    alert('Item name is required.')
    return
  }

   form.post(store().url, {
   onSuccess: ({ }) => {
    console.log('Item successfully submitted:', { ...form })
  emit('close-ordermodal', form.data())
    form.reset() // ✅ reset only after success
      showDialog.value = false

},
    onError: (errors) => {
      console.error('Validation errors:', errors)
    }
  })

  console.log('Submitting item:', { ...form })

  // Reset form
//   Object.assign(form, {
//     name: '',
//     description: '',
//     brand: '',
//     category: '',
//     stock_quantity: '',
//     attributes: []
//   })

  showDialog.value = false // Close modal after submit
}
</script>

<template>
  <div>
    <!-- Button to open modal -->
    <!-- <button @click="showDialog = true">Order</button> -->

    <!-- Modal -->
    <Dialog  class="modal-overlay">
      <div class="modal-content">
        <h1>Add Order</h1>
        <h1>HELLLOO</h1>
        <h1>{{ customer.fname }}</h1>
        <Form @submit.prevent="submitForm"  class="form">
           <input type="text" v-model="barcode" placeholder="FILL IN Barcode or Name">
            <div class="field grid grid-cols-4 gap-4">
                <button type="button" class="border bg-blue-800" v-for="category in categoryOptions" :key="category">
                    {{ category }}
                </button>
            </div>

          <div class="actions">
            <button type="submit">Save Item</button>
            <button type="button" @click="closeModal">Cancel</button>
          </div>
        </Form>
      </div>
    </Dialog>
  </div>
</template>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  background: rgba(0, 0, 0, 0.4);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 50;
}

.modal-content {
  background: white;
  padding: 20px;
  border-radius: 8px;
  width: 650px;
  max-height: 80vh;
  overflow-y: auto;
}

/* Keep your existing form styles */
.field {
  margin-bottom: 12px;
}

.field label {
  display: block;
  font-weight: 600;
  margin-bottom: 6px;
}

.field input,
.field textarea {
  width: 100%;
  padding: 8px;
  box-sizing: border-box;
}

.attributes {
  margin-top: 18px;
  margin-bottom: 12px;
}

.add-attribute {
  display: flex;
  gap: 8px;
  margin-bottom: 8px;
}

.attribute-list {
  list-style: none;
  padding: 0;
  margin: 0;
}

.attribute-item {
  display: flex;
  align-items: center;
  gap: 8px;
  padding: 6px 0;
  border-bottom: 1px solid #eee;
}

.attribute-item .remove {
  margin-left: auto;
  background: transparent;
  border: 1px solid #ddd;
  padding: 4px 8px;
  cursor: pointer;
}
.border-b-blue-800 {
    border-bottom-color: var(--color-blue-800) /* oklch(42.4% 0.199 265.638) = #193cb8 */;
}

.actions {
  margin-top: 16px;
  display: flex;
  justify-content: flex-end;
  gap: 8px;
}
</style>

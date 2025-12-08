<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref, defineEmits } from 'vue';
import {store} from '@/actions/App/Http/Controllers/CustomerController';
// Dialog visibility
const showDialog = ref(false)

// Form state


const emit = defineEmits<{ (e: 'customer-added', item: any): void }>()
const form = useForm({
  fname: '',
  lname: '',
  email: '',
  contact_no: '',
  address:'',
  city:'',
  direction:''
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
function submitForm() {
  if (!form.fname.trim()) {
    alert('Name is required.')
    return
  }

   form.post(store().url, {
   onSuccess: ({ }) => {
    console.log('Customer successfully submitted:', { ...form })
  emit('customer-added', form.data())
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
    <button @click="showDialog = true">Add Customer</button>

    <!-- Modal -->
    <Dialog v-if="showDialog" @close="showDialog = false" class="modal-overlay">
      <div class="modal-content">
        <h1>Add Customer</h1>

        <Form @submit.prevent="submitForm"  class="form">
          <div class="field">
            <label for="name">First Name</label>
            <input id="name" v-model="form.fname" type="text" required />
          </div>

          <div class="field">
            <label for="lname">Last Name</label>
            <input id="lname" v-model="form.lname" rows="4" required/>
          </div>

          <div class="field">
            <label for="email">Email</label>
            <input id="email" v-model="form.email" type="email" required />
          </div>

          <div class="field">
            <label for="contact_no">Contact Number</label>
            <input id="contact_no" v-model="form.contact_no" type="text" required />
          </div>

           <div class="field">
            <label for="address">Address</label>
            <textarea id="address" v-model="form.address" rows="4"></textarea>
          </div>
          
           <div class="field">
            <label for="city">City</label>
            <input id="city" v-model="form.city" type="text" required />
          </div>

          <div class="field">
            <label for="direction">Direction</label>
            <input id="direction" v-model="form.direction" type="text" required />
          </div>

          <div class="actions">
            <button type="submit">Save Customer</button>
            <button type="button" @click="showDialog = false">Cancel</button>
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

.actions {
  margin-top: 16px;
  display: flex;
  justify-content: flex-end;
  gap: 8px;
}
</style>

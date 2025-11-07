<script setup lang="ts">
import { ref, reactive, computed } from 'vue'

// Dialog visibility
const showDialog = ref(false)

// Form state
interface Attribute {
  name: string
  value: string
}

const form = reactive({
  name: '',
  description: '',
  brand: '',
  category: '',
  attributes: [] as Attribute[]
})

const attr = reactive<Attribute>({
  name: '',
  value: ''
})

const canAdd = computed(() => attr.name.trim() !== '' && attr.value.trim() !== '')

// Add attribute
function addAttribute() {
  const name = attr.name.trim()
  const value = attr.value.trim()
  if (!name) return
  form.attributes.push({ name, value })
  attr.name = ''
  attr.value = ''
}

// Remove attribute
function removeAttribute(index: number) {
  form.attributes.splice(index, 1)
}

// Submit form
function submitForm() {
  if (!form.name.trim()) {
    alert('Item name is required.')
    return
  }

  console.log('Submitting item:', { ...form })

  // Reset form
  Object.assign(form, {
    name: '',
    description: '',
    brand: '',
    category: '',
    attributes: []
  })

  showDialog.value = false // Close modal after submit
}
</script>

<template>
  <div>
    <!-- Button to open modal -->
    <button @click="showDialog = true">Add Item</button>

    <!-- Modal -->
    <Dialog v-if="showDialog" @close="showDialog = false" class="modal-overlay">
      <div class="modal-content">
        <h1>Add Item</h1>

        <form @submit.prevent="submitForm" class="form">
          <div class="field">
            <label for="name">Name</label>
            <input id="name" v-model="form.name" type="text" required />
          </div>

          <div class="field">
            <label for="description">Description</label>
            <textarea id="description" v-model="form.description" rows="4"></textarea>
          </div>

          <div class="field">
            <label for="brand">Brand</label>
            <input id="brand" v-model="form.brand" type="text" />
          </div>

          <div class="field">
            <label for="category">Category</label>
            <input id="category" v-model="form.category" type="text" />
          </div>

          <section class="attributes">
            <h2>Attributes</h2>

            <div class="add-attribute">
              <input
                placeholder="Attribute name"
                v-model="attr.name"
                @keyup.enter="addAttribute"
                type="text"
              />
              <input
                placeholder="Attribute value"
                v-model="attr.value"
                @keyup.enter="addAttribute"
                type="text"
              />
              <button type="button" @click="addAttribute" :disabled="!canAdd">
                Add Attribute
              </button>
            </div>

            <ul class="attribute-list">
              <li
                v-for="(a, i) in form.attributes"
                :key="i"
                class="attribute-item"
              >
                <span class="attr-label">{{ a.name }}:</span>
                <span class="attr-value">{{ a.value }}</span>
                <button type="button" class="remove" @click="removeAttribute(i)">
                  Remove
                </button>
              </li>
              <li v-if="form.attributes.length === 0" class="empty">
                No attributes added
              </li>
            </ul>
          </section>

          <div class="actions">
            <button type="submit">Save Item</button>
            <button type="button" @click="showDialog = false">Cancel</button>
          </div>
        </form>
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
  width: 500px;
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

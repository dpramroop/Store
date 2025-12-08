<script setup lang="ts">
import { useForm } from '@inertiajs/vue3'
import { ref, defineProps,defineEmits } from 'vue';
import jsPDF from "jspdf";
import {store} from '@/actions/App/Http/Controllers/OrderController';
// import { index } from '@/actions/Laravel/Fortify/Http/Controllers/RecoveryCodeController';

import { autoTable } from 'jspdf-autotable'
import { fontStyle } from 'html2canvas/dist/types/css/property-descriptors/font-style';



interface OrdersInterface
{
   item:any,
   totalcost:number,
   quantity:number
}

// Dialog visibility
const showDialog = ref(false)
const quantity=ref(1)
const result:any=ref()
// const total:any=ref([])

// const totalcost:any=ref(0)
// Form state
// const orders:any=ref([])
const props=defineProps<{
    items:any
    customer:any
    couriers:any
}>()
const items= ref([...props.items])
const listeditem:any=ref([])
const barcode=ref('')
const ifcourier= ref(false)


const categoryOptions = new Set (props.items.map((item: any) => item.category));
const emit = defineEmits<{ (e: 'close-ordermodal', item: any): void

 }>()
const form = useForm({
customer_id:props.customer.id,
totalprice:0,
status:'placed',
orders:[] as OrdersInterface[],
courierpick: null as any | null
})

function addquantity(index:any)
{
    quantity.value=form.orders[index].quantity+1
    form.orders[index].totalcost= form.orders[index].item.price *quantity.value
    form.orders[index].quantity=quantity.value
resettotal()


}
function removequantity(index:any)
{

    quantity.value=form.orders[index].quantity-1
    form.orders[index].totalcost= form.orders[index].item.price *quantity.value
    form.orders[index].quantity=quantity.value
       resettotal()
}

function categoryChosen(categoryOption:any)
{
  listeditem.value = items.value.filter((i:any)=> i.category==categoryOption)
}


function removefromcart(index:any)
{

     form.orders.splice(index,1)
   // orders.value.push({"item":item,"quantity":quantity.value,"total":item.price * quantity.value})
    // total.value.push(item.price)
courierChoice()

}



function cart(item:any)
{
  const exists = form.orders.some(order => order.item.id === item.id);

  if (exists) {
    alert("Item already in cart!");
    return;
  }


 const totalcost=item.price
    const quantity=1
     form.orders.push({item, totalcost, quantity})
   // orders.value.push({"item":item,"quantity":quantity.value,"total":item.price * quantity.value})
    // total.value.push(item.price)
   courierChoice()
}
function resettotal()
{
form.totalprice=0
       form.orders.forEach((x:any) => {
    form.totalprice +=  parseFloat(x.totalcost);
    })
}



function courierChoice()
{   const courier= form.courierpick
    resettotal()
  if (ifcourier.value && courier) {
    form.totalprice += parseFloat(courier.cost)
    }
}
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

const generatePdf = async () => {
  const pdf = new jsPDF();

  // Customer name

  pdf.setFont("Helvetica", "bold"); // set font family and style
  pdf.setFontSize(12); // set font size
  pdf.text(`${props.customer.fname} ${props.customer.lname}`, 12, 20);
  pdf.text(`${props.customer.contact_no}`, 12, 25);

  // Convert form.orders → AutoTable body rows
  const rows = form.orders.map(order => [
    order.item.name,
    order.quantity,
    order.totalcost
  ]);
  if(form.courierpick)
  {
    rows.push([ '',{content: `COURIER`, styles: { fontStyle: 'bold'}},{ content:`${form.courierpick.cost}`, styles: {  fontStyle: 'bold'}}])
  }
  rows.push([ '',{content: `TOTAL`, styles: {  fontStyle: 'bold'}},{ content:`${form.totalprice}`, styles: {fontStyle: 'bold'}}])
  // Add table to PDF
  autoTable(pdf, {
    startY: 40,
    head: [['ITEM', 'QUANTITY', 'COST']],
    body: rows
  });




  pdf.save("document.pdf");
};
function submitForm() {
if(form.orders.length==0)
{
    alert("MUST INCLUDE AN ITEM")
    return
}


   form.post(store().url, {
   onSuccess: ({ }) => {
    console.log('Order successfully submitted:', { ...form })
   generatePdf()

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
        <div class="flex grid-cols-2 gap-4">

        <div>

           <input type="text" v-model="barcode" placeholder="FILL IN Barcode or Name">
            <div class="field grid grid-cols-4 gap-4">
                <button @click="categoryChosen(category)" type="button" class="border bg-red-800" v-for="category,index in categoryOptions" :key="index">
                    {{ category }}
                </button>
            </div>
   <div class="field grid grid-cols-4 gap-4">
                <button @click="cart(li)" type="button" class="border bg-blue-300" v-for="li in listeditem" :key="li">
                    {{ li.name }}
                </button>
            </div>



</div>



   <div class="">
     <Form @submit.prevent="submitForm"  class="form">
            <div class="flex grid-cols-3 gap-3" v-for="(order,index) in form.orders" :index="index" :key="index">

   <button type="button" @click="removefromcart(index)">--</button>
            <h2>{{order.item.name}}</h2>
             <h2>{{order.totalcost}}</h2>
             <h2>{{order.quantity}}</h2>


              <button type="button" @click="removequantity(index)">-</button>

              <button type="button" @click="addquantity(index)">+</button>
             </div>
              <input type="checkbox" v-model="ifcourier"  @click="resettotal"/>
             <div v-if="ifcourier" >
             <select v-model="form.courierpick" @change="courierChoice">
                <option v-for="(courier,index) in couriers" :index="index" :key="courier.id" :value="courier">
                    {{ courier.fname }} {{ courier.lname }}
                </option>
             </select>
             </div>
             <div >

                <h1 class="">TOTAL ${{form.totalprice}} </h1>
             </div>



          <div class="actions">
            <button type="submit">Save Item</button>
            <button type="button" @click="closeModal">Cancel</button>
          </div>
         </Form>
        </div>


    </div>
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

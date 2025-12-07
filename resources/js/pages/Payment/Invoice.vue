<script setup lang="ts">
import jsPDF from "jspdf";

import { ref} from "vue";

const refname = ref<HTMLElement | null>(null);

const generatePdf = async () => {


  // 4️⃣ Add to PDF
  const pdf = new jsPDF();
  pdf.text("hello",45,55)

  // 5️⃣ Save PDF
  pdf.save("document.pdf");


};
</script>

<template class="whole">
  <button @click="generatePdf">Download PDF</button>

  <div ref="refname" class="pdf-wrapper" style="background:white; color:black;">
  <h1>Hello, my name is Darrin</h1>
  <p>This content will appear in PDF.</p>
</div>
</template>
<style>
    .whole,.pdf-wrapper, .pdf-wrapper * {
  all: unset; /* Remove inherited Tailwind styles */
  display: revert; /* Keep normal layout */
  background-color: rgb(255,255,255);
  color: rgb(0,0,0);
}
</style>

<script setup lang="ts">
import html2pdf from 'html2pdf.js'
import { ref } from 'vue'

const pdfContent = ref<HTMLElement | null>(null)

const exportToPDF = () => {
  const element = pdfContent.value;
  if (!element) return;
alert("hello")
  const options = {
    filename: 'document.pdf',
    image: { type: 'jpeg', quality: 0.98 },
    html2canvas: { scale: 2 },
    jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
  } as const;

  html2pdf()
    .set(options)
    .from(element)
    .save();
};
</script>

<template>
  <div>
    <div ref="pdfContent" class="pdf-content-wrapper">
      <h1>My PDF Report</h1>
      <p>This content will be included in the PDF document.</p>
    </div>

    <button @click="exportToPDF">Download PDF</button>
  </div>
</template>

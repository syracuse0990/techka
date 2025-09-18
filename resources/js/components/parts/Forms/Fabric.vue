<template>
  <div class="flex items-center justify-center">
    <canvas ref="fabricCanvas" :width="box_width" :height="box_height"></canvas>

  </div>
  <button @click="printCanvas" class="mt-4 px-4 py-2 bg-blue-500 text-white rounded">
      Print Canvas
    </button>
</template>

<script setup>
import { ref, onMounted, watch } from 'vue';

const props = defineProps({
  fields: {
    type: Array,
    required: true,
    default: () => [],
  },
  box_width:{
    type: Number,
    default: 1200,
  },
  box_height:{
    type: Number,
    default: 600,
  },
  backgroundImage: {
    type: String,
    default: null,
  },
});

const emit = defineEmits(["update-text-box-data"]);

const fabricCanvas = ref(null);
let canvas;
const textBoxData = ref([]);

function emitTextBoxData() {
  emit("update-text-box-data", textBoxData.value);
}

onMounted(() => {
  canvas = new fabric.Canvas(fabricCanvas.value);

  canvas.on('object:modified', (event) => {
    const modifiedObject = event.target;

    if (modifiedObject && modifiedObject.type === 'text') {
      const textBoxInfo = {
        id: modifiedObject.id,
        text: modifiedObject.text,
        left: modifiedObject.left,
        top: modifiedObject.top,
        width: modifiedObject.width,
        height: modifiedObject.height,
        scaleX: modifiedObject.scaleX,
        scaleY: modifiedObject.scaleY,
      };

      const index = textBoxData.value.findIndex((item) => item.id === modifiedObject.id);
      if (index !== -1) {
        textBoxData.value[index] = textBoxInfo;
      } else {
        textBoxData.value.push(textBoxInfo);
      }
      emitTextBoxData();
      console.log('Updated Text Box Data:', textBoxData.value);
    }
  });

  var deleteIcon = "data:image/svg+xml,%3C%3Fxml version='1.0' encoding='utf-8'%3F%3E%3C!DOCTYPE svg PUBLIC '-//W3C//DTD SVG 1.1//EN' 'http://www.w3.org/Graphics/SVG/1.1/DTD/svg11.dtd'%3E%3Csvg version='1.1' id='Ebene_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' width='595.275px' height='595.275px' viewBox='200 215 230 470' xml:space='preserve'%3E%3Ccircle style='fill:%23F44336;' cx='299.76' cy='439.067' r='218.516'/%3E%3Cg%3E%3Crect x='267.162' y='307.978' transform='matrix(0.7071 -0.7071 0.7071 0.7071 -222.6202 340.6915)' style='fill:white;' width='65.545' height='262.18'/%3E%3Crect x='266.988' y='308.153' transform='matrix(0.7071 0.7071 -0.7071 0.7071 398.3889 -83.3116)' style='fill:white;' width='65.544' height='262.179'/%3E%3C/g%3E%3C/svg%3E";
  var img = new Image();
  img.src = deleteIcon;

  fabric.Object.prototype.controls.deleteControl = new fabric.Control({
    x: 0.5,
    y: -0.5,
    offsetY: 16,
    cursorStyle: 'pointer',
    mouseUpHandler: deleteObject,
    render: renderIcon,
    cornerSize: 16
  });

  function deleteObject(eventData, transform) {
    var target = transform.target;
    var canvas = target.canvas;
    canvas.remove(target);
    canvas.requestRenderAll();
  }

  function renderIcon(ctx, left, top, styleOverride, fabricObject) {
    var size = this.cornerSize;
    ctx.save();
    ctx.translate(left, top);
    ctx.rotate(fabric.util.degreesToRadians(fabricObject.angle));
    ctx.drawImage(img, -size / 2, -size / 2, size, size);
    ctx.restore();
  }


});

function setCanvasBackground(imageUrl) {
  if (canvas) {
    fabric.Image.fromURL(imageUrl, (img) => {

      const scaleX = canvas.width / img.width;
      const scaleY = canvas.height / img.height;
      const scale = Math.min(scaleX, scaleY);

      img.set({
        scaleX: scale,
        scaleY: scale,
        originX: 'left',
        originY: 'top',
      });


      canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
        crossOrigin: 'anonymous',
      });
    });
  }
}

watch(() => props.fields, (newFields, oldFields) => {
  if (canvas) {
    // Get existing text box IDs on the canvas
    const existingIds = canvas.getObjects().map((obj) => obj.id);

    // Add new text boxes for fields that don't already exist on the canvas
    newFields.forEach((field) => {
      if (!existingIds.includes(field.id)) {
        const text = new fabric.Text(field.title, {
          left: 50,
          top: 50 + (canvas.getObjects().length * 30), // Adjust top position to avoid overlap
          fontSize: 22,
          fill: 'green',
          id: field.id, // Add a custom ID to identify the text box
        });
        canvas.add(text);

        // Initialize text box data
        textBoxData.value.push({
          id: field.id,
          text: field.title,
          left: text.left,
          top: text.top,
          width: text.width,
          height: text.height,
          scaleX: text.scaleX,
          scaleY: text.scaleY,
        });
      }
    });

    canvas.requestRenderAll();
  }
}, { deep: true });
watch(() => props.box_width, (newWidth) => {
  if (canvas) {
    canvas.setWidth(newWidth);
    canvas.requestRenderAll();
  }
});

watch(() => props.box_height, (newHeight) => {
  if (canvas) {
    canvas.setHeight(newHeight);
    canvas.requestRenderAll();
  }
});

watch(
  () => props.backgroundImage,
  (newImage) => {
    console.log('Background Image URL:', newImage);
    if (newImage) {
      setCanvasBackground(newImage);
    }
  }
);

function printCanvas() {
  // Get the canvas content as a data URL
  const dataUrl = canvas.toDataURL({
    format: 'png',
    quality: 1.0,
  });

  // Create a new window for printing
  const printWindow = window.open('', '', 'width=800,height=600');
  printWindow.document.open();

  // Calculate the print size in inches based on 192 DPI
  const printWidthInches = props.box_width / 192; // Convert pixels to inches
  const printHeightInches = props.box_height / 192; // Convert pixels to inches

  // Set the print size in the CSS
  const printStyle = `
    <style>
      @media print {
        @page {
          size: ${printWidthInches}in ${printHeightInches}in;
          margin: 0;
        }
        body {
          margin: 0;
          padding: 0;
        }
        img {
          width: 100%;
          height: auto;
          max-width: ${printWidthInches}in;
          max-height: ${printHeightInches}in;
          object-fit: contain;
        }
      }
    </style>
  `;

  // Write the content to the new window
  printWindow.document.write(`
    <!DOCTYPE html>
    <html>
      <head>
        <title>Print Canvas</title>
        ${printStyle}
      </head>
      <body style="text-align:center;">
        <img src="${dataUrl}" alt="Canvas Image" />
      </body>
    </html>
  `);

  printWindow.document.close();
  printWindow.focus();

  // Trigger the print dialog
  printWindow.print();
  printWindow.close();
}

</script>

<style scoped>
canvas {
  border: 2px dashed #ccc;
  border-radius: 10px;
}
</style>

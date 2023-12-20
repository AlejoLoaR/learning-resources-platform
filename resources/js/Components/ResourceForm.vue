<script setup>

import axios from "axios";
import { ref, onMounted } from "vue";

let title = ref("");
let description = ref("");
let link = ref("");
let categories = ref([]);
let category_id = ref(null);

onMounted(()=>{
  axios.get("/api/categories").then((response)=>{
    categories.value = response.data;
  });
});

async function createResource() {
  try {
    const response = await axios.post("api/resources", {
      title: title.value,
      description: description.value,
      link: link.value,
      category_id: category_id.value,
    }).then((response)=>{
      window.location.href ="/";
    });

    console.log("El recurso se creó en el sistema:", response.data);
  } catch (error) {
    if (error.response) {
      console.error("El servidor muestra un error:", error.response.data);
      console.error("Status code:", error.response.status);
    } else if (error.request) {
      console.error("No se obtuvo ninguna respuesta del servidor:", error.request);
    } else {
      console.error("Error al hacer la petición :", error.message);
    }
  }
}

</script>
<template>
    <div class="m-8">
        <input type="text" v-model="title" />
        <input type="text" v-model="description" />
        <input type="text" v-model="link" />
        <select v-model="category_id">
          <option v-for="category in categories" :key="category.id" :value="category.id">
            {{ category.name }}
          </option>
        </select>
        <button @click="createResource">Crear recurso</button>
    </div>
</template>
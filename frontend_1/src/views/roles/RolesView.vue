<script setup>
import { onMounted, ref } from 'vue'
import { roleService } from '@/services/api'

const roles   = ref([])
const loading = ref(false)
const error   = ref('')

async function cargar() {
  loading.value = true
  error.value   = ''
  try { const { data } = await roleService.getAll(); roles.value = data }
  catch { error.value = 'No se pudieron cargar los roles.' }
  finally { loading.value = false }
}

onMounted(cargar)
</script>

<template>
  <section class="page">
    <h2>Roles del sistema</h2>
    <p class="sub">Permisos definidos por ESPE DECC.</p>

    <p v-if="error" class="error">{{ error }}</p>
    <p v-if="loading" class="muted">Cargando...</p>

    <div class="grid">
      <article v-for="r in roles" :key="r.id" class="card">
        <h3>{{ r.nombre }}</h3>
        <p>{{ r.descripcion || 'Sin descripcion.' }}</p>
      </article>
    </div>
  </section>
</template>

<style scoped>
.page { max-width: 900px; margin: 2rem auto; padding: 0 1rem; }
h2 { color: #1a6b8a; margin: 0 0 0.25rem; }
.sub { color: #888; margin: 0 0 1.5rem; }
.error { color: #c0392b; }
.muted { color: #aaa; }
.grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1rem; }
.card {
  background: #fff; border-radius: 10px;
  padding: 1.25rem 1rem;
  border: 1px solid #e0eaf0;
  box-shadow: 0 2px 8px rgba(0,0,0,0.06);
}
.card h3 { margin: 0 0 0.5rem; color: #1a6b8a; }
.card p  { margin: 0; color: #555; font-size: 0.875rem; }
</style>

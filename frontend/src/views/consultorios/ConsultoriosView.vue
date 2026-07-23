<script setup>
import { ref, onMounted } from 'vue'
import CrudTable from '@/components/CrudTable.vue'
import { consultorioService } from '@/services/api'

const rows = ref([])
const loading = ref(false)
const error = ref(null)

const columns = [
  { key: 'id',        label: 'ID' },
  { key: 'piso',      label: 'Piso' },
  { key: 'estado',    label: 'Estado' },
  { key: 'direccion', label: 'Dirección' },
]

async function cargar() {
  loading.value = true; error.value = null
  try { const { data } = await consultorioService.getAll(); rows.value = data }
  catch { error.value = 'No se pudo cargar los consultorios.' }
  finally { loading.value = false }
}

async function eliminar(row) {
  if (!confirm(`¿Eliminar el consultorio del ${row.piso}?`)) return
  try { await consultorioService.delete(row.id); rows.value = rows.value.filter(r => r.id !== row.id) }
  catch { alert('No se pudo eliminar.') }
}

onMounted(cargar)
</script>

<template>
  <CrudTable
    titulo="Consultorios"
    subtitulo="Gestiona los consultorios del centro de salud."
    :columns="columns" :rows="rows" :loading="loading" :error="error"
    create-path="/consultorios/crear" create-label="Nuevo Consultorio"
    :edit-path="row => `/consultorios/${row.id}/editar`"
    @delete="eliminar"
  >
    <template #icon>🏨</template>
  </CrudTable>
</template>
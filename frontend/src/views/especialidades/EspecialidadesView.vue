<script setup>
import { ref, onMounted } from 'vue'
import CrudTable from '@/components/CrudTable.vue'
import { especialidadService } from '@/services/api'

const rows = ref([])
const loading = ref(false)
const error = ref(null)

const columns = [
  { key: 'id',     label: 'ID' },
  { key: 'nombre', label: 'Nombre' },
]

async function cargar() {
  loading.value = true
  error.value = null
  try { const { data } = await especialidadService.getAll(); rows.value = data }
  catch { error.value = 'No se pudo cargar las especialidades.' }
  finally { loading.value = false }
}

async function eliminar(row) {
  if (!confirm(`¿Eliminar la especialidad "${row.nombre}"?`)) return
  try { await especialidadService.delete(row.id); rows.value = rows.value.filter(r => r.id !== row.id) }
  catch { alert('No se pudo eliminar.') }
}

onMounted(cargar)
</script>

<template>
  <CrudTable
    titulo="Especialidades"
    subtitulo="Gestiona las especialidades médicas disponibles."
    :columns="columns"
    :rows="rows"
    :loading="loading"
    :error="error"
    create-path="/especialidades/crear"
    create-label="Nueva Especialidad"
    :edit-path="row => `/especialidades/${row.id}/editar`"
    @delete="eliminar"
  >
    <template #icon>🏥</template>
  </CrudTable>
</template>
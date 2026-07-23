<script setup>
import { ref, onMounted } from 'vue'
import CrudTable from '@/components/CrudTable.vue'
import { medicoService } from '@/services/api'

const rows = ref([])
const loading = ref(false)
const error = ref(null)

const columns = [
  { key: 'cedula',  label: 'Cédula' },
  { key: 'nombre',  label: 'Nombre' },
  { key: 'apellido',label: 'Apellido' },
  { key: 'correo',  label: 'Correo' },
  { key: 'esp',     label: 'Especialidad', render: row => row.especialidad?.nombre ?? '—' },
]

async function cargar() {
  loading.value = true; error.value = null
  try { const { data } = await medicoService.getAll(); rows.value = data }
  catch { error.value = 'No se pudo cargar los médicos.' }
  finally { loading.value = false }
}

async function eliminar(row) {
  if (!confirm(`¿Eliminar al médico ${row.nombre} ${row.apellido}?`)) return
  try { await medicoService.delete(row.id); rows.value = rows.value.filter(r => r.id !== row.id) }
  catch { alert('No se pudo eliminar.') }
}

onMounted(cargar)
</script>

<template>
  <CrudTable
    titulo="Médicos"
    subtitulo="Gestiona el personal médico del centro de salud."
    :columns="columns" :rows="rows" :loading="loading" :error="error"
    create-path="/medicos/crear" create-label="Nuevo Médico"
    :edit-path="row => `/medicos/${row.id}/editar`"
    @delete="eliminar"
  >
    <template #icon>👨‍⚕️</template>
  </CrudTable>
</template>
<script setup>
import { ref, onMounted } from 'vue'
import CrudTable from '@/components/CrudTable.vue'
import { citaMedicaService } from '@/services/api'

const rows = ref([])
const loading = ref(false)
const error = ref(null)

const columns = [
  { key: 'id',       label: 'ID' },
  { key: 'paciente', label: 'Paciente',  render: r => r.paciente  ? `${r.paciente.nombre} ${r.paciente.apellido}` : r.paciente_id },
  { key: 'medico',   label: 'Médico',    render: r => r.medico    ? `${r.medico.nombre} ${r.medico.apellido}` : r.medico_id },
  { key: 'Dia_Semana',label: 'Día' },
  { key: 'hora',     label: 'Hora' },
  { key: 'estado',   label: 'Estado' },
]

async function cargar() {
  loading.value = true; error.value = null
  try { const { data } = await citaMedicaService.getAll(); rows.value = data }
  catch { error.value = 'No se pudo cargar las citas.' }
  finally { loading.value = false }
}

async function eliminar(row) {
  if (!confirm(`¿Eliminar la cita #${row.id}?`)) return
  try { await citaMedicaService.delete(row.id); rows.value = rows.value.filter(r => r.id !== row.id) }
  catch { alert('No se pudo eliminar.') }
}

onMounted(cargar)
</script>

<template>
  <CrudTable
    titulo="Citas Médicas"
    subtitulo="Gestiona las citas médicas programadas."
    :columns="columns" :rows="rows" :loading="loading" :error="error"
    create-path="/citas/crear" create-label="Nueva Cita"
    :edit-path="row => `/citas/${row.id}/editar`"
    @delete="eliminar"
  >
    <template #icon>📅</template>
  </CrudTable>
</template>
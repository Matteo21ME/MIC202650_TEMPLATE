<script setup>
import { ref, onMounted } from 'vue'
import CrudTable from '@/components/CrudTable.vue'
import { pacienteService } from '@/services/api'

const rows    = ref([])
const loading = ref(false)
const error   = ref(null)

const columns = [
  { key: 'cedula',           label: 'Cedula' },
  { key: 'nombre',           label: 'Nombre' },
  { key: 'apellido',         label: 'Apellido' },
  { key: 'fecha_nacimiento', label: 'Fecha Nac.' },
  { key: 'telefono',         label: 'Telefono' },
  { key: 'correo',           label: 'Correo' },
]

async function cargar() {
  loading.value = true; error.value = null
  try { const { data } = await pacienteService.getAll(); rows.value = data }
  catch { error.value = 'No se pudo cargar los pacientes.' }
  finally { loading.value = false }
}

async function eliminar(row) {
  if (!confirm('Eliminar paciente ' + row.nombre + '?')) return
  try { await pacienteService.delete(row.id); rows.value = rows.value.filter(r => r.id !== row.id) }
  catch { alert('No se pudo eliminar.') }
}

onMounted(cargar)
</script>

<template>
  <CrudTable
    titulo="Pacientes"
    subtitulo="Gestiona y organiza la informacion de pacientes."
    :columns="columns" :rows="rows" :loading="loading" :error="error"
    create-path="/pacientes/crear" create-label="Nuevo Paciente"
    :edit-path="row => '/pacientes/' + row.id + '/editar'"
    @delete="eliminar"
  >
    <template #icon>&#x1F465;</template>
  </CrudTable>
</template>
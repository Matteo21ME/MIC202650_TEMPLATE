<script setup>
import { onMounted, ref } from 'vue'
import CrudTable from '@/components/CrudTable.vue'
import { userService } from '@/services/api'

const rows    = ref([])
const loading = ref(false)
const error   = ref('')

const columns = [
  { key: 'id',    label: 'ID' },
  { key: 'name',  label: 'Nombre' },
  { key: 'email', label: 'Correo' },
  { key: 'role',  label: 'Rol', render: (r) => r.role?.nombre ?? 'Sin rol' },
]

async function cargar() {
  loading.value = true; error.value = ''
  try { const { data } = await userService.getAll(); rows.value = data }
  catch { error.value = 'No se pudieron cargar los usuarios.' }
  finally { loading.value = false }
}

async function eliminar(row) {
  if (!confirm(`Eliminar usuario "${row.name}"?`)) return
  try { await userService.delete(row.id); rows.value = rows.value.filter(u => u.id !== row.id) }
  catch { alert('No se pudo eliminar el usuario.') }
}

onMounted(cargar)
</script>

<template>
  <CrudTable
    titulo="Usuarios"
    subtitulo="Gestion de cuentas de acceso al sistema."
    :columns="columns" :rows="rows" :loading="loading" :error="error"
    create-path="/usuarios/crear" create-label="Nuevo Usuario"
    :edit-path="(row) => `/usuarios/${row.id}/editar`"
    @delete="eliminar"
  >
    <template #icon>&#x1F464;</template>
  </CrudTable>
</template>

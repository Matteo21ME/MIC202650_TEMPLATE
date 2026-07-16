<script setup>
import { ref, computed } from 'vue'
import { RouterLink } from 'vue-router'

const props = defineProps({
  titulo:      { type: String, required: true },
  subtitulo:   { type: String, default: 'Gestiona el listado de registros.' },
  columns:     { type: Array,  required: true }, // [{ key, label, render? }]
  rows:        { type: Array,  default: () => [] },
  loading:     { type: Boolean, default: false },
  error:       { type: String,  default: null },
  createPath:  { type: String,  required: true },
  createLabel: { type: String,  default: 'Nuevo' },
  editPath:    { type: Function, required: true }, // (row) => '/ruta/id/editar'
})

const emit = defineEmits(['delete'])

const buscar = ref('')

const rowsFiltrados = computed(() => {
  if (!buscar.value.trim()) return props.rows
  const q = buscar.value.toLowerCase()
  return props.rows.filter(row =>
    props.columns.some(col => {
      const val = col.render ? col.render(row) : row[col.key]
      return String(val ?? '').toLowerCase().includes(q)
    })
  )
})

function getCell(row, col) {
  return col.render ? col.render(row) : (row[col.key] ?? '—')
}
</script>

<template>
  <div class="page">
    <!-- Page header -->
    <div class="page-header">
      <div class="d-flex align-items-center gap-3">
        <div class="header-icon"><slot name="icon">☰</slot></div>
        <div>
          <h2>{{ titulo }}</h2>
          <p>{{ subtitulo }}</p>
        </div>
      </div>
      <div class="header-right">
        <div class="search-wrap">
          <span class="search-icon"></span>
          <input v-model="buscar" type="text" placeholder="Buscar..." />
          <button v-if="buscar" @click="buscar = ''" class="clear-btn">✕</button>
        </div>
      </div>
    </div>

    <!-- Alert -->
    <div v-if="error" class="alert-error">{{ error }}</div>

    <!-- Card -->
    <div class="card">
      <div class="card-head">
        <div>
          <strong>Listado</strong>
          <span class="count">&nbsp;({{ rowsFiltrados.length }})</span>
        </div>
        <RouterLink :to="createPath" class="btn-primary">+ {{ createLabel }}</RouterLink>
      </div>

      <!-- Loading -->
      <div v-if="loading" class="estado">Cargando...</div>

      <!-- Table -->
      <div v-else class="table-wrap">
        <table>
          <thead>
            <tr>
              <th v-for="col in columns" :key="col.key">{{ col.label }}</th>
              <th class="th-actions">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="row in rowsFiltrados" :key="row.id">
              <td v-for="col in columns" :key="col.key">{{ getCell(row, col) }}</td>
              <td class="td-actions">
                <RouterLink :to="editPath(row)" class="btn-edit">Editar</RouterLink>
                <button @click="emit('delete', row)" class="btn-delete">Eliminar</button>
              </td>
            </tr>
            <tr v-if="rowsFiltrados.length === 0">
              <td :colspan="columns.length + 1" class="empty">No se encontraron registros.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<style scoped>
.page { max-width: 1200px; margin: 2rem auto; padding: 0 1.5rem; }

.page-header {
  background: #fff; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.07);
  padding: 1.25rem 1.5rem; margin-bottom: 1.5rem;
  display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 1rem;
}
.header-icon {
  width: 44px; height: 44px; border-radius: 50%; background: #1a6b8a; color: #fff;
  display: flex; align-items: center; justify-content: center; font-size: 1.25rem; flex-shrink: 0;
}
.page-header h2 { font-size: 1.4rem; font-weight: 700; color: #1a6b8a; margin: 0 0 0.15rem; }
.page-header p  { color: #777; margin: 0; font-size: 0.875rem; }
.header-right { display: flex; align-items: center; gap: 0.75rem; }

.search-wrap {
  display: flex; align-items: center; border: 1.5px solid #d0dde3;
  border-radius: 8px; overflow: hidden; background: #fff;
}
.search-icon { padding: 0 0.5rem 0 0.75rem; color: #999; }
.search-wrap input {
  border: none; outline: none; padding: 0.5rem 0.25rem; font-size: 0.9rem;
  width: 220px; background: transparent;
}
.clear-btn {
  background: none; border: none; cursor: pointer; padding: 0.4rem 0.6rem;
  color: #aaa; font-size: 0.85rem;
}
.clear-btn:hover { color: #555; }

.alert-error {
  background: #fde8e8; border: 1px solid #f5c6c6; color: #c0392b;
  padding: 0.75rem 1rem; border-radius: 8px; margin-bottom: 1rem;
}

.card { background: #fff; border-radius: 12px; box-shadow: 0 2px 12px rgba(0,0,0,0.08); overflow: hidden; }
.card-head {
  display: flex; justify-content: space-between; align-items: center;
  padding: 1rem 1.5rem; border-bottom: 1px solid #f0f0f0;
}
.card-head strong { font-size: 1rem; color: #333; }
.count { font-size: 0.875rem; color: #999; }

.btn-primary {
  background: #1a6b8a; color: #fff; text-decoration: none;
  padding: 0.55rem 1.15rem; border-radius: 8px; font-weight: 600; font-size: 0.875rem;
  transition: background 0.2s;
}
.btn-primary:hover { background: #135670; }

.estado { padding: 3rem; text-align: center; color: #aaa; }

.table-wrap { overflow-x: auto; }
table { width: 100%; border-collapse: collapse; }
thead { background: #1a6b8a; color: #fff; }
th { padding: 0.8rem 1rem; text-align: left; font-weight: 600; font-size: 0.8rem; white-space: nowrap; }
td { padding: 0.8rem 1rem; border-bottom: 1px solid #f5f5f5; font-size: 0.875rem; color: #333; }
tr:last-child td { border-bottom: none; }
tr:hover td { background: #f8fbfc; }
.th-actions, .td-actions { text-align: center; white-space: nowrap; }
.td-actions { display: flex; gap: 0.4rem; justify-content: center; }

.btn-edit {
  background: #f0a500; color: #fff; text-decoration: none;
  padding: 0.3rem 0.65rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600;
  white-space: nowrap;
}
.btn-edit:hover { background: #d4900a; }
.btn-delete {
  background: #e74c3c; color: #fff; border: none; cursor: pointer;
  padding: 0.3rem 0.65rem; border-radius: 6px; font-size: 0.8rem; font-weight: 600;
}
.btn-delete:hover { background: #c0392b; }
.empty { text-align: center; color: #aaa; padding: 3rem; }
</style>

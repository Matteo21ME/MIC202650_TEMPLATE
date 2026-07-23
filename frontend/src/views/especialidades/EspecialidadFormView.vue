<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import FormField from '@/components/FormField.vue'
import { especialidadService } from '@/services/api'

const router = useRouter()
const route  = useRoute()
const esEdicion = computed(() => !!route.params.id)

const form = ref({ nombre: '' })
const errores  = ref({})
const enviando = ref(false)
const cargando = ref(false)

async function cargar() {
  cargando.value = true
  try { const { data } = await especialidadService.getById(route.params.id); Object.assign(form.value, data) }
  catch { alert('No se pudo cargar.'); router.push('/especialidades') }
  finally { cargando.value = false }
}

async function enviar() {
  errores.value = {}; enviando.value = true
  try {
    esEdicion.value
      ? await especialidadService.update(route.params.id, form.value)
      : await especialidadService.create(form.value)
    router.push('/especialidades')
  } catch (e) {
    if (e.response?.status === 422) errores.value = e.response.data.errors ?? {}
    else alert('Error al guardar.')
  } finally { enviando.value = false }
}

onMounted(() => { if (esEdicion.value) cargar() })
</script>

<template>
  <div class="page">
    <div class="form-card">
      <div class="form-header">
        <h1>{{ esEdicion ? 'Editar Especialidad' : 'Nueva Especialidad' }}</h1>
        <RouterLink to="/especialidades" class="btn-back">← Volver</RouterLink>
      </div>
      <div v-if="cargando" class="estado">Cargando...</div>
      <form v-else @submit.prevent="enviar" novalidate>
        <div class="form-grid">
          <FormField label="Nombre" :error="errores.nombre" :full="true">
            <input v-model="form.nombre" type="text" maxlength="50" required :class="{ invalid: errores.nombre }" />
          </FormField>
        </div>
        <div class="form-footer">
          <p class="hint">Verifica los datos antes de guardar.</p>
          <button type="submit" class="btn-submit" :disabled="enviando">
            {{ enviando ? 'Guardando...' : (esEdicion ? 'Actualizar' : 'Crear Especialidad') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.page { max-width: 600px; margin: 2rem auto; padding: 0 1.5rem; }
.form-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,0.1); overflow: hidden; }
.form-header { background: #1a6b8a; color: #fff; padding: 1.25rem 1.75rem; display: flex; align-items: center; justify-content: space-between; }
.form-header h1 { font-size: 1.25rem; font-weight: 700; margin: 0; }
.btn-back { color: rgba(255,255,255,0.9); text-decoration: none; background: rgba(255,255,255,0.15); padding: 0.4rem 0.9rem; border-radius: 6px; font-size: 0.875rem; }
.btn-back:hover { background: rgba(255,255,255,0.25); }
.estado { padding: 3rem; text-align: center; color: #888; }
form { padding: 1.75rem; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
input, select { padding: 0.6rem 0.85rem; border: 1.5px solid #d0dde3; border-radius: 8px; font-size: 0.95rem; outline: none; width: 100%; transition: border 0.2s; }
input:focus, select:focus { border-color: #1a6b8a; box-shadow: 0 0 0 3px rgba(26,107,138,0.12); }
input.invalid, select.invalid { border-color: #e74c3c; }
.form-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid #eee; }
.hint { font-size: 0.82rem; color: #999; margin: 0; }
.btn-submit { background: #1a6b8a; color: #fff; border: none; cursor: pointer; padding: 0.7rem 1.75rem; border-radius: 8px; font-size: 0.95rem; font-weight: 600; }
.btn-submit:hover:not(:disabled) { background: #135670; }
.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
</style>
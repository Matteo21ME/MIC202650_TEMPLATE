<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import FormField from '@/components/FormField.vue'
import { citaMedicaService } from '@/services/api'
import { pacienteService } from '@/services/api'
import { medicoService } from '@/services/api'
import { consultorioService } from '@/services/api'

const router = useRouter()
const route  = useRoute()
const esEdicion = computed(() => !!route.params.id)

const DIAS    = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes']
const ESTADOS = ['PROGRAMADA', 'ATENDIDA', 'CANCELADA']

const form = ref({
  paciente_id: '', medico_id: '', consultorio_id: '',
  Dia_Semana: 'Lunes', hora: '', motivo: '', estado: 'PROGRAMADA',
})

const pacientes    = ref([])
const medicos      = ref([])
const consultorios = ref([])
const errores  = ref({}); const enviando = ref(false); const cargando = ref(false); const errorGeneral = ref('')

async function cargar() {
  cargando.value = true
  try {
    const calls = [
      pacienteService.getAll(),
      medicoService.getAll(),
      consultorioService.getAll(),
      esEdicion.value ? citaMedicaService.getById(route.params.id) : Promise.resolve({ data: {} }),
    ]
    const [pac, med, con, cita] = await Promise.all(calls)
    pacientes.value    = pac.data
    medicos.value      = med.data
    consultorios.value = con.data
    if (esEdicion.value) Object.assign(form.value, cita.data)
  } catch { alert('No se pudo cargar.'); router.push('/citas') }
  finally { cargando.value = false }
}

async function enviar() {
  errores.value = {}; errorGeneral.value = ''; enviando.value = true
  try {
    esEdicion.value
      ? await citaMedicaService.update(route.params.id, form.value)
      : await citaMedicaService.create(form.value)
    router.push('/citas')
  } catch (e) {
    if (e.response?.status === 422) {
      if (e.response.data.errors) {
        errores.value = e.response.data.errors
      } else if (e.response.data.message) {
        errorGeneral.value = e.response.data.message
        errores.value.consultorio_id = e.response.data.message
      }
    } else {
      errorGeneral.value = 'Ocurrió un error inesperado al guardar la cita.'
    }
  } finally { enviando.value = false }
}

onMounted(cargar)
</script>

<template>
  <div class="page">
    <div class="form-card">
      <div class="form-header">
        <h1>{{ esEdicion ? 'Editar Cita' : 'Nueva Cita Médica' }}</h1>
        <RouterLink to="/citas" class="btn-back">← Volver</RouterLink>
      </div>
      <div v-if="cargando" class="estado">Cargando...</div>
      <div v-if="errorGeneral" class="error-banner">
        <span class="error-icon">⚠</span> {{ errorGeneral }}
      </div>
      <form v-if="!cargando" @submit.prevent="enviar" novalidate>
        <div class="form-grid">
          <FormField label="Paciente" :error="errores.paciente_id" :full="true">
            <select v-model="form.paciente_id" required :class="{ invalid: errores.paciente_id }">
              <option value="">-- Selecciona paciente --</option>
              <option v-for="p in pacientes" :key="p.id" :value="p.id">{{ p.nombre }} {{ p.apellido }} ({{ p.cedula }})</option>
            </select>
          </FormField>
          <FormField label="Médico" :error="errores.medico_id">
            <select v-model="form.medico_id" required :class="{ invalid: errores.medico_id }">
              <option value="">-- Selecciona médico --</option>
              <option v-for="m in medicos" :key="m.id" :value="m.id">{{ m.nombre }} {{ m.apellido }}</option>
            </select>
          </FormField>
          <FormField label="Consultorio" :error="errores.consultorio_id">
            <select v-model="form.consultorio_id" required :class="{ invalid: errores.consultorio_id }">
              <option value="">-- Selecciona consultorio --</option>
              <option v-for="c in consultorios" :key="c.id" :value="c.id">{{ c.piso }} — {{ c.estado }}</option>
            </select>
          </FormField>
          <FormField label="Día de la semana" :error="errores.Dia_Semana">
            <select v-model="form.Dia_Semana" required :class="{ invalid: errores.Dia_Semana }">
              <option v-for="d in DIAS" :key="d" :value="d">{{ d }}</option>
            </select>
          </FormField>
          <FormField label="Hora" :error="errores.hora">
            <input v-model="form.hora" type="time" step="1" required :class="{ invalid: errores.hora }" />
          </FormField>
          <FormField label="Estado" :error="errores.estado">
            <select v-model="form.estado" required :class="{ invalid: errores.estado }">
              <option v-for="e in ESTADOS" :key="e" :value="e">{{ e }}</option>
            </select>
          </FormField>
          <FormField label="Motivo" :error="errores.motivo" :full="true">
            <input v-model="form.motivo" type="text" maxlength="255" required :class="{ invalid: errores.motivo }" />
          </FormField>
        </div>
        <div class="form-footer">
          <p class="hint">Verifica los datos antes de guardar.</p>
          <button type="submit" class="btn-submit" :disabled="enviando">
            {{ enviando ? 'Guardando...' : (esEdicion ? 'Actualizar' : 'Crear Cita') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.page { max-width: 900px; margin: 2rem auto; padding: 0 1.5rem; }
.form-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,0.1); overflow: hidden; }
.form-header { background: #1a6b8a; color: #fff; padding: 1.25rem 1.75rem; display: flex; align-items: center; justify-content: space-between; }
.form-header h1 { font-size: 1.25rem; font-weight: 700; margin: 0; }
.btn-back { color: rgba(255,255,255,0.9); text-decoration: none; background: rgba(255,255,255,0.15); padding: 0.4rem 0.9rem; border-radius: 6px; font-size: 0.875rem; }
.btn-back:hover { background: rgba(255,255,255,0.25); }
.estado { padding: 3rem; text-align: center; color: #888; }
form { padding: 1.75rem; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
input, select { padding: 0.6rem 0.85rem; border: 1.5px solid #d0dde3; border-radius: 8px; font-size: 0.95rem; outline: none; width: 100%; transition: border 0.2s; box-sizing: border-box; }
input:focus, select:focus { border-color: #1a6b8a; box-shadow: 0 0 0 3px rgba(26,107,138,0.12); }
input.invalid, select.invalid { border-color: #e74c3c; }
.form-footer { display: flex; justify-content: space-between; align-items: center; margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid #eee; }
.hint { font-size: 0.82rem; color: #999; margin: 0; }
.btn-submit { background: #1a6b8a; color: #fff; border: none; cursor: pointer; padding: 0.7rem 1.75rem; border-radius: 8px; font-size: 0.95rem; font-weight: 600; }
.btn-submit:hover:not(:disabled) { background: #135670; }
.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }
@media (max-width: 600px) { .form-grid { grid-template-columns: 1fr; } }
.error-banner { display: flex; align-items: center; gap: 0.6rem; background: #fdf0f0; border-left: 4px solid #e74c3c; color: #c0392b; padding: 0.85rem 1.25rem; margin: 0; font-size: 0.925rem; font-weight: 500; }
.error-icon { font-size: 1.1rem; flex-shrink: 0; }
</style>
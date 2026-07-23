<script setup>
import { ref, onMounted, computed } from 'vue'
import { useRouter, useRoute } from 'vue-router'
import { pacienteService } from '@/services/api'

const router = useRouter()
const route = useRoute()

const esEdicion = computed(() => !!route.params.id)
const titulo = computed(() => esEdicion.value ? 'Editar Paciente' : 'Nuevo Paciente')

const form = ref({
  cedula: '',
  nombre: '',
  apellido: '',
  fecha_nacimiento: '',
  direccion: '',
  correo: '',
  telefono: '',
})

const errores = ref({})
const enviando = ref(false)
const cargando = ref(false)

async function cargarPaciente() {
  cargando.value = true
  try {
    const { data } = await pacienteService.getById(route.params.id)
    Object.assign(form.value, data)
  } catch {
    alert('No se pudo cargar el paciente.')
    router.push('/pacientes')
  } finally {
    cargando.value = false
  }
}

async function enviar() {
  errores.value = {}
  enviando.value = true
  try {
    if (esEdicion.value) {
      await pacienteService.update(route.params.id, form.value)
    } else {
      await pacienteService.create(form.value)
    }
    router.push('/pacientes')
  } catch (e) {
    if (e.response?.status === 422) {
      errores.value = e.response.data.errors ?? {}
    } else {
      alert('Ocurrió un error al guardar.')
    }
  } finally {
    enviando.value = false
  }
}

onMounted(() => {
  if (esEdicion.value) cargarPaciente()
})
</script>

<template>
  <div class="page">
    <div class="form-card">
      <div class="form-header">
        <h1>{{ titulo }}</h1>
        <RouterLink to="/pacientes" class="btn-back">← Volver</RouterLink>
      </div>

      <div v-if="cargando" class="estado">Cargando datos...</div>

      <form v-else @submit.prevent="enviar" novalidate>
        <div class="form-grid">
          <!-- Cédula -->
          <div class="field">
            <label for="cedula">Cédula</label>
            <input id="cedula" v-model="form.cedula" type="text" maxlength="10" required :class="{ invalid: errores.cedula }" />
            <span class="error-msg" v-if="errores.cedula">{{ errores.cedula[0] }}</span>
          </div>

          <!-- Correo -->
          <div class="field">
            <label for="correo">Correo</label>
            <input id="correo" v-model="form.correo" type="email" required :class="{ invalid: errores.correo }" />
            <span class="error-msg" v-if="errores.correo">{{ errores.correo[0] }}</span>
          </div>

          <!-- Nombre -->
          <div class="field">
            <label for="nombre">Nombre</label>
            <input id="nombre" v-model="form.nombre" type="text" maxlength="50" required :class="{ invalid: errores.nombre }" />
            <span class="error-msg" v-if="errores.nombre">{{ errores.nombre[0] }}</span>
          </div>

          <!-- Apellido -->
          <div class="field">
            <label for="apellido">Apellido</label>
            <input id="apellido" v-model="form.apellido" type="text" maxlength="50" required :class="{ invalid: errores.apellido }" />
            <span class="error-msg" v-if="errores.apellido">{{ errores.apellido[0] }}</span>
          </div>

          <!-- Fecha de nacimiento -->
          <div class="field">
            <label for="fecha_nacimiento">Fecha de Nacimiento</label>
            <input id="fecha_nacimiento" v-model="form.fecha_nacimiento" type="date" required :class="{ invalid: errores.fecha_nacimiento }" />
            <span class="error-msg" v-if="errores.fecha_nacimiento">{{ errores.fecha_nacimiento[0] }}</span>
          </div>

          <!-- Teléfono -->
          <div class="field">
            <label for="telefono">Teléfono</label>
            <input id="telefono" v-model="form.telefono" type="text" maxlength="15" required :class="{ invalid: errores.telefono }" />
            <span class="error-msg" v-if="errores.telefono">{{ errores.telefono[0] }}</span>
          </div>

          <!-- Dirección (full width) -->
          <div class="field full">
            <label for="direccion">Dirección</label>
            <input id="direccion" v-model="form.direccion" type="text" maxlength="100" required :class="{ invalid: errores.direccion }" />
            <span class="error-msg" v-if="errores.direccion">{{ errores.direccion[0] }}</span>
          </div>
        </div>

        <div class="form-footer">
          <p class="hint">Verifica los datos antes de guardar.</p>
          <button type="submit" class="btn-submit" :disabled="enviando">
            {{ enviando ? 'Guardando...' : (esEdicion ? 'Actualizar Paciente' : 'Crear Paciente') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.page { max-width: 900px; margin: 2rem auto; padding: 0 1.5rem; }
.form-card { background: #fff; border-radius: 12px; box-shadow: 0 2px 16px rgba(0,0,0,0.1); overflow: hidden; }
.form-header {
  background: #1a6b8a; color: #fff;
  padding: 1.25rem 1.75rem;
  display: flex; align-items: center; justify-content: space-between;
}
.form-header h1 { font-size: 1.25rem; font-weight: 700; margin: 0; }
.btn-back {
  color: rgba(255,255,255,0.9); text-decoration: none;
  background: rgba(255,255,255,0.15); padding: 0.4rem 0.9rem;
  border-radius: 6px; font-size: 0.875rem; transition: background 0.2s;
}
.btn-back:hover { background: rgba(255,255,255,0.25); }

.estado { padding: 3rem; text-align: center; color: #888; }

form { padding: 1.75rem; }
.form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.field { display: flex; flex-direction: column; gap: 0.4rem; }
.field.full { grid-column: 1 / -1; }
label { font-size: 0.875rem; font-weight: 600; color: #444; }
input {
  padding: 0.6rem 0.85rem; border: 1.5px solid #d0dde3;
  border-radius: 8px; font-size: 0.95rem; outline: none; transition: border 0.2s;
}
input:focus { border-color: #1a6b8a; box-shadow: 0 0 0 3px rgba(26,107,138,0.12); }
input.invalid { border-color: #e74c3c; }
.error-msg { font-size: 0.8rem; color: #e74c3c; }

.form-footer {
  display: flex; justify-content: space-between; align-items: center;
  margin-top: 1.75rem; padding-top: 1.25rem; border-top: 1px solid #eee;
}
.hint { font-size: 0.82rem; color: #999; margin: 0; }
.btn-submit {
  background: #1a6b8a; color: #fff; border: none; cursor: pointer;
  padding: 0.7rem 1.75rem; border-radius: 8px; font-size: 0.95rem; font-weight: 600;
  transition: background 0.2s;
}
.btn-submit:hover:not(:disabled) { background: #135670; }
.btn-submit:disabled { opacity: 0.6; cursor: not-allowed; }

@media (max-width: 600px) {
  .form-grid { grid-template-columns: 1fr; }
}
</style>
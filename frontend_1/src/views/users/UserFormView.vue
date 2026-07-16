<script setup>
import { computed, onMounted, ref } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { userService, roleService } from '@/services/api'

const route   = useRoute()
const router  = useRouter()
const isEdit  = computed(() => !!route.params.id)
const loading = ref(false)
const saving  = ref(false)
const errors  = ref({})
const roles   = ref([])

const form = ref({ name: '', email: '', password: '', role_id: '' })

onMounted(async () => {
  loading.value = true
  try {
    const { data: r } = await roleService.getAll()
    roles.value = r
    if (isEdit.value) {
      const { data: u } = await userService.getById(route.params.id)
      form.value.name    = u.name
      form.value.email   = u.email
      form.value.role_id = u.role_id
    }
  } catch { alert('No se pudo cargar los datos.'); router.push('/usuarios') }
  finally { loading.value = false }
})

async function submit() {
  errors.value = {}; saving.value = true
  const payload = {
    name:    form.value.name,
    email:   form.value.email,
    role_id: Number(form.value.role_id),
  }
  if (form.value.password) payload.password = form.value.password
  try {
    if (isEdit.value) { await userService.update(route.params.id, payload) }
    else              { await userService.create(payload) }
    router.push('/usuarios')
  } catch (e) {
    if (e.response?.status === 422) errors.value = e.response.data.errors || {}
    else alert('No se pudo guardar.')
  } finally { saving.value = false }
}
</script>

<template>
  <div class="page">
    <div class="card">
      <header>
        <h2>{{ isEdit ? 'Editar Usuario' : 'Nuevo Usuario' }}</h2>
        <RouterLink to="/usuarios" class="btn-back">← Volver</RouterLink>
      </header>

      <p v-if="loading" class="muted">Cargando...</p>

      <form v-else @submit.prevent="submit" class="form">
        <div class="field">
          <label>Nombre</label>
          <input v-model="form.name" type="text" required />
          <small v-if="errors.name" class="error">{{ errors.name[0] }}</small>
        </div>

        <div class="field">
          <label>Correo</label>
          <input v-model="form.email" type="email" required />
          <small v-if="errors.email" class="error">{{ errors.email[0] }}</small>
        </div>

        <div class="field">
          <label>Contraseña {{ isEdit ? '(dejar vacio para no cambiar)' : '' }}</label>
          <input v-model="form.password" type="password" :required="!isEdit" />
          <small v-if="errors.password" class="error">{{ errors.password[0] }}</small>
        </div>

        <div class="field">
          <label>Rol</label>
          <select v-model="form.role_id" required>
            <option value="" disabled>Seleccione un rol</option>
            <option v-for="r in roles" :key="r.id" :value="r.id">{{ r.nombre }}</option>
          </select>
          <small v-if="errors.role_id" class="error">{{ errors.role_id[0] }}</small>
        </div>

        <div class="form-footer">
          <button type="submit" :disabled="saving">
            {{ saving ? 'Guardando...' : (isEdit ? 'Actualizar' : 'Crear Usuario') }}
          </button>
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.page { max-width: 600px; margin: 2rem auto; padding: 0 1rem; }
.card { background: #fff; border-radius: 12px; padding: 1.5rem; box-shadow: 0 2px 12px rgba(0,0,0,0.1); }
header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.25rem; }
h2 { margin: 0; color: #1a6b8a; }
.btn-back {
  font-size: 0.875rem; color: #1a6b8a; text-decoration: none;
  border: 1px solid #1a6b8a; border-radius: 6px; padding: 0.35rem 0.7rem;
}
.form { display: grid; gap: 1rem; }
.field { display: grid; gap: 0.3rem; }
label { font-size: 0.875rem; font-weight: 600; color: #333; }
input, select {
  border: 1.5px solid #d0dde3; border-radius: 8px;
  padding: 0.6rem 0.8rem; font-size: 0.95rem; outline: none; transition: border 0.2s;
}
input:focus, select:focus { border-color: #1a6b8a; }
.error { color: #c0392b; font-size: 0.8rem; }
.muted { color: #aaa; }
.form-footer { padding-top: 0.5rem; }
button {
  background: #1a6b8a; color: #fff; border: none; border-radius: 8px;
  padding: 0.7rem 1.5rem; font-size: 0.95rem; font-weight: 700; cursor: pointer;
}
button:disabled { opacity: 0.65; cursor: not-allowed; }
</style>

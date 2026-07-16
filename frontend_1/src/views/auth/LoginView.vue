<script setup>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import { login } from '@/services/auth'

const router  = useRouter()
const loading = ref(false)
const error   = ref('')
const form    = reactive({ email: '', password: '' })

async function onSubmit() {
  loading.value = true
  error.value   = ''
  try {
    await login(form)
    router.push('/home')
  } catch (e) {
    error.value = e.response?.data?.message || 'Credenciales incorrectas.'
  } finally {
    loading.value = false
  }
}
</script>

<template>
  <div class="login-bg">
    <div class="card">
      <h1>&#x2695; Centro de Salud</h1>
      <p>Ingresa tu cuenta para continuar.</p>

      <form @submit.prevent="onSubmit">
        <label>Correo</label>
        <input v-model="form.email" type="email" required autocomplete="username" />

        <label>Contraseña</label>
        <input v-model="form.password" type="password" required autocomplete="current-password" />

        <p v-if="error" class="error">{{ error }}</p>

        <button type="submit" :disabled="loading">
          {{ loading ? 'Ingresando...' : 'Ingresar' }}
        </button>
      </form>
    </div>
  </div>
</template>

<style scoped>
.login-bg {
  min-height: 100vh;
  display: grid;
  place-items: center;
  background: linear-gradient(135deg, #0d4f66 0%, #1a6b8a 50%, #2d8fac 100%);
}
.card {
  background: #fff;
  border-radius: 16px;
  padding: 2.25rem 2rem;
  width: 100%;
  max-width: 420px;
  box-shadow: 0 20px 60px rgba(0,0,0,0.25);
}
h1 { margin: 0 0 0.3rem; color: #1a6b8a; font-size: 1.4rem; }
p  { margin: 0 0 1.5rem; color: #888; font-size: 0.9rem; }
form { display: grid; gap: 0.6rem; }
label { font-size: 0.875rem; font-weight: 600; color: #333; }
input {
  border: 1.5px solid #d0dde3;
  border-radius: 8px;
  padding: 0.65rem 0.8rem;
  font-size: 0.95rem;
  outline: none;
  transition: border 0.2s;
}
input:focus { border-color: #1a6b8a; box-shadow: 0 0 0 3px rgba(26,107,138,0.12); }
button {
  margin-top: 0.5rem;
  background: #1a6b8a;
  color: #fff;
  border: none;
  border-radius: 8px;
  padding: 0.75rem;
  font-size: 0.95rem;
  font-weight: 700;
  cursor: pointer;
  transition: background 0.2s;
}
button:hover:not(:disabled) { background: #135670; }
button:disabled { opacity: 0.65; cursor: not-allowed; }
.error { color: #c0392b; font-size: 0.875rem; margin: 0; }
</style>

import { api } from './api'
import { setSession, clearSession } from './session'

export async function login(credentials) {
  const { data } = await api.post('/auth/login', credentials)
  setSession(data.token, data.user)
  return data
}

export async function logout() {
  try { await api.post('/auth/logout') } finally { clearSession() }
}

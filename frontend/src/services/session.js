import { reactive } from 'vue'

const TOKEN_KEY = 'cs_token'
const USER_KEY  = 'cs_user'

export const session = reactive({
  token: localStorage.getItem(TOKEN_KEY) || null,
  user:  JSON.parse(localStorage.getItem(USER_KEY) || 'null'),
})

export function setSession(token, user) {
  session.token = token
  session.user  = user
  localStorage.setItem(TOKEN_KEY, token)
  localStorage.setItem(USER_KEY, JSON.stringify(user))
}

export function clearSession() {
  session.token = null
  session.user  = null
  localStorage.removeItem(TOKEN_KEY)
  localStorage.removeItem(USER_KEY)
}

export const getToken        = () => session.token
export const isAuthenticated = () => !!session.token
export const userRole        = () => session.user?.role || null
export const isAdmin         = () => session.user?.role === 'Administrador'
export const isDeveloper     = () => session.user?.role === 'Desarrollador'
export const isSupervisor    = () => session.user?.role === 'Supervisor'

import axios from 'axios'
import { getToken, clearSession } from './session'

const API_BASE_URL = import.meta.env.VITE_API_BASE_URL || '/api'

export const api = axios.create({
  baseURL: API_BASE_URL,
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
})

// Adjunta el Bearer token en cada request
api.interceptors.request.use((config) => {
  const token = getToken()
  if (token) config.headers.Authorization = `Bearer ${token}`
  return config
})

// Limpia la sesion si el servidor responde 401
api.interceptors.response.use(
  (res) => res,
  (err) => {
    if (err.response?.status === 401) clearSession()
    return Promise.reject(err)
  }
)

const crud = (prefix) => ({
  getAll:  ()         => api.get(`/${prefix}`),
  getById: (id)       => api.get(`/${prefix}/${id}`),
  create:  (data)     => api.post(`/${prefix}`, data),
  update:  (id, data) => api.put(`/${prefix}/${id}`, data),
  delete:  (id)       => api.delete(`/${prefix}/${id}`),
})

export const userService         = crud('usuarios')
export const roleService         = { getAll: () => api.get('/roles') }

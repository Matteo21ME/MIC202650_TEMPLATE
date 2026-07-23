import axios from 'axios'
import { getToken, clearSession } from './session'

export const api = axios.create({
  baseURL: '/api/v1',
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

export const userService = crud('usuarios')
export const roleService = { getAll: () => api.get('/roles') }

export const pacienteService = crud('pacientes')
export const medicoService = crud('medicos')
export const especialidadService = crud('especialidades')
export const consultorioService = crud('consultorios')
export const citaMedicaService = crud('citas-medicas')

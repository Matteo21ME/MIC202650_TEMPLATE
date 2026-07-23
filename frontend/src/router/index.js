import { createRouter, createWebHistory } from 'vue-router'
import { isAuthenticated, isAdmin, userRole } from '@/services/session'

import LoginView            from '@/views/auth/LoginView.vue'
import HomeView             from '@/views/HomeView.vue'
import RolesView            from '@/views/roles/RolesView.vue'
import UsersView            from '@/views/users/UsersView.vue'
import UserFormView         from '@/views/users/UserFormView.vue'
import DashboardView        from '@/views/DashboardView.vue'
import PacientesView        from '@/views/pacientes/PacientesView.vue'
import PacienteFormView     from '@/views/pacientes/PacienteFormView.vue'
import MedicosView          from '@/views/medicos/MedicosView.vue'
import MedicoFormView       from '@/views/medicos/MedicoFormView.vue'
import EspecialidadesView   from '@/views/especialidades/EspecialidadesView.vue'
import EspecialidadFormView from '@/views/especialidades/EspecialidadFormView.vue'
import ConsultoriosView     from '@/views/consultorios/ConsultoriosView.vue'
import ConsultorioFormView  from '@/views/consultorios/ConsultorioFormView.vue'
import CitasView            from '@/views/citas/CitasView.vue'
import CitasFormView        from '@/views/citas/CitasFormView.vue'

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    // Publicas
    { path: '/',     name: 'landing', component: HomeView },
    { path: '/login', name: 'login',  component: LoginView },

    // Autenticado (cualquier rol)
    { path: '/home',                      name: 'home',                  component: DashboardView,       meta: { auth: true } },
    { path: '/pacientes',                 name: 'pacientes',             component: PacientesView,        meta: { auth: true, devBlocked: true } },
    { path: '/medicos',                   name: 'medicos',               component: MedicosView,          meta: { auth: true } },
    { path: '/especialidades',            name: 'especialidades',        component: EspecialidadesView,   meta: { auth: true } },
    { path: '/consultorios',              name: 'consultorios',          component: ConsultoriosView,     meta: { auth: true } },
    { path: '/citas',                     name: 'citas',                 component: CitasView,            meta: { auth: true, devBlocked: true } },
    { path: '/roles',                     name: 'roles',                 component: RolesView,            meta: { auth: true } },

    // Solo Administrador (escritura)
    { path: '/pacientes/crear',           name: 'pacientes.crear',       component: PacienteFormView,     meta: { auth: true, adminOnly: true } },
    { path: '/pacientes/:id/editar',      name: 'pacientes.editar',      component: PacienteFormView,     meta: { auth: true, adminOnly: true } },
    { path: '/especialidades/crear',      name: 'especialidades.crear',  component: EspecialidadFormView, meta: { auth: true, adminOnly: true } },
    { path: '/especialidades/:id/editar', name: 'especialidades.editar', component: EspecialidadFormView, meta: { auth: true, adminOnly: true } },
    { path: '/consultorios/crear',        name: 'consultorios.crear',    component: ConsultorioFormView,  meta: { auth: true, adminOnly: true } },
    { path: '/consultorios/:id/editar',   name: 'consultorios.editar',   component: ConsultorioFormView,  meta: { auth: true, adminOnly: true } },
    { path: '/medicos/crear',             name: 'medicos.crear',         component: MedicoFormView,       meta: { auth: true, adminOnly: true } },
    { path: '/medicos/:id/editar',        name: 'medicos.editar',        component: MedicoFormView,       meta: { auth: true, adminOnly: true } },
    { path: '/citas/crear',               name: 'citas.crear',           component: CitasFormView,        meta: { auth: true, adminOnly: true } },
    { path: '/citas/:id/editar',          name: 'citas.editar',          component: CitasFormView,        meta: { auth: true, adminOnly: true } },
    { path: '/usuarios',                  name: 'usuarios',              component: UsersView,            meta: { auth: true, adminOnly: true } },
    { path: '/usuarios/crear',            name: 'usuarios.crear',        component: UserFormView,         meta: { auth: true, adminOnly: true } },
    { path: '/usuarios/:id/editar',       name: 'usuarios.editar',       component: UserFormView,         meta: { auth: true, adminOnly: true } },
  ],
})

router.beforeEach((to) => {
  // Redirigir a /home si ya esta autenticado y quiere ir a landing o login
  if ((to.name === 'landing' || to.name === 'login') && isAuthenticated()) return '/home'

  // Proteger rutas de app: redirigir a login si no esta autenticado
  if (to.meta.auth && !isAuthenticated()) return '/login'

  // Solo Administrador puede acceder a rutas adminOnly
  if (to.meta.adminOnly && !isAdmin()) return '/home'

  // El rol Desarrollador no puede acceder a modulos sensibles
  if (to.meta.devBlocked && userRole() === 'Desarrollador') return '/home'

  return true
})

export default router

<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue'
import { useRoute, useRouter } from 'vue-router'
import { session, isAdmin } from '@/services/session'
import { logout } from '@/services/auth'

const route   = useRoute()
const router  = useRouter()
const isActive = (path) => route.path.startsWith(path)
const userName = computed(() => session.user?.name || '')
const roleName = computed(() => session.user?.role || '')

// Estado para controlar el menú desplegable
const isDropdownOpen = ref(false)

function toggleDropdown() {
  isDropdownOpen.value = !isDropdownOpen.value
}

// Cerrar el menú si el usuario hace clic fuera de él
function closeDropdown(event) {
  if (!event.target.closest('.nav-user-dropdown')) {
    isDropdownOpen.value = false
  }
}

onMounted(() => {
  window.addEventListener('click', closeDropdown)
})

onUnmounted(() => {
  window.removeEventListener('click', closeDropdown)
})

async function onLogout() {
  isDropdownOpen.value = false
  await logout()
  router.push('/')
}
</script>

<template>
  <nav v-if="session.token" class="navbar">
    <div class="nav-container">
      <RouterLink to="/home" class="nav-brand">&#x2695; Centro de Salud</RouterLink>

      <div class="nav-links">
        <!--<RouterLink to="/home"             :class="{ active: route.name === 'home' }">Inicio</RouterLink>-->
        <RouterLink to="/roles"        :class="{ active: isActive('/roles') }">Roles</RouterLink>
        <RouterLink v-if="isAdmin()" to="/usuarios" :class="{ active: isActive('/usuarios') }">Usuarios</RouterLink>
      </div>

      <!-- Menú Desplegable del Usuario -->
      <div class="nav-user-dropdown">
        <button class="dropdown-trigger" @click.stop="toggleDropdown">
          <!-- Icono de Usuario (SVG integrado) -->
          <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="user-icon">
            <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path>
            <circle cx="12" cy="7" r="4"></circle>
          </svg>
          <span class="user-name">{{ userName }}</span>
          <!-- Flecha indicadora -->
          <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" :class="['arrow-icon', { 'arrow-rotate': isDropdownOpen }]">
            <polyline points="6 9 12 15 18 9"></polyline>
          </svg>
        </button>

        <!-- Menú Desplegable -->
        <Transition name="fade-slide">
          <div v-if="isDropdownOpen" class="dropdown-menu">
            <div class="dropdown-header">
              <span class="dropdown-user-name">{{ userName }}</span>
              <span class="dropdown-role">{{ roleName || 'Usuario' }}</span>
            </div>
            <hr class="dropdown-divider" />
            <button class="dropdown-item btn-logout" @click="onLogout">
              <!-- Icono de Salir (Log Out) -->
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                <polyline points="16 17 21 12 16 7"></polyline>
                <line x1="21" y1="12" x2="9" y2="12"></line>
              </svg>
              Cerrar sesión
            </button>
          </div>
        </Transition>
      </div>
    </div>
  </nav>
</template>

<style scoped>
.navbar { background: #1a6b8a; box-shadow: 0 2px 8px rgba(0,0,0,0.15); position: sticky; top: 0; z-index: 100; }
.nav-container {
  max-width: 1280px; margin: 0 auto; padding: 0 1.5rem;
  display: flex; align-items: center; justify-content: space-between; height: 60px; gap: 1rem;
}
.nav-brand { font-size: 1.05rem; font-weight: 700; color: #fff; text-decoration: none; flex-shrink: 0; }
.nav-links { display: flex; gap: 0.1rem; flex-wrap: wrap; flex: 1; }
.nav-links a {
  color: rgba(255,255,255,0.8); text-decoration: none;
  padding: 0.4rem 0.75rem; border-radius: 6px; font-weight: 500; font-size: 0.85rem; transition: background 0.2s;
}
.nav-links a:hover, .nav-links a.active { background: rgba(255,255,255,0.18); color: #fff; }

/* Contenedor del Dropdown */
.nav-user-dropdown {
  position: relative;
  display: inline-block;
}

/* Botón disparador */
.dropdown-trigger {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  background: transparent;
  border: none;
  color: #fff;
  cursor: pointer;
  padding: 0.4rem 0.75rem;
  border-radius: 6px;
  font-size: 0.85rem;
  transition: background 0.2s;
}

.dropdown-trigger:hover {
  background: rgba(255, 255, 255, 0.1);
}

.user-icon {
  color: rgba(255, 255, 255, 0.9);
}

.arrow-icon {
  transition: transform 0.2s ease;
  color: rgba(255, 255, 255, 0.6);
}

.arrow-rotate {
  transform: rotate(180deg);
}

.user-name {
  color: rgba(255,255,255,0.9);
  font-weight: 500;
}

/* Menú desplegable */
.dropdown-menu {
  position: absolute;
  right: 0;
  top: calc(100% + 5px);
  background: #ffffff;
  min-width: 180px;
  border-radius: 8px;
  box-shadow: 0 4px 12px rgba(0,0,0,0.15);
  border: 1px solid rgba(0, 0, 0, 0.08);
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

/* Encabezado interno del menú */
.dropdown-header {
  padding: 0.75rem 1rem;
  display: flex;
  flex-direction: column;
}

.dropdown-user-name {
  font-size: 0.85rem;
  font-weight: 600;
  color: #2c3e50;
}

.dropdown-role {
  font-size: 0.7rem;
  color: #7f8c8d;
  text-transform: uppercase;
  margin-top: 0.15rem;
  font-weight: 700;
}

.dropdown-divider {
  border: 0;
  border-top: 1px solid #f1f2f6;
  margin: 0;
}

/* Ítem de Cerrar Sesión */
.dropdown-item {
  width: 100%;
  border: none;
  background: transparent;
  padding: 0.75rem 1rem;
  text-align: left;
  font-size: 0.82rem;
  color: #e74c3c; /* Color rojo para destacar acción destructiva */
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 0.5rem;
  transition: background 0.15s;
}

.dropdown-item:hover {
  background: #fff5f5;
}

/* Transiciones elegantes */
.fade-slide-enter-active,
.fade-slide-leave-active {
  transition: transform 0.15s ease, opacity 0.15s ease;
}

.fade-slide-enter-from,
.fade-slide-leave-to {
  opacity: 0;
  transform: translateY(-8px);
}
</style>
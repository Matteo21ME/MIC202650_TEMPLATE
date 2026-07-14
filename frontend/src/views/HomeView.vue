<script setup>
import { useRouter } from 'vue-router'
import { isAuthenticated } from '@/services/session'
const router = useRouter()
const goToApp = () => router.push(isAuthenticated() ? '/home' : '/login')
</script>

<template>
  <div>
    <!-- Landing header (visible sin login) -->
    <header class="land-header">
      <div class="land-nav">
        <span class="land-brand">&#x2695; Gobierno Ecuador</span>
        <RouterLink to="/login" class="btn-login">Iniciar Sesión</RouterLink>
      </div>
    </header>

    <!-- Hero -->
    <section class="hero">
      <div class="hero-content">
        <h1>Bienvenido al Gobierno Ecuador</h1>
        <p>Atención médica de calidad, comprometida con tu bienestar y el de tu familia.</p>
        <!-- <button class="btn-primary" @click="goToApp">Iniciar Sesión</button> -->
      </div>
    </section>

    <!-- Servicios -->
    <section class="section">
      <div class="container">
        <h2 class="section-title">Nuestros Servicios</h2>
        <div class="cards-grid">
          <div class="card" v-for="s in servicios" :key="s.titulo">
            <div class="card-icon">{{ s.icono }}</div>
            <h3>{{ s.titulo }}</h3>
            <p>{{ s.descripcion }}</p>
          </div>
        </div>
      </div>
    </section>

    <!-- Sobre nosotros -->
    <section class="section section-alt">
      <div class="container about-grid">
        <div>
          <h2 class="section-title left">Sobre Nosotros</h2>
          <p>Somos un Gobierno Ecuador integral con más de 20 años de experiencia brindando atención médica a nuestra comunidad. Contamos con especialistas en múltiples áreas y tecnología de vanguardia.</p>
          <ul class="about-list">
            <li>✔ Más de 15 especialidades médicas</li>
            <li>✔ Atención de lunes a sábado</li>
            <li>✔ Consultorios modernos y equipados</li>
            <li>✔ Historia clínica digital</li>
          </ul>
        </div>
        <div class="about-stats">
          <div class="stat" v-for="e in estadisticas" :key="e.label">
            <span class="stat-num">{{ e.num }}</span>
            <span class="stat-label">{{ e.label }}</span>
          </div>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
      <p>© 2026 Gobierno Ecuador · Todos los derechos reservados</p>
    </footer>
  </div>
</template>

<script>
export default {
  data() {
    return {
      servicios: [
        { icono: '🩺', titulo: 'Medicina General', descripcion: 'Consultas y diagnósticos para toda la familia.' },
        { icono: '🦷', titulo: 'Odontología', descripcion: 'Cuidado dental preventivo y curativo.' },
        { icono: '🧠', titulo: 'Neurología', descripcion: 'Especialistas en el sistema nervioso.' },
        { icono: '❤️', titulo: 'Cardiología', descripcion: 'Diagnóstico y tratamiento cardiovascular.' },
        { icono: '🦴', titulo: 'Traumatología', descripcion: 'Atención de lesiones musculo-esqueléticas.' },
        { icono: '👁️', titulo: 'Oftalmología', descripcion: 'Cuidado y salud visual especializada.' },
      ],
      estadisticas: [
        { num: '20+', label: 'Años de experiencia' },
        { num: '50+', label: 'Médicos especialistas' },
        { num: '10k+', label: 'Pacientes atendidos' },
        { num: '15+', label: 'Especialidades' },
      ],
    }
  },
}
</script>

<style scoped>
.hero {
  background: linear-gradient(135deg, #1a6b8a 0%, #0d4a6b 100%);
  color: #fff;
  padding: 6rem 1.5rem;
  text-align: center;
}
.hero-content { max-width: 640px; margin: 0 auto; }
.hero h1 { font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.2; }
.hero p { font-size: 1.15rem; opacity: 0.9; margin-bottom: 2rem; }
.btn-primary {
  background: #fff;
  color: #1a6b8a;
  border: none;
  padding: 0.75rem 2rem;
  border-radius: 8px;
  font-size: 1rem;
  font-weight: 600;
  cursor: pointer;
  transition: transform 0.2s, box-shadow 0.2s;
}
.btn-primary:hover { transform: translateY(-2px); box-shadow: 0 4px 16px rgba(0,0,0,0.2); }

.section { padding: 4rem 1.5rem; }
.section-alt { background: #f0f7fa; }
.container { max-width: 1200px; margin: 0 auto; }
.section-title { font-size: 1.75rem; font-weight: 700; color: #1a6b8a; text-align: center; margin-bottom: 2.5rem; }
.section-title.left { text-align: left; }

.cards-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; }
.card { background: #fff; border-radius: 12px; padding: 2rem 1.5rem; text-align: center; box-shadow: 0 2px 12px rgba(0,0,0,0.07); transition: transform 0.2s; }
.card:hover { transform: translateY(-4px); }
.card-icon { font-size: 2.5rem; margin-bottom: 1rem; }
.card h3 { font-size: 1.1rem; font-weight: 600; color: #1a6b8a; margin-bottom: 0.5rem; }
.card p { font-size: 0.9rem; color: #666; }

.about-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 4rem; align-items: center; }
.about-grid p { color: #555; line-height: 1.7; margin-bottom: 1.5rem; }
.about-list { list-style: none; padding: 0; display: flex; flex-direction: column; gap: 0.6rem; color: #444; }
.about-stats { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; }
.stat { background: #fff; border-radius: 12px; padding: 1.5rem; text-align: center; box-shadow: 0 2px 12px rgba(0,0,0,0.07); }
.stat-num { display: block; font-size: 2rem; font-weight: 800; color: #1a6b8a; }
.stat-label { font-size: 0.85rem; color: #666; }

.footer { background: #0d2d3d; color: rgba(255,255,255,0.6); text-align: center; padding: 1.5rem; font-size: 0.875rem; }

/* Landing header */
.land-header { background: #0d3d52; position: sticky; top: 0; z-index: 100; }
.land-nav {
  max-width: 1200px; margin: 0 auto; padding: 0 1.5rem;
  height: 60px; display: flex; align-items: center; justify-content: space-between;
}
.land-brand { font-size: 1.1rem; font-weight: 700; color: #fff; }
.btn-login {
  background: #fff; color: #1a6b8a; border: none; border-radius: 8px;
  padding: 0.5rem 1.25rem; font-size: 0.9rem; font-weight: 700; cursor: pointer;
  text-decoration: none; transition: opacity 0.2s;
}
.btn-login:hover { opacity: 0.88; }

@media (max-width: 768px) {
  .hero h1 { font-size: 1.75rem; }
  .about-grid { grid-template-columns: 1fr; gap: 2rem; }
}
</style>

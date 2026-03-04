<template>
  <div class="flex h-screen bg-gray-100">
    <!-- Static sidebar for desktop -->
    <aside class="hidden md:flex w-64 bg-gray-800 text-white flex-col flex-shrink-0">
      <div class="p-4 text-2xl font-bold border-b border-gray-700 fisioterapia-text-effect">
        Fisioterapia
      </div>
      <nav class="flex-1 p-4 space-y-2">
        <router-link to="/dashboard" class="block py-2 px-4 rounded hover:bg-gray-700 border border-white shadow-white-glow">Dashboard</router-link>
        <router-link to="/patients" class="block py-2 px-4 rounded hover:bg-gray-700 border border-white shadow-white-glow">Pacientes</router-link>
        <router-link to="/appointments" class="block py-2 px-4 rounded hover:bg-gray-700 border border-white shadow-white-glow">Citas</router-link>
        <router-link to="/therapists" class="block py-2 px-4 rounded hover:bg-gray-700 border border-white shadow-white-glow">Terapeutas</router-link>
        <router-link to="/exercises" class="block py-2 px-4 rounded hover:bg-gray-700 border border-white shadow-white-glow">Ejercicios</router-link>
        <router-link to="/reports" class="block py-2 px-4 rounded hover:bg-gray-700 border border-white shadow-white-glow">Reportes</router-link>
      </nav>
      <div class="p-4 sidebar-image-container">
        <img :src="headerBg" alt="Sidebar Image" class="w-full h-auto object-cover rounded shadow-white-glow-image">
      </div>
    </aside>

    <!-- Mobile sidebar -->
    <div :class="['fixed inset-0 z-30 flex', sidebarOpen ? '' : 'hidden']">
        <aside class="w-64 bg-gray-800 text-white flex-col flex-shrink-0">
            <div class="p-4 text-2xl font-bold border-b border-gray-700">
                Fisioterapia
            </div>
            <nav class="flex-1 p-4 space-y-2">
                <router-link to="/dashboard" @click="sidebarOpen = false" class="block py-2 px-4 rounded hover:bg-gray-700">Dashboard</router-link>
                <router-link to="/patients" @click="sidebarOpen = false" class="block py-2 px-4 rounded hover:bg-gray-700">Pacientes</router-link>
                <router-link to="/appointments" @click="sidebarOpen = false" class="block py-2 px-4 rounded hover:bg-gray-700">Citas</router-link>
            </nav>
        </aside>
        <div @click="sidebarOpen = false" class="flex-1 bg-black opacity-50"></div>
    </div>

    <!-- Main Content Area -->
    <div class="flex-1 flex flex-col overflow-hidden">
      <!-- Top Header -->
      <header class="relative flex items-center justify-between p-4 shadow-md bg-cover bg-center" :style="{ backgroundImage: `url(${headerBg})` }">
        <div class="absolute inset-0 bg-black opacity-40"></div>
        
        <div class="relative z-10 flex items-center justify-between w-full">
            <div class="flex items-center">
              <button @click.stop="sidebarOpen = !sidebarOpen" class="md:hidden mr-4 p-1 rounded-md text-white focus:outline-none">
                <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4 6h16M4 12h16M4 18h16" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" /></svg>
              </button>
              <div class="flex items-center text-xl font-semibold">
                <div class="animated-text-container">
                    <span class="animated-text header-text-style">Historial Fisioterapia</span>
                </div>
              </div>
            </div>
            <nav>
              <router-link to="/login" class="text-white font-semibold hover:underline mr-4">Login</router-link>
              <button @click="handleLogout" class="gradient-button text-red-700 font-bold py-2 px-4 rounded shadow">
            Logout
          </button>
            </nav>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200 p-4">
        <router-view />
      </main>

      <!-- Footer -->
      <footer class="footer-gradient shadow-md p-4 text-center">
        <p class="header-text-style text-lg">
          &copy; {{ new Date().getFullYear() }} Los de la B. Todos los derechos reservados.
        </p>
      </footer>
    </div>
  </div>
</template>

<script setup>
import { ref } from 'vue';
import { RouterLink, RouterView, useRouter } from 'vue-router';
import { useAuthStore } from '../store/auth';
import headerBg from '../assets/fisioterapia.jpeg';

const sidebarOpen = ref(false);
const auth = useAuthStore();
const router = useRouter();

const handleLogout = () => {
  auth.logout();
  router.push('/'); // Redirect to login page after logout
};
</script>

<style scoped>
.animated-text-container {
  font-size: 1.25rem; /* text-xl */
  font-weight: 600; /* font-semibold */
  overflow: hidden;
  position: relative;
  width: 250px; /* Adjust width as needed */
  height: 30px; /* Adjust height as needed */
  display: flex;
  align-items: center;
}

.animated-text {
  position: absolute;
  white-space: nowrap;
  animation: move-right-to-left 8s linear infinite;
}

.header-text-style {
  color: #ffffff;
  text-shadow: 
    1px 1px 0px #1e88e5,
    2px 2px 0px #1565c0,
    3px 3px 0px #0d47a1,
    4px 4px 5px rgba(0, 0, 0, 0.5);
}

@keyframes move-right-to-left {
  0% {
    transform: translateX(100%);
  }
  100% {
    transform: translateX(-120%); /* move further to disappear completely */
  }
}

.shadow-white-glow {
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8); /* White glow effect */
}

.gradient-button {
  background: linear-gradient(to left, #e0e0e0, #f5f5f5); /* Light gray gradient from right to left */
}

.sidebar-image-container {
  background: linear-gradient(to left, rgba(224, 224, 224, 0.5), rgba(245, 245, 245, 0.5)); /* Light gray gradient with transparency */
  border-radius: 0.25rem; /* rounded */
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8); /* White glow effect */
  margin-top: auto; /* Pushes the container to the bottom */
}

.shadow-white-glow-image {
  box-shadow: 0 0 10px rgba(255, 255, 255, 0.8); /* White glow effect for the image */
  animation: heartbeat 1.5s infinite; /* Heartbeat animation */
}

@keyframes heartbeat {
  0% {
    transform: scale(1);
  }
  25% {
    transform: scale(1.05);
  }
  50% {
    transform: scale(1);
  }
  75% {
    transform: scale(0.95);
  }
  100% {
    transform: scale(1);
  }
}

.footer-gradient {
  background: linear-gradient(to right, #d0d0d0, #e0e0e0); /* Light gray gradient from left to right, slightly darker */
}

.fisioterapia-text-effect {
  text-shadow:
    -1px -1px 0 #ADD8E6,  /* Light blue border effect */
     1px -1px 0 #ADD8E6,
    -1px  1px 0 #ADD8E6,
     1px  1px 0 #ADD8E6,
    1px 1px 0px #ffffff,
    2px 2px 0px #cccccc,
    3px 3px 0px #999999; /* White shadow and 3D effect */
  animation: heartbeat 1.5s infinite; /* Heartbeat animation */
}
</style>
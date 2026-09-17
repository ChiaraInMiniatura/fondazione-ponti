import { createApp } from 'vue';
import FiltroProgetti from './components/FiltroProgetti.vue';

const filtroProgettiEl = document.getElementById('filtro-progetti');

if (filtroProgettiEl) {
  createApp(FiltroProgetti).mount(filtroProgettiEl);
}

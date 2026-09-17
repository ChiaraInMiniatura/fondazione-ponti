<!--
  Filtro Progetti per area di intervento — Fase 4.

  Nota di progetto: questo componente NON rifà una fetch REST dei progetti.
  L'archivio (/progetti/) è già interamente renderizzato da WordPress/Blade
  — resta funzionante anche senza JavaScript. Vue si monta solo su questo
  elemento (#filtro-progetti, vedi archive-progetto.blade.php) e si limita
  a mostrare/nascondere le card già presenti nel DOM, leggendo l'attributo
  data-aree impostato da partials/content-progetto.blade.php su ciascuna
  card. Un secondo endpoint REST per lo stesso identico dato sarebbe stato
  ridondante con quello che il server ha già prodotto in HTML.
-->
<script setup>
import { ref, computed } from 'vue';

const mountEl = document.getElementById('filtro-progetti');

const aree = ref([]);
try {
  aree.value = mountEl ? JSON.parse(mountEl.dataset.aree || '[]') : [];
} catch (errore) {
  console.error('FiltroProgetti: dati delle aree non leggibili.', errore);
  aree.value = [];
}

const filtroAttivo = ref('tutti');

const totaleProgetti = computed(
  () => document.querySelectorAll('#griglia-progetti > article').length
);

function applicaFiltro(slug) {
  filtroAttivo.value = slug;

  const card = document.querySelectorAll('#griglia-progetti > article');
  const messaggioVuoto = document.getElementById('filtro-progetti-vuoto');
  let visibili = 0;

  card.forEach((el) => {
    const areeCard = (el.dataset.aree || '').split(' ').filter(Boolean);
    const corrisponde = slug === 'tutti' || areeCard.includes(slug);
    el.classList.toggle('hidden', ! corrisponde);
    if (corrisponde) visibili += 1;
  });

  if (messaggioVuoto) {
    messaggioVuoto.classList.toggle('hidden', visibili > 0);
  }
}
</script>

<template>
  <div v-if="aree.length" class="flex flex-wrap gap-2.5" role="group" aria-label="Filtra per area di intervento">
    <button
      type="button"
      class="rounded-lg border px-4 py-2 text-sm font-semibold transition-colors"
      :class="filtroAttivo === 'tutti'
        ? 'border-bridge bg-bridge/5 text-bridge'
        : 'border-line hover:border-bridge hover:text-bridge'"
      @click="applicaFiltro('tutti')"
    >
      Tutti ({{ totaleProgetti }})
    </button>

    <button
      v-for="area in aree"
      :key="area.slug"
      type="button"
      class="rounded-lg border px-4 py-2 text-sm font-semibold transition-colors"
      :class="filtroAttivo === area.slug
        ? 'border-bridge bg-bridge/5 text-bridge'
        : 'border-line hover:border-bridge hover:text-bridge'"
      @click="applicaFiltro(area.slug)"
    >
      {{ area.name }} ({{ area.count }})
    </button>
  </div>
</template>

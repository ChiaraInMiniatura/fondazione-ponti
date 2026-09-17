<script setup>
// Composition API. Equivalenze rapide con React:
//   ref()       ~ useState
//   computed()  ~ useMemo
//   onMounted() ~ useEffect(() => {...}, [])
import { ref, computed, onMounted } from 'vue';

const progetti = ref([]);
const caricamento = ref(true);
const errore = ref(null);
const areaAttiva = ref(null); // null = "Tutti"

// Le aree di intervento non sono una lista fissa scritta a mano: le
// deriviamo dai progetti stessi, così se in wp-admin aggiungi una nuova
// area il filtro si aggiorna da solo, senza toccare il codice.
const aree = computed(() => {
  const viste = new Map();
  for (const progetto of progetti.value) {
    for (const termine of progetto._embedded?.['wp:term']?.[0] ?? []) {
      viste.set(termine.slug, termine.name);
    }
  }
  return Array.from(viste, ([slug, nome]) => ({ slug, nome }));
});

const progettiFiltrati = computed(() => {
  if (!areaAttiva.value) return progetti.value;
  return progetti.value.filter((progetto) =>
    (progetto._embedded?.['wp:term']?.[0] ?? []).some(
      (termine) => termine.slug === areaAttiva.value
    )
  );
});

onMounted(async () => {
  try {
    // _embed=true fa sì che la risposta includa già i termini di tassonomia
    // (area_intervento) e l'immagine in evidenza, senza dover fare una
    // seconda chiamata API per ciascun progetto.
    const risposta = await fetch('/wp-json/wp/v2/progetto?per_page=50&_embed=true');
    if (!risposta.ok) throw new Error(`Errore HTTP ${risposta.status}`);
    progetti.value = await risposta.json();
  } catch (e) {
    errore.value = e.message;
  } finally {
    caricamento.value = false;
  }
});

function copertina(progetto) {
  return progetto._embedded?.['wp:featuredmedia']?.[0]?.source_url ?? null;
}
</script>

<template>
  <div class="filtro-progetti">
    <div class="flex flex-wrap gap-2 mb-6">
      <button
        type="button"
        class="px-3 py-1 rounded-full border"
        :class="areaAttiva === null ? 'bg-black text-white' : 'bg-white'"
        @click="areaAttiva = null"
      >
        Tutti
      </button>
      <button
        v-for="area in aree"
        :key="area.slug"
        type="button"
        class="px-3 py-1 rounded-full border"
        :class="areaAttiva === area.slug ? 'bg-black text-white' : 'bg-white'"
        @click="areaAttiva = area.slug"
      >
        {{ area.nome }}
      </button>
    </div>

    <p v-if="caricamento">Caricamento progetti...</p>
    <p v-else-if="errore">Errore nel caricamento: {{ errore }}</p>
    <p v-else-if="progettiFiltrati.length === 0">Nessun progetto in questa area.</p>

    <div v-else class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
      <a
        v-for="progetto in progettiFiltrati"
        :key="progetto.id"
        :href="progetto.link"
        class="border rounded overflow-hidden block"
      >
        <img
          v-if="copertina(progetto)"
          :src="copertina(progetto)"
          class="w-full h-40 object-cover"
          alt=""
        />
        <div class="p-3">
          <h3 class="font-bold" v-html="progetto.title.rendered"></h3>
          <div class="text-sm text-gray-600" v-html="progetto.excerpt.rendered"></div>
        </div>
      </a>
    </div>
  </div>
</template>

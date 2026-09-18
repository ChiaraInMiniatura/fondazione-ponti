# Fondazione Ponti

![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)
![WordPress](https://img.shields.io/badge/WordPress-Bedrock-21759B?logo=wordpress&logoColor=white)
![Vue](https://img.shields.io/badge/Vue-3-4FC08D?logo=vuedotjs&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind-v4-06B6D4?logo=tailwindcss&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-B73BFE?logo=vite&logoColor=white)

Sito per una fondazione umanitaria fittizia (Napoli). Progetto di pratica
personale, costruito per allenarmi prima di un incarico vero per un'agenzia:
non è online, non ha uno scopo commerciale reale.

<!-- screenshot / GIF della homepage e del filtro progetti qui -->

## Cosa fa

- **Archivio progetti filtrabile** per area di intervento (Salute, Infanzia,
  Ambiente), senza ricaricare la pagina.
- **Pagina progetto singolo**, con CTA verso la donazione.
- **Pagina "Sostienici"**, hub verso donazione e candidatura volontari.
- **Form di donazione** (simbolico — nessun pagamento reale, dichiarato in
  pagina).
- **Form candidatura volontari**, con validazione e protezione anti-spam; i
  dati restano in un'area riservata, non pubblica.
- **Homepage** con aree di intervento, progetti in evidenza, CTA.
- **Menu responsive**: esteso su desktop, a comparsa su mobile.

## Perché alcune scelte

- **Niente numeri finti.** Il mockup originale prevedeva statistiche globali
  inventate; le ho tolte perché con solo 6 progetti reali sarebbero state
  fuori luogo. Il conteggio progetti per area, invece, è reale.
- **Donazione dichiaratamente simbolica**, per trasparenza verso chi visita
  il sito: un'integrazione di pagamento vera avrebbe richiesto conformità
  PCI-DSS, fuori scopo per un progetto dimostrativo.
- **JavaScript solo dove serve.** L'unico componente interattivo è il filtro
  progetti: si appoggia a contenuto già renderizzato da WordPress e ne
  mostra/nasconde pezzi, invece di richiedere di nuovo i dati — la pagina
  resta utilizzabile anche senza JavaScript.
- **Le candidature non sono contenuto pubblico** del sito: restano visibili
  solo in bacheca amministrativa.

## Sotto il cofano

Per chi vuole vedere lo stack nel dettaglio:

- **[Bedrock](https://roots.io/bedrock/)** — struttura WordPress gestita via
  Composer, configurazione a variabili d'ambiente
- **[Sage](https://roots.io/sage/) + [Acorn](https://roots.io/acorn/)** —
  tema con Blade come motore di template e integrazione Laravel-style
- **Tailwind CSS v4** — design tokens via `@theme`
- **Vite** — build/dev server per gli asset del tema
- **Vue 3** — componenti isolati montati su porzioni di pagina, non una SPA

<details>
<summary>Struttura del progetto</summary>

```
web/app/themes/bluelabs-tema/
├── app/                        # PHP del tema (namespace App\)
│   ├── setup.php                # Bootstrap Sage/Acorn, nav menu, supporti tema
│   ├── cpt.php                  # CPT "Progetto" + tassonomia "Area di intervento"
│   ├── candidature.php          # CPT "Candidatura" + rotta REST custom per il form volontari
│   └── filters.php
├── resources/
│   ├── views/                   # Template Blade (layout, pagine, partial)
│   ├── js/
│   │   ├── app.js                # Entry Vite, monta i componenti Vue sui loro mount point
│   │   └── components/
│   │       └── FiltroProgetti.vue
│   └── css/app.css              # Design tokens Tailwind v4 (@theme)
└── vite.config.js
```

</details>

## Farlo girare in locale

Istruzioni di setup complete in [SETUP.md](./SETUP.md).

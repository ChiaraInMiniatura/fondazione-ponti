# Fondazione Ponti

Sito WordPress per **Fondazione Ponti**, una fondazione umanitaria fittizia
(Napoli). È un progetto di pratica personale, costruito per allenarmi su uno
stack WordPress moderno prima di un incarico vero per un'agenzia — non è un
sito in produzione e non ha uno scopo commerciale reale.

## Stack

- **[Bedrock](https://roots.io/bedrock/)** — struttura WordPress moderna, gestita via Composer, con configurazione a variabili d'ambiente
- **[Sage](https://roots.io/sage/) + [Acorn](https://roots.io/acorn/)** — tema con Blade come motore di template e integrazione Laravel-style
- **Blade** — template del tema
- **Tailwind CSS v4** — design system a token via `@theme` (colori, font, ombre), utility classes
- **Vite** — build/dev server per asset CSS/JS del tema
- **Vue 3** — componenti isolati montati su porzioni specifiche di pagina (niente SPA: il resto è HTML renderizzato da WordPress/Blade)

## Struttura del progetto

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

## Funzionalità

- **Custom Post Type "Progetto"** con tassonomia gerarchica **"Area di
  intervento"** (Salute, Infanzia, Ambiente).
- **Archivio progetti** (`/progetti/`) con **filtro per area** lato client:
  il componente Vue `FiltroProgetti` non richiama una seconda volta i dati
  via REST — le card sono già renderizzate da WordPress/Blade, così la
  pagina resta funzionante anche senza JavaScript, e Vue si limita a
  mostrare/nascondere le card già nel DOM in base all'area selezionata.
- **Pagina singolo progetto** con immagine in evidenza, aree collegate e CTA
  verso la donazione.
- **Pagina "Sostienici"** come hub che rimanda a "Dona" e "Candidati come
  volontario".
- **Pagina "Dona"** — form simbolico (importo + metodo di pagamento). Non è
  collegato a nessun gateway reale: lo dichiara esplicitamente in pagina,
  sia per onestà verso chi visita il sito sia perché un'integrazione di
  pagamento vera richiederebbe chiavi API e conformità PCI-DSS, fuori
  scopo per un progetto dimostrativo.
- **Pagina "Candidati come volontario"** — form reale che invia i dati a una
  rotta REST custom (`POST /wp-json/bluelabs/v1/candidature`), con honeypot
  anti-spam e validazione server-side. Ogni candidatura viene salvata come
  CPT `candidatura` (`public => false`), visibile solo in bacheca WordPress:
  non genera pagine pubbliche né passa dal REST core di WordPress, che
  avrebbe richiesto un utente autenticato con permessi di scrittura.
- **Homepage** con sezione aree di intervento, progetti in evidenza e CTA
  dona/volontariato.
- **Navigazione responsive**: menu desktop da `lg` in su, menu mobile a
  comparsa (hamburger) sotto, con lo stesso menu WordPress renderizzato
  server-side in entrambe le versioni.

## Decisioni di progetto

- **Niente statistiche finte.** Il mockup originale prevedeva una fascia con
  numeri globali inventati (es. "128 progetti, 14 paesi"). È stata tolta:
  con solo 6 progetti reali nel sito, mostrare cifre fittizie sopra
  contenuti veri avrebbe reso il sito internamente incoerente. Il conteggio
  progetti per area che si vede in homepage è invece reale (`get_terms`
  con `count`).
- **Form di donazione dichiaratamente simbolico**, per trasparenza verso chi
  visita il sito piuttosto che simulare un pagamento reale.
- **Vue solo dove serve**, non come framework applicativo: ogni componente
  si monta su un elemento preciso del DOM già renderizzato da WordPress, per
  restare il più vicino possibile a un sito "server-rendered" con
  arricchimenti puntuali lato client.
- **CPT "Candidatura" non pubblico**, con una rotta REST custom invece del
  REST core: i dati delle candidature sono per chi gestisce la Fondazione,
  non contenuto del sito.

## Setup locale

Prerequisiti: PHP ≥ 8.2, Composer, Node.js ≥ 20.19, un server MySQL/MariaDB
locale (es. via Local, Laragon, DBngin...).

```bash
composer install
cp .env.example .env
```

Nel file `.env` appena creato:

- imposta `DB_NAME`, `DB_USER`, `DB_PASSWORD` (e se serve `DB_HOST`) per il
  tuo database locale;
- imposta `WP_HOME` e `WP_SITEURL` (in locale, `http://localhost:8000` e
  `http://localhost:8000/wp`);
- genera le chiavi di sicurezza su https://roots.io/salts.html e sostituisci
  i valori `generateme`.

Poi:

```bash
npm install
npm run dev      # Vite dev server, porta 5173
```

Visita `http://localhost:8000/wp/wp-admin/` per completare l'installazione
di WordPress (se il DB è vuoto) e attivare il tema `bluelabs-tema` da
Aspetto → Temi.

Per la build di produzione degli asset del tema:

```bash
npm run build
```

## Note

Progetto dimostrativo, non pensato per essere messo online così com'è: il
form di donazione non elabora pagamenti reali e i contenuti (progetti,
aree, testi) sono di esempio.

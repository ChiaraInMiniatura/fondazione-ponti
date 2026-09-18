# Setup locale

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

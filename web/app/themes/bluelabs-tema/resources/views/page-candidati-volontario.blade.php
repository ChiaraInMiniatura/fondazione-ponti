{{--
    Pagina "Candidati come volontario" — /candidati-volontario/

    A differenza della pagina Dona, questo form è reale: invia i dati alla
    rotta REST custom /wp-json/bluelabs/v1/candidature (vedi app/candidature.php),
    che salva ogni candidatura come CPT "candidatura" visibile solo in
    bacheca WordPress (Fase 5).
--}}
@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div class="mx-auto max-w-[640px] px-6 py-14">

    <div id="candidatura-form-wrapper">
      <p class="lede !max-w-none">
        {{ __('Cerchiamo competenze mediche, tecniche e didattiche, ma anche solo qualche ora al mese di disponibilità sul campo. Raccontaci qualcosa di te.', 'bluelabs-tema') }}
      </p>

      <form id="form-candidatura" data-endpoint="{{ esc_url(rest_url('bluelabs/v1/candidature')) }}" class="mt-8 flex flex-col gap-5" novalidate>

        {{-- Honeypot anti-spam: invisibile a schermo e ignorato dagli screen reader,
             ma un campo di testo "appetibile" per i bot che compilano tutto. --}}
        <div class="absolute -left-[9999px]" aria-hidden="true">
          <label for="sito_web">{{ __('Non compilare questo campo', 'bluelabs-tema') }}</label>
          <input type="text" id="sito_web" name="sito_web" tabindex="-1" autocomplete="off">
        </div>

        <div>
          <label for="cand-nome" class="mb-1.5 block text-sm font-semibold">{{ __('Nome e cognome', 'bluelabs-tema') }} *</label>
          <input type="text" id="cand-nome" name="nome" required class="w-full rounded-lg border border-line bg-surface px-4 py-3 text-sm focus:border-bridge focus:outline-none">
        </div>

        <div>
          <label for="cand-email" class="mb-1.5 block text-sm font-semibold">{{ __('Email', 'bluelabs-tema') }} *</label>
          <input type="email" id="cand-email" name="email" required class="w-full rounded-lg border border-line bg-surface px-4 py-3 text-sm focus:border-bridge focus:outline-none">
        </div>

        <div>
          <label for="cand-telefono" class="mb-1.5 block text-sm font-semibold">{{ __('Telefono', 'bluelabs-tema') }}</label>
          <input type="tel" id="cand-telefono" name="telefono" class="w-full rounded-lg border border-line bg-surface px-4 py-3 text-sm focus:border-bridge focus:outline-none">
        </div>

        <div>
          <label for="cand-disponibilita" class="mb-1.5 block text-sm font-semibold">{{ __('Disponibilità', 'bluelabs-tema') }} *</label>
          <select id="cand-disponibilita" name="disponibilita" required class="w-full rounded-lg border border-line bg-surface px-4 py-3 text-sm focus:border-bridge focus:outline-none">
            <option value="">{{ __('Seleziona…', 'bluelabs-tema') }}</option>
            <option value="Weekend">{{ __('Weekend', 'bluelabs-tema') }}</option>
            <option value="Sera in settimana">{{ __('Sera in settimana', 'bluelabs-tema') }}</option>
            <option value="Flessibile">{{ __('Flessibile', 'bluelabs-tema') }}</option>
          </select>
        </div>

        <div>
          <label for="cand-messaggio" class="mb-1.5 block text-sm font-semibold">{{ __('Raccontaci le tue competenze (facoltativo)', 'bluelabs-tema') }}</label>
          <textarea id="cand-messaggio" name="messaggio" rows="4" class="w-full rounded-lg border border-line bg-surface px-4 py-3 text-sm focus:border-bridge focus:outline-none"></textarea>
        </div>

        <p id="candidatura-errore" class="hidden text-sm font-medium text-dawn-deep" role="alert"></p>

        <button type="submit" id="candidatura-submit" class="rounded-lg bg-bridge px-5 py-3.5 text-sm font-semibold text-white transition-colors hover:bg-bridge-dark">
          {{ __('Invia candidatura', 'bluelabs-tema') }}
        </button>
      </form>
    </div>

    <div id="candidatura-grazie" class="hidden rounded-xl border border-line bg-surface p-8 text-center">
      <span class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-bridge/10 text-bridge">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </span>
      <h2 class="text-lg font-semibold">{{ __('Candidatura inviata!', 'bluelabs-tema') }}</h2>
      <p class="mt-2 text-sm text-muted">
        {{ __('Grazie per il tuo interesse: ti risponderemo appena possibile.', 'bluelabs-tema') }}
      </p>
      <a href="{{ home_url('/') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-bridge">
        &larr; {{ __('Torna alla home', 'bluelabs-tema') }}
      </a>
    </div>
  </div>

  <script>
    (function () {
      var form = document.getElementById('form-candidatura');
      var errore = document.getElementById('candidatura-errore');
      var submitBtn = document.getElementById('candidatura-submit');
      var wrapper = document.getElementById('candidatura-form-wrapper');
      var grazie = document.getElementById('candidatura-grazie');

      form.addEventListener('submit', function (e) {
        e.preventDefault();
        errore.classList.add('hidden');

        var formData = new FormData(form);
        var payload = Object.fromEntries(formData.entries());

        submitBtn.disabled = true;
        submitBtn.textContent = @json(__('Invio…', 'bluelabs-tema'));

        fetch(form.dataset.endpoint, {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(payload),
        })
          .then(function (res) {
            return res.json().then(function (data) {
              return { ok: res.ok, data: data };
            });
          })
          .then(function (result) {
            if (! result.ok) {
              throw new Error(result.data && result.data.message ? result.data.message : @json(__('Errore imprevisto. Riprova.', 'bluelabs-tema')));
            }
            wrapper.classList.add('hidden');
            grazie.classList.remove('hidden');
          })
          .catch(function (err) {
            errore.textContent = err.message;
            errore.classList.remove('hidden');
            submitBtn.disabled = false;
            submitBtn.textContent = @json(__('Invia candidatura', 'bluelabs-tema'));
          });
      });
    })();
  </script>
@endsection

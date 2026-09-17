{{--
    Pagina "Dona" — /dona/

    Nota di progetto: su richiesta esplicita, questo è un form SIMBOLICO.
    Non è collegato a nessun gateway di pagamento reale (Stripe/PayPal/...):
    lo dichiariamo chiaramente in pagina, sia per onestà verso chi visita
    il sito sia perché un'integrazione di pagamento vera richiederebbe
    chiavi API, gestione PCI-DSS e non ha senso in un progetto dimostrativo.
    L'interazione (scelta importo → conferma) è comunque tutta reale.
--}}
@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div class="mx-auto max-w-[640px] px-6 py-14">

    <div id="dona-form-wrapper">
      <p class="lede !max-w-none">
        {{ __('Scegli un importo, oppure inseriscine uno tuo. Ogni donazione, anche piccola, finanzia ore reali di attività sul territorio.', 'bluelabs-tema') }}
      </p>

      <form id="form-dona" class="mt-8 flex flex-col gap-7" novalidate>
        <div>
          <span class="mb-3 block text-sm font-semibold">{{ __('Importo', 'bluelabs-tema') }}</span>
          <div class="grid grid-cols-4 gap-2.5" role="group" aria-label="{{ __('Importo predefinito', 'bluelabs-tema') }}">
            @foreach ([10, 25, 50, 100] as $importo)
              <button
                type="button"
                class="importo-chip rounded-lg border border-line py-3 text-sm font-semibold transition-colors hover:border-bridge"
                data-importo="{{ $importo }}"
              >
                {{ $importo }}€
              </button>
            @endforeach
          </div>
          <div class="mt-3">
            <label for="importo-custom" class="sr-only">{{ __('Altro importo', 'bluelabs-tema') }}</label>
            <input
              type="number"
              id="importo-custom"
              min="1"
              step="1"
              placeholder="{{ __('Altro importo (€)', 'bluelabs-tema') }}"
              class="w-full rounded-lg border border-line bg-surface px-4 py-3 text-sm focus:border-bridge focus:outline-none"
            >
          </div>
        </div>

        <div>
          <span class="mb-3 block text-sm font-semibold">{{ __('Metodo di pagamento', 'bluelabs-tema') }}</span>
          <div class="grid grid-cols-2 gap-2.5">
            <label class="metodo-radio flex cursor-pointer items-center gap-2.5 rounded-lg border border-line px-4 py-3 text-sm font-medium transition-colors has-[:checked]:border-bridge has-[:checked]:bg-bridge/5">
              <input type="radio" name="metodo" value="carta" checked class="accent-bridge">
              {{ __('Carta di credito', 'bluelabs-tema') }}
            </label>
            <label class="metodo-radio flex cursor-pointer items-center gap-2.5 rounded-lg border border-line px-4 py-3 text-sm font-medium transition-colors has-[:checked]:border-bridge has-[:checked]:bg-bridge/5">
              <input type="radio" name="metodo" value="paypal" class="accent-bridge">
              PayPal
            </label>
          </div>
        </div>

        <p id="dona-errore" class="hidden text-sm font-medium text-dawn-deep" role="alert"></p>

        <button type="submit" class="rounded-lg bg-dawn px-5 py-3.5 text-sm font-semibold text-white transition-colors hover:bg-dawn-deep">
          {{ __('Dona ora', 'bluelabs-tema') }}
        </button>

        <p class="text-xs leading-relaxed text-muted">
          {{ __('Progetto dimostrativo: questo form non elabora pagamenti reali. In un sito in produzione qui sarebbe collegato a un gestore di pagamenti certificato (es. Stripe o PayPal).', 'bluelabs-tema') }}
        </p>
      </form>
    </div>

    <div id="dona-grazie" class="hidden rounded-xl border border-line bg-surface p-8 text-center">
      <span class="mb-4 inline-flex h-12 w-12 items-center justify-center rounded-full bg-bridge/10 text-bridge">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
          <path d="M20 6 9 17l-5-5"/>
        </svg>
      </span>
      <h2 class="text-lg font-semibold">{{ __('Grazie di cuore!', 'bluelabs-tema') }}</h2>
      <p id="dona-grazie-dettaglio" class="mt-2 text-sm text-muted"></p>
      <a href="{{ home_url('/') }}" class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-bridge">
        &larr; {{ __('Torna alla home', 'bluelabs-tema') }}
      </a>
    </div>
  </div>

  <script>
    (function () {
      var form = document.getElementById('form-dona');
      var chips = document.querySelectorAll('.importo-chip');
      var customInput = document.getElementById('importo-custom');
      var errore = document.getElementById('dona-errore');
      var wrapper = document.getElementById('dona-form-wrapper');
      var grazie = document.getElementById('dona-grazie');
      var grazieDettaglio = document.getElementById('dona-grazie-dettaglio');
      var importoSelezionato = null;

      chips.forEach(function (chip) {
        chip.addEventListener('click', function () {
          chips.forEach(function (c) {
            c.classList.remove('border-bridge', 'bg-bridge/5', 'text-bridge');
          });
          chip.classList.add('border-bridge', 'bg-bridge/5', 'text-bridge');
          importoSelezionato = chip.dataset.importo;
          customInput.value = '';
        });
      });

      customInput.addEventListener('input', function () {
        if (customInput.value) {
          importoSelezionato = null;
          chips.forEach(function (c) {
            c.classList.remove('border-bridge', 'bg-bridge/5', 'text-bridge');
          });
        }
      });

      form.addEventListener('submit', function (e) {
        e.preventDefault();

        var importo = customInput.value ? parseFloat(customInput.value) : parseFloat(importoSelezionato);
        if (! importo || importo <= 0) {
          errore.textContent = @json(__('Scegli o inserisci un importo valido prima di continuare.', 'bluelabs-tema'));
          errore.classList.remove('hidden');
          return;
        }
        errore.classList.add('hidden');

        var metodo = form.querySelector('input[name="metodo"]:checked').value;
        var metodoLabel = metodo === 'paypal' ? 'PayPal' : @json(__('carta di credito', 'bluelabs-tema'));

        grazieDettaglio.textContent = importo.toFixed(0) + '€ · ' + metodoLabel;
        wrapper.classList.add('hidden');
        grazie.classList.remove('hidden');
      });
    })();
  </script>
@endsection

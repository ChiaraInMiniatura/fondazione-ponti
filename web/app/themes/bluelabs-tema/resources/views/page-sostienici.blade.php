{{--
    Pagina "Sostienici" — /sostienici/
    Hub che spiega le due strade per aiutare la Fondazione e rimanda
    alle pagine dedicate /dona/ e /candidati-volontario/.
--}}
@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div class="mx-auto max-w-[880px] px-6 py-14">
    <p class="lede !max-w-none">
      {{ __("Un ponte si costruisce in due. Che tu possa mettere a disposizione del tempo o delle risorse, c'è un modo concreto per far parte dei progetti della Fondazione.", 'bluelabs-tema') }}
    </p>

    <div class="mt-10 grid grid-cols-1 gap-5.5 sm:grid-cols-2">
      <article class="flex flex-col justify-between gap-6 rounded-xl border border-line bg-surface p-7 shadow-card">
        <div>
          <span class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-dawn/10 text-dawn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M12 21s-7-4.6-9.5-9C.7 8.2 2.6 4 6.7 4c2 0 3.6 1 4.3 2.4C11.7 5 13.3 4 15.3 4 19.4 4 21.3 8.2 19.5 12c-2.5 4.4-9.5 9-9.5 9z"/>
            </svg>
          </span>
          <h2 class="text-lg font-semibold">{{ __('Fai una donazione', 'bluelabs-tema') }}</h2>
          <p class="mt-2 text-sm leading-relaxed text-muted">
            {{ __('Anche un contributo minimo finanzia ore reali di screening, doposcuola o interventi sul territorio. Scegli un importo o inserisci il tuo.', 'bluelabs-tema') }}
          </p>
        </div>
        <a href="{{ home_url('/dona/') }}" class="inline-flex items-center gap-2 self-start rounded-lg bg-dawn px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-dawn-deep">
          {{ __('Dona ora', 'bluelabs-tema') }} <span aria-hidden="true">&rarr;</span>
        </a>
      </article>

      <article class="flex flex-col justify-between gap-6 rounded-xl border border-line bg-surface p-7 shadow-card">
        <div>
          <span class="mb-4 flex h-10 w-10 items-center justify-center rounded-lg bg-bridge/10 text-bridge">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
              <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/>
            </svg>
          </span>
          <h2 class="text-lg font-semibold">{{ __('Diventa volontario', 'bluelabs-tema') }}</h2>
          <p class="mt-2 text-sm leading-relaxed text-muted">
            {{ __('Cerchiamo competenze mediche, tecniche e didattiche, ma anche solo qualche ora al mese di disponibilità sul campo.', 'bluelabs-tema') }}
          </p>
        </div>
        <a href="{{ home_url('/candidati-volontario/') }}" class="inline-flex items-center gap-2 self-start rounded-lg border border-line px-5 py-2.5 text-sm font-semibold transition-colors hover:border-bridge hover:text-bridge">
          {{ __('Candidati', 'bluelabs-tema') }} <span aria-hidden="true">&rarr;</span>
        </a>
      </article>
    </div>
  </div>
@endsection

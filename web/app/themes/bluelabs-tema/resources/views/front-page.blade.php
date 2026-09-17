{{--
    Homepage — attiva se in Impostazioni > Lettura la home è impostata su
    "una pagina statica". Design applicato dal mockup Fondazione Ponti.

    Nota di progetto: rispetto al mockup originale ho tolto la fascia di
    statistiche globali con numeri inventati (128 progetti, 14 paesi...):
    con solo 6 progetti reali nel sito, mostrare cifre fittizie sopra i
    contenuti veri avrebbe reso il sito internamente incoerente. Le aree
    di intervento mostrano già un conteggio reale (get_terms 'count').
--}}
@extends('layouts.app')

@section('content')

  {{-- Hero --}}
  <section class="relative overflow-hidden border-b border-line">
    <div class="relative z-10 mx-auto max-w-[1120px] px-6 pb-24 pt-20">
      <span class="eyebrow mb-3.5 block">{{ __('Fondazione Ponti · dal 2010', 'bluelabs-tema') }}</span>
      <h1 class="max-w-[16ch] text-[clamp(2.1rem,4.6vw,3.4rem)] font-medium leading-[1.08]">
        {{ __('Costruiamo ponti dove servono più che mai.', 'bluelabs-tema') }}
      </h1>
      <p class="lede mt-5">
        {{ __("Portiamo sanità, istruzione e cura dell'ambiente nei quartieri che il resto della città fatica a raggiungere — con progetti costruiti insieme a chi ci vive.", 'bluelabs-tema') }}
      </p>
      <div class="mt-8 flex flex-wrap gap-3.5">
        <a href="#aiuto" class="inline-flex items-center gap-2 rounded-lg bg-dawn px-5 py-3 text-sm font-semibold text-white transition-colors hover:bg-dawn-deep">
          {{ __('Sostieni un progetto', 'bluelabs-tema') }}
        </a>
        <a href="#aree" class="inline-flex items-center gap-2 rounded-lg border border-line px-5 py-3 text-sm font-semibold transition-colors hover:border-bridge hover:text-bridge">
          {{ __('Scopri le aree di intervento', 'bluelabs-tema') }}
        </a>
      </div>
    </div>

    <div class="pointer-events-none absolute inset-x-0 bottom-0 z-0 opacity-90" aria-hidden="true">
      <svg viewBox="0 0 1200 160" preserveAspectRatio="none" class="block h-auto w-full">
        <path d="M0,160 L0,140 C 200,40 350,20 600,20 C 850,20 1000,40 1200,140 L1200,160 Z" fill="var(--color-bridge)" opacity="0.14"/>
        <path d="M0,160 L0,150 C 220,70 380,52 600,52 C 820,52 980,70 1200,150 L1200,160 Z" fill="var(--color-bridge)" opacity="0.22"/>
      </svg>
    </div>
  </section>

  {{-- Aree di intervento --}}
  @php
    $aree_intervento = get_terms(['taxonomy' => 'area_intervento', 'hide_empty' => true]);
    $aree_intervento = (! is_wp_error($aree_intervento)) ? $aree_intervento : [];

    $area_icons = [
      'salute' => '<path d="M12 21s-7-4.6-9.5-9C.7 8.2 2.6 4 6.7 4c2 0 3.6 1 4.3 2.4C11.7 5 13.3 4 15.3 4 19.4 4 21.3 8.2 19.5 12c-2.5 4.4-9.5 9-9.5 9z"/>',
      'infanzia' => '<path d="M22 10 12 5 2 10l10 5 10-5Z"/><path d="M6 12v5c0 1.7 2.7 3 6 3s6-1.3 6-3v-5"/>',
      'ambiente' => '<path d="M12 2c4 5 6 8.5 6 12a6 6 0 0 1-12 0c0-3.5 2-7 6-12Z"/>',
    ];
    $default_icon = '<circle cx="12" cy="12" r="8"/>';

    // Un colore d'accento diverso per area. Salute e Infanzia riusano
    // bridge/dawn già definiti in resources/css/app.css; per Ambiente
    // bridge-dark risultava troppo simile a bridge alla stessa opacità
    // (l'ho visto nello screenshot, non solo "sulla carta"), quindi qui
    // uso un verde puntuale via valore arbitrario Tailwind, senza aggiungere
    // un nuovo token al design system.
    $area_colors = [
      'salute' => ['bg' => 'bg-bridge/10', 'text' => 'text-bridge'],
      'infanzia' => ['bg' => 'bg-dawn/10', 'text' => 'text-dawn'],
      'ambiente' => ['bg' => 'bg-[#4f7a5c]/10', 'text' => 'text-[#4f7a5c]'],
    ];
    $default_color = ['bg' => 'bg-bridge/10', 'text' => 'text-bridge'];
  @endphp

  @if (! empty($aree_intervento))
    <section id="aree" class="py-18">
      <div class="mx-auto max-w-[1120px] px-6">
        <div class="mb-9 flex flex-wrap items-end justify-between gap-6">
          <h2 class="text-[clamp(1.5rem,2.6vw,2rem)] font-medium">
            {{ __('Le nostre aree di intervento', 'bluelabs-tema') }}
          </h2>
          <p class="lede !max-w-none !mb-0">
            {{ __('Fronti su cui lavoriamo in modo continuativo, non emergenziale.', 'bluelabs-tema') }}
          </p>
        </div>

        <div class="grid grid-cols-1 gap-px overflow-hidden rounded-xl border border-line bg-line sm:grid-cols-3">
          @foreach ($aree_intervento as $area)
            @php
              $colore = $area_colors[$area->slug] ?? $default_color;
            @endphp
            <a
              href="{{ get_term_link($area) }}"
              class="flex flex-col items-center gap-1.5 bg-surface p-8 text-center transition-colors hover:bg-paper"
            >
              <span class="mb-2.5 flex h-14 w-14 items-center justify-center rounded-full {{ $colore['bg'] }} {{ $colore['text'] }}">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                  {!! $area_icons[$area->slug] ?? $default_icon !!}
                </svg>
              </span>
              <h3 class="text-base font-semibold">{{ $area->name }}</h3>
              <p class="text-sm text-muted">
                {{ $area->count }} {{ _n('progetto', 'progetti', $area->count, 'bluelabs-tema') }}
              </p>
            </a>
          @endforeach
        </div>
      </div>
    </section>
  @endif

  {{-- Progetti in evidenza --}}
  @php
    $progetti_in_evidenza = new \WP_Query([
        'post_type' => 'progetto',
        'posts_per_page' => 3,
        'orderby' => 'date',
        'order' => 'DESC',
    ]);
  @endphp

  @if ($progetti_in_evidenza->have_posts())
    <section id="progetti" class="py-18">
      <div class="mx-auto max-w-[1120px] px-6">
        <div class="mb-9 flex flex-wrap items-end justify-between gap-6">
          <h2 class="text-[clamp(1.5rem,2.6vw,2rem)] font-medium">
            {{ __('Progetti in evidenza', 'bluelabs-tema') }}
          </h2>
          <a href="{{ get_post_type_archive_link('progetto') }}" class="inline-flex items-center gap-2 rounded-lg border border-line px-5 py-3 text-sm font-semibold transition-colors hover:border-bridge hover:text-bridge">
            {{ __('Vedi tutti i progetti', 'bluelabs-tema') }}
          </a>
        </div>

        <div class="grid grid-cols-1 gap-5.5 sm:grid-cols-2 lg:grid-cols-3">
          @while ($progetti_in_evidenza->have_posts()) @php($progetti_in_evidenza->the_post())
            @include('partials.content-progetto')
          @endwhile
        </div>
      </div>
    </section>

    @php(wp_reset_postdata())
  @endif

  {{-- CTA Dona / Volontariato --}}
  <section id="aiuto" class="py-18">
    <div class="mx-auto max-w-[1120px] px-6">
      <div class="rounded-[20px] bg-bridge-dark text-[#F3F6F6]">
        <div class="grid grid-cols-1 gap-10 p-10 sm:grid-cols-[1.1fr_1fr]">
          <div>
            <h2 class="text-[clamp(1.5rem,2.8vw,2.1rem)] font-medium text-white">
              {{ __('Un ponte si costruisce in due.', 'bluelabs-tema') }}
            </h2>
            <p class="mt-3.5 max-w-[60ch] text-white/75">
              {{ __('Che tu possa dare tempo o risorse, cè un modo concreto per far parte di questi progetti.', 'bluelabs-tema') }}
            </p>
          </div>

          <div class="flex flex-col gap-3.5">
            <div class="flex flex-wrap items-center justify-between gap-4 rounded-xl border border-white/15 bg-white/5 px-5 py-4">
              <div>
                <h3 class="text-sm font-semibold text-white">{{ __('Fai una donazione', 'bluelabs-tema') }}</h3>
                <p class="text-sm text-white/70">{{ __('Anche 20€ finanziano una settimana di attività.', 'bluelabs-tema') }}</p>
              </div>
              <a href="{{ home_url('/dona/') }}" class="shrink-0 rounded-lg bg-dawn px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-dawn-deep">
                {{ __('Dona', 'bluelabs-tema') }}
              </a>
            </div>

            <div class="flex flex-wrap items-center justify-between gap-4 rounded-xl border border-white/15 bg-white/5 px-5 py-4">
              <div>
                <h3 class="text-sm font-semibold text-white">{{ __('Diventa volontario', 'bluelabs-tema') }}</h3>
                <p class="text-sm text-white/70">{{ __('Cerchiamo competenze mediche, tecniche e didattiche.', 'bluelabs-tema') }}</p>
              </div>
              <a href="{{ home_url('/candidati-volontario/') }}" class="shrink-0 rounded-lg border border-white/30 px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:border-white">
                {{ __('Candidati', 'bluelabs-tema') }}
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection

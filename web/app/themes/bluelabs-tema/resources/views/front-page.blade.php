{{--
    Homepage — attiva SOLO se in Impostazioni > Lettura la home è impostata
    su "una pagina statica" (altrimenti WordPress continua a usare
    index.blade.php). Qui componiamo le sezioni del mockup: hero, aree di
    intervento, progetti in evidenza, CTA. Le classi Tailwind qui sotto sono
    strutturali/di base: la palette e la cura visiva vera arrivano in Fase 3.
--}}
@extends('layouts.app')

@section('content')

  {{-- Hero --}}
  <section class="py-20 text-center">
    <h1 class="text-4xl font-bold sm:text-5xl">
      {{ __('Fondazione Ponti', 'bluelabs-tema') }}
    </h1>
    <p class="mx-auto mt-4 max-w-xl text-lg text-gray-600">
      {{ __('Costruiamo collegamenti tra chi ha bisogno e chi può aiutare.', 'bluelabs-tema') }}
    </p>
  </section>

  {{-- Aree di intervento --}}
  @php
    $aree_intervento = get_terms([
        'taxonomy' => 'area_intervento',
        'hide_empty' => true,
    ]);
    $aree_intervento = (! is_wp_error($aree_intervento)) ? $aree_intervento : [];
  @endphp

  @if (! empty($aree_intervento))
    <section class="py-16">
      <h2 class="mb-8 text-center text-2xl font-semibold">
        {{ __('Le nostre aree di intervento', 'bluelabs-tema') }}
      </h2>

      <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
        @foreach ($aree_intervento as $area)
          <a
            href="{{ get_term_link($area) }}"
            class="rounded-lg border border-gray-200 p-6 text-center transition hover:border-gray-400"
          >
            <h3 class="text-lg font-medium">{{ $area->name }}</h3>
            <p class="mt-1 text-sm text-gray-500">
              {{ $area->count }} {{ __('progetti', 'bluelabs-tema') }}
            </p>
          </a>
        @endforeach
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
    <section class="py-16">
      <h2 class="mb-8 text-center text-2xl font-semibold">
        {{ __('Progetti in evidenza', 'bluelabs-tema') }}
      </h2>

      <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
        @while ($progetti_in_evidenza->have_posts()) @php($progetti_in_evidenza->the_post())
          @include('partials.content-progetto')
        @endwhile
      </div>
    </section>

    @php(wp_reset_postdata())
  @endif

  {{-- CTA Dona / Volontariato --}}
  <section class="rounded-lg py-16 text-center">
    <h2 class="text-2xl font-semibold">
      {{ __('Sostienici', 'bluelabs-tema') }}
    </h2>
    <p class="mx-auto mt-2 max-w-xl text-gray-600">
      {{ __('Con una donazione o il tuo tempo, puoi aiutarci a costruire nuovi collegamenti.', 'bluelabs-tema') }}
    </p>
    <div class="mt-6 flex justify-center gap-4">
      <a href="#" class="rounded-full px-6 py-3 font-medium text-white" style="background-color: #2E5266;">
        {{ __('Dona ora', 'bluelabs-tema') }}
      </a>
      <a href="#" class="rounded-full border px-6 py-3 font-medium">
        {{ __('Diventa volontario', 'bluelabs-tema') }}
      </a>
    </div>
  </section>

@endsection

{{--
    Archivio dei Progetti — /progetti/

    Fase 4: filtro per area di intervento. Il componente Vue
    "FiltroProgetti" (resources/js/components/FiltroProgetti.vue) non fa
    una seconda chiamata REST: le card sono già renderizzate da WordPress/
    Blade (quindi la pagina funziona anche senza JavaScript) e Vue si monta
    solo sulla barra dei filtri, mostrando/nascondendo le card già presenti
    nel DOM in base all'attributo data-aree di ciascuna (vedi
    partials/content-progetto.blade.php).
--}}
@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  @php
    $aree_intervento = get_terms(['taxonomy' => 'area_intervento', 'hide_empty' => true]);
    $aree_intervento = (! is_wp_error($aree_intervento)) ? $aree_intervento : [];
    $aree_per_filtro = collect($aree_intervento)->map(fn ($area) => [
        'slug' => $area->slug,
        'name' => $area->name,
        'count' => $area->count,
    ])->values();
  @endphp

  <div class="mx-auto max-w-[1120px] px-6 py-14">
    @if ($aree_per_filtro->isNotEmpty())
      <div id="filtro-progetti" class="mb-8" data-aree="{{ $aree_per_filtro->toJson() }}"></div>
    @endif

    <div id="griglia-progetti" class="grid grid-cols-1 gap-5.5 sm:grid-cols-2 lg:grid-cols-3">
      @while(have_posts()) @php(the_post())
        @include('partials.content-progetto')
      @endwhile
    </div>

    <p id="filtro-progetti-vuoto" class="hidden mt-6 text-sm text-muted">
      {{ __('Nessun progetto trovato per questa area.', 'bluelabs-tema') }}
    </p>

    <div class="mt-10">
      {!! get_the_posts_navigation() !!}
    </div>
  </div>
@endsection

{{--
    Card di un singolo progetto nell'elenco (usata da archive-progetto.blade.php
    e, più avanti nella Fase 4, dal componente Vue FiltroProgetti come "forma"
    di riferimento per il markup).

    get_the_terms() restituisce un array di WP_Term (o WP_Error se qualcosa
    va storto: per questo controlliamo is_wp_error/!empty prima di ciclarlo).
--}}
@php
  $aree = get_the_terms(get_the_ID(), 'area_intervento');
  $aree = (! empty($aree) && ! is_wp_error($aree)) ? $aree : [];
@endphp

<article @php(post_class('flex flex-col overflow-hidden rounded-lg border border-gray-200'))>
  @if (has_post_thumbnail())
    <a href="{{ get_permalink() }}" class="block aspect-[4/3] overflow-hidden">
      {!! get_the_post_thumbnail(get_the_ID(), 'medium', ['class' => 'h-full w-full object-cover']) !!}
    </a>
  @endif

  <div class="flex flex-1 flex-col gap-2 p-4">
    @if (! empty($aree))
      <div class="flex flex-wrap gap-2">
        @foreach ($aree as $area)
          <span class="text-xs font-medium uppercase tracking-wide text-gray-500">
            {{ $area->name }}
          </span>
        @endforeach
      </div>
    @endif

    <h2 class="text-lg font-semibold">
      <a href="{{ get_permalink() }}">{{ get_the_title() }}</a>
    </h2>

    <div class="text-sm text-gray-600">
      {{ get_the_excerpt() }}
    </div>

    <a href="{{ get_permalink() }}" class="mt-auto text-sm font-medium">
      {{ __('Scopri di più', 'bluelabs-tema') }} &rarr;
    </a>
  </div>
</article>

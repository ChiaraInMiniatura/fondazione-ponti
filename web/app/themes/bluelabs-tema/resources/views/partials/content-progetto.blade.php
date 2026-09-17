{{--
    Card di un progetto — usata nell'archivio, nella homepage
    (progetti in evidenza) e, in Fase 4, come "forma" di riferimento per
    il componente Vue del filtro.
--}}
@php
  $aree = get_the_terms(get_the_ID(), 'area_intervento');
  $aree = (! empty($aree) && ! is_wp_error($aree)) ? $aree : [];
  $area_principale = $aree[0] ?? null;
@endphp

<article
  @php(post_class('flex flex-col overflow-hidden rounded-[14px] border border-line bg-surface shadow-card'))
  data-aree="{{ collect($aree)->pluck('slug')->implode(' ') }}"
>
  <a href="{{ get_permalink() }}" class="relative block aspect-[4/3] overflow-hidden bg-bridge">
    @if (has_post_thumbnail())
      {!! get_the_post_thumbnail(get_the_ID(), 'medium_large', ['class' => 'h-full w-full object-cover', 'loading' => 'lazy']) !!}
    @endif

    @if ($area_principale)
      <span class="absolute left-3.5 top-3.5 rounded-full bg-white/92 px-2.5 py-1 text-[0.72rem] font-bold uppercase tracking-wide text-bridge-dark">
        {{ $area_principale->name }}
      </span>
    @endif
  </a>

  <div class="flex flex-1 flex-col gap-2 p-5">
    <h3 class="text-lg font-semibold leading-snug">
      <a href="{{ get_permalink() }}" class="hover:text-bridge">{{ get_the_title() }}</a>
    </h3>

    <div class="text-sm leading-relaxed text-muted">
      {{ get_the_excerpt() }}
    </div>

    <a href="{{ get_permalink() }}" class="mt-2.5 inline-flex items-center gap-1.5 text-sm font-semibold text-bridge">
      {{ __('Scopri di più', 'bluelabs-tema') }} <span aria-hidden="true">&rarr;</span>
    </a>
  </div>
</article>

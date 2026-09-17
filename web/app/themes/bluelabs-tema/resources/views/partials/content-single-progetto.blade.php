{{--
    Contenuto del singolo progetto: qui prende forma la pagina di dettaglio.
--}}
@php
  $aree = get_the_terms(get_the_ID(), 'area_intervento');
  $aree = (! empty($aree) && ! is_wp_error($aree)) ? $aree : [];
@endphp

<article @php(post_class())>
  @if (has_post_thumbnail())
    <div class="mb-6 aspect-[16/9] overflow-hidden rounded-lg">
      {!! get_the_post_thumbnail(get_the_ID(), 'large', ['class' => 'h-full w-full object-cover']) !!}
    </div>
  @endif

  @if (! empty($aree))
    <div class="mb-3 flex flex-wrap gap-2">
      @foreach ($aree as $area)
        <a
          href="{{ get_term_link($area) }}"
          class="rounded-full border px-3 py-1 text-xs font-medium uppercase tracking-wide"
        >
          {{ $area->name }}
        </a>
      @endforeach
    </div>
  @endif

  <h1 class="mb-4 text-3xl font-bold">{{ get_the_title() }}</h1>

  <div class="prose max-w-none">
    {!! get_the_content() !!}
  </div>
</article>

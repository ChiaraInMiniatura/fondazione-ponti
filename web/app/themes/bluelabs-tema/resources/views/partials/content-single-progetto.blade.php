{{--
    Contenuto del singolo progetto.
--}}
@php
  $aree = get_the_terms(get_the_ID(), 'area_intervento');
  $aree = (! empty($aree) && ! is_wp_error($aree)) ? $aree : [];
@endphp

<article @php(post_class())>
  @if (has_post_thumbnail())
    <div class="aspect-[21/9] w-full overflow-hidden bg-bridge">
      {!! get_the_post_thumbnail(get_the_ID(), 'large', ['class' => 'h-full w-full object-cover object-top']) !!}
    </div>
  @endif

  <div class="mx-auto max-w-[760px] px-6 py-12">
    <a
      href="{{ get_post_type_archive_link('progetto') }}"
      class="mb-6 inline-flex items-center gap-1.5 text-sm font-semibold text-muted hover:text-bridge"
    >
      <span aria-hidden="true">&larr;</span> {{ __('Tutti i progetti', 'bluelabs-tema') }}
    </a>

    @if (! empty($aree))
      <div class="mb-4 flex flex-wrap gap-2">
        @foreach ($aree as $area)
          <a
            href="{{ get_term_link($area) }}"
            class="rounded-full border border-line px-3 py-1 text-xs font-bold uppercase tracking-wide text-bridge-dark transition-colors hover:border-bridge"
          >
            {{ $area->name }}
          </a>
        @endforeach
      </div>
    @endif

    <h1 class="mb-6 text-[clamp(1.8rem,3.6vw,2.6rem)] font-medium leading-tight">
      {{ get_the_title() }}
    </h1>

    <div class="prose prose-neutral max-w-none prose-headings:font-display prose-a:text-bridge">
      {!! get_the_content() !!}
    </div>

    <div class="mt-10 flex flex-wrap items-center justify-between gap-4 rounded-xl border border-line bg-surface px-6 py-5">
      <div>
        <h2 class="text-base font-semibold">{{ __('Vuoi sostenere questo progetto?', 'bluelabs-tema') }}</h2>
        <p class="text-sm text-muted">{{ __('Il tuo contributo aiuta a portarlo avanti.', 'bluelabs-tema') }}</p>
      </div>
      <a
        href="{{ home_url('/#aiuto') }}"
        class="shrink-0 rounded-lg bg-dawn px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-dawn-deep"
      >
        {{ __('Dona ora', 'bluelabs-tema') }}
      </a>
    </div>
  </div>
</article>

<header class="sticky top-0 z-20 border-b border-line bg-paper/90 backdrop-blur">
  <div class="mx-auto flex max-w-[1120px] items-center justify-between gap-4 px-6 py-4">
    <a class="flex items-center gap-3 font-display text-2xl font-bold tracking-tight" href="{{ home_url('/') }}">
      <svg width="34" height="26" viewBox="0 0 26 20" fill="none" aria-hidden="true" class="shrink-0">
        <path d="M1 17C1 17 4 6 13 6C22 6 25 17 25 17" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" style="color:var(--color-bridge)"/>
        <line x1="1" y1="17" x2="25" y2="17" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" style="color:var(--color-dawn)"/>
      </svg>
      {!! $siteName !!}
    </a>

    @if (has_nav_menu('primary_navigation'))
      <nav
        class="hidden items-center gap-7 text-sm font-medium sm:flex [&_a]:text-muted [&_a]:transition-colors [&_a:hover]:text-ink"
        aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}"
      >
        {!! wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'menu_class' => 'flex items-center gap-7',
            'container' => false,
            'echo' => false,
        ]) !!}
      </nav>
    @endif

    <a
      href="{{ home_url('/sostienici/') }}"
      class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-dawn px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-dawn-deep"
    >
      {{ __('Sostienici', 'bluelabs-tema') }}
    </a>
  </div>
</header>

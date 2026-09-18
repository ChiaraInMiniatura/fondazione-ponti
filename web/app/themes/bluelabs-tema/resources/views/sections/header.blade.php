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
        class="hidden items-center gap-7 text-sm font-medium lg:flex [&_a]:text-muted [&_a]:transition-colors [&_a:hover]:text-ink"
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

    <div class="flex shrink-0 items-center gap-3">
      <a
        href="{{ home_url('/sostienici/') }}"
        class="inline-flex shrink-0 items-center gap-2 rounded-lg bg-dawn px-5 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-dawn-deep"
      >
        {{ __('Sostienici', 'bluelabs-tema') }}
      </a>

      @if (has_nav_menu('primary_navigation'))
        <button
          type="button"
          id="menu-mobile-toggle"
          aria-expanded="false"
          aria-controls="menu-mobile"
          class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-lg border border-line text-ink lg:hidden"
        >
          <span class="sr-only">{{ __('Apri il menu', 'bluelabs-tema') }}</span>
          <svg id="menu-mobile-icon-open" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round">
            <line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>
          </svg>
          <svg id="menu-mobile-icon-close" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" class="hidden">
            <line x1="6" y1="6" x2="18" y2="18"/><line x1="18" y1="6" x2="6" y2="18"/>
          </svg>
        </button>
      @endif
    </div>
  </div>

  @if (has_nav_menu('primary_navigation'))
    <nav
      id="menu-mobile"
      class="hidden border-t border-line bg-paper lg:hidden"
      aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}"
    >
      <div class="mx-auto max-w-[1120px] px-6 py-3">
        {!! wp_nav_menu([
            'theme_location' => 'primary_navigation',
            'menu_class' => 'flex flex-col text-sm font-medium [&_a]:block [&_a]:rounded-lg [&_a]:px-3 [&_a]:py-3 [&_a]:text-muted [&_a:hover]:bg-surface [&_a:hover]:text-ink',
            'container' => false,
            'echo' => false,
        ]) !!}
      </div>
    </nav>
  @endif
</header>

@if (has_nav_menu('primary_navigation'))
  <script>
    (function () {
      var toggle = document.getElementById('menu-mobile-toggle');
      var menu = document.getElementById('menu-mobile');
      var iconOpen = document.getElementById('menu-mobile-icon-open');
      var iconClose = document.getElementById('menu-mobile-icon-close');
      if (! toggle || ! menu) return;

      toggle.addEventListener('click', function () {
        var isOpen = ! menu.classList.contains('hidden');
        menu.classList.toggle('hidden');
        iconOpen.classList.toggle('hidden');
        iconClose.classList.toggle('hidden');
        toggle.setAttribute('aria-expanded', String(! isOpen));
      });
    })();
  </script>
@endif

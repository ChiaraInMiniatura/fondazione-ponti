{{--
    Pagina di un singolo progetto — /progetti/nome-progetto/
--}}
@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.content-single-progetto')

    @if (comments_open() || get_comments_number())
      <div class="mx-auto max-w-[760px] px-6 pb-16">
        @include('partials.comments')
      </div>
    @endif
  @endwhile
@endsection

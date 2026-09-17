{{--
    Archivio dei Progetti — /progetti/

    WordPress sceglie questo file automaticamente per l'URL dell'archivio
    del CPT "progetto", grazie alla convenzione di nome
    "archive-{post_type}.blade.php". Il ciclo sotto usa have_posts()/the_post(),
    le stesse funzioni core di index.blade.php: qui stiamo solo dicendo a
    WordPress "in questo contesto, per ogni progetto, usa questa card".
--}}
@extends('layouts.app')

@section('content')
  @include('partials.page-header')

  <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
    @while(have_posts()) @php(the_post())
      @include('partials.content-progetto')
    @endwhile
  </div>

  {!! get_the_posts_navigation() !!}
@endsection

@section('sidebar')
  @include('sections.sidebar')
@endsection

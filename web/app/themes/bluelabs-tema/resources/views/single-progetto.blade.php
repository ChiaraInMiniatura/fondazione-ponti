{{--
    Pagina di un singolo progetto — /progetti/nome-progetto/

    Speculare a single.blade.php, ma dedicata al CPT "progetto" grazie
    alla convenzione "single-{post_type}.blade.php": WordPress la sceglie
    automaticamente al posto di quella generica.
--}}
@extends('layouts.app')

@section('content')
  @while(have_posts()) @php(the_post())
    @include('partials.content-single-progetto')

    @if (comments_open() || get_comments_number())
      @include('partials.comments')
    @endif
  @endwhile
@endsection

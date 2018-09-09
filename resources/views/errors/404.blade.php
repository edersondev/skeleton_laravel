@extends('layouts.error')

@push('css')
  <link rel="stylesheet" href="{{ URL::asset('css/errors/error_404.css') }}">
@endpush

@section('title')
  <i class="fas fa-exclamation-triangle text-warning"></i> Oops! Página não encontrada.
@endsection

@section('content')

<div class="error-page">

  <div class="error-content">
    <p>
      A página pode ter mudado de nome ou nunca ter existido.
    </p>

    @if (env('APP_DEBUG') === true)
      <p>{{ $exception->getMessage() }}</p>
    @endif

  </div>
</div>

@endsection

@push('js')
<script>
  function random() {
    var radom = Math.floor(Math.random() * 16) + 1,
    pathGifs = "{{ asset('gifs') }}";
    $('body').css('background-image', `url(${pathGifs}/gif-${radom}.gif)`);
  }

  $(function(){
    random();

    $('body').keyup(function(e){
      if(e.keyCode == 32){
        random();
      }
    });

  });
</script>
@endpush
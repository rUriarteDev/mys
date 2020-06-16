@extends('layout.mainlayout')

@section('content')
<div class="card border-primary mb-3 mx-auto" style="width: 50%">
    <div class="card-body">
      <h5 class="card-title">Modelo de hidrologia</h5>
      <p class="card-text">La Hidrología en su definición más simple es la ciencia que estudia la distribución,
        cuantificación y utilización de los recursos hídricos que están disponibles en el globo terrestre.
        Estos recursos se distribuyen en la atmósfera, la superficie terrestre y las capas del suelo.</p>
      <a href="{{route('formularioCargaCF')}}" class="btn btn-primary">Formulario Carga</a>
    </div>
  </div>
@endsection
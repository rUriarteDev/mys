@extends('layout.mainlayout')

@section('content')

<div class="container-fluid">

    <div class="card border-primary mb-3 mx-auto" style="width: 95%">
        <div class="card-header">
            Grafico de frecuencias observadas de numeros aleatorios
        </div>
        <div class="card-body">
            {!! $graficoFobsNA->container() !!}
        </div>
    </div>

    <div class="card border-primary mb-3 mx-auto" style="width: 95%">
        <div class="card-header">
            Resultado Chi2
        </div>
        <div class="card-body">
            El valor calculado chi2 para los numeros generados es: {{$chi2}}
        </div>
    </div>



    <div class="card border-primary mb-3 mx-auto" style="width: 95%">
        <div class="card-header">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseTabla1"
                aria-expanded="false" aria-controls="collapseTabla1">
                Tabla de marcas de clases
            </button>
        </div>
        <div class="collapse" id="collapseTabla1">
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Etiqueta</th>
                            <th scope="col">Probabilidad cargada</th>
                            <th scope="col">Valor Minimo (<=) Rango</th> 
                            <th scope="col">Valor Maximo (<) Rango</th> 
                            <th scope="col">Frecuencia Esperada</th>
                            <th scope="col">Frecuencia Observada</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($marcasClase as $marcaClase)
                            <tr>
                                <td>{{$marcaClase->get('etiqueta')}}</td>
                                <td>{{$marcaClase->get('probabilidad')}}</td>
                                <td>{{$marcaClase->get('min')}}</td>
                                <td>{{$marcaClase->get('max')}}</td>
                                <td>{{$marcaClase->get('fespMC')}}</td>
                                <td>{{$marcaClase->get('fobsMC')}}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="card border-primary mb-3 mx-auto" style="width: 95%">
        <div class="card-header">
            Grafico de frecuencias esperadas y observadas de marcas de clase
        </div>
        <div class="card-body">
            {!! $graficoMC->container() !!}
        </div>
    </div>

    <hr>

    <div class="card border-primary mb-3 mx-auto" style="width: 95%">
        <div class="card-header">
            <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseTabla2"
                aria-expanded="false" aria-controls="collapseTabla2">
                Tabla de numeros, variables y marcas
            </button>
        </div>
        <div class="collapse" id="collapseTabla2">
            <div class="card-body">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th scope="col">Posicion</th>
                            <th scope="col">Numero Aleatorio</th>
                            <th scope="col">Numero Ajustado (0-100)</th>
                            <th scope="col">Variable Aleatoria</th>
                            <th scope="col">Marca de Clase Var. Aleatoria</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $aleatorios01->count(); $i++)
                            <tr>
                                <td>{{$i}}</td>
                                <td>{{$aleatorios01->get($i)}}</td>
                                <td>{{$numerosAjustados0100->get($i)}}</td>
                                <td>{{$varAleatorias->get($i)}}</td>
                                <td>{{$marcasVA->get($i)}}</td>
                            </tr>
                            @endfor
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>

{!! $graficoFobsNA->script() !!}
{!! $graficoMC->script() !!}


@endsection
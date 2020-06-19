@extends('layout.mainlayout')

@section('content')

<style>
    .ico {
        padding: 0;
    }
    .tabTitAjust{
        white-space: nowrap; 
        width: 1%;
    }
</style>

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

    <div class="card border-primary mb-3 mx-auto" style="width: 95%">
        <div class="card-header">
            Grafico de caudal diario
        </div>
        <div class="card-body">
            {!! $graficoHidrologia->container() !!}
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
                <table class="table table-sm table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th scope="col" style="text-align: center">
                                <div class="card-group">
                                    <div class="card">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-arrow-up" style="color:green;font-size:16px"
                                                title="Valor maximo"></i>
                                        </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:green;font-size:16px">
                                                {{number_format($maxVA,2,',','.')}}</p>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-arrow-down" style="color:red; font-size:16px"
                                                title="Valor minimo"></i> </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:red; font-size:16px">
                                                {{number_format($minVA,2,',','.')}}</p>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-chart-bar" style="color:blue;font-size:16px"
                                                title="Promedio"></i> </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:blue;font-size:16px">
                                                {{number_format($promVA,2,',','.')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th></th>
                            <th scope="col" style="text-align: center">
                                <div class="card-group">
                                    <div class="card ">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-arrow-up" style="color:green;font-size:16px"
                                                title="Valor maximo"></i>
                                        </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:green;font-size:16px">
                                                {{number_format($maxCaudal,2,',','.')}}</p>
                                        </div>
                                    </div>
                                    <div class="card ">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-arrow-down" style="color:red; font-size:16px"
                                                title="Valor minimo"></i> </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:red; font-size:16px">
                                                {{number_format($minCaudal,2,',','.')}}</p>
                                        </div>
                                    </div>
                                    <div class="card ">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-chart-bar" style="color:blue;font-size:16px"
                                                title="Promedio"></i> </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:blue;font-size:16px">
                                                {{number_format($promCaudal,2,',','.')}}</p>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th scope="col" style="text-align:center">
                                <div class="card-group">
                                    <div class="card">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-exclamation-triangle"
                                                style="color:red;font-size:16px" title="Cantidad de alertas"></i> </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:red;font-size:16px">{{$cantAlertas}}</p>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th scope="col" style="text-align: center">
                                <div class="card-group">
                                    <div class="card ">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-arrow-up" style="color:green;font-size:16px"
                                                title="Valor maximo"></i>
                                        </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:green;font-size:16px">
                                                {{number_format($maxLitrosDia,0,',','.')}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card ">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-arrow-down" style="color:red; font-size:16px"
                                                title="Valor minimo"></i> </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:red; font-size:16px">
                                                {{number_format($minLitrosDia,0,',','.')}}</p>
                                        </div>
                                    </div>
                                    <div class="card ">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-chart-bar" style="color:blue;font-size:16px"
                                                title="Promedio"></i> </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:blue;font-size:16px">
                                                {{number_format($promLitrosDia,0,',','.')}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </th>
                            <th scope="col" style="text-align: center">
                                <div class="card-group">
                                    <div class="card ">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-arrow-up" style="color:green;font-size:16px"
                                                title="Valor maximo"></i>
                                        </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:green;font-size:16px">
                                                {{number_format($maxPersonasDia,0,',','.')}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card ">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-arrow-down" style="color:red; font-size:16px"
                                                title="Valor minimo"></i> </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:red; font-size:16px">
                                                {{number_format($minPersonasDia,0,',','.')}}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="card ">
                                        <div class="card-header ico">
                                            <i class="nav-icon la la-chart-bar" style="color:blue;font-size:16px"
                                                title="Promedio"></i> </div>
                                        <div class="card-body ico">
                                            <p class="card-text" style="color:blue;font-size:16px">
                                                {{number_format($promPersonasDia,0,',','.')}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <thead>
                        <tr>
                            <th scope="col" style="text-align:center">Dia</th>
                            <th class="tabTitAjust" scope="col" style="text-align:center">Numero Aleatorio</th>
                            <th class="tabTitAjust" scope="col" style="text-align:center;">Nº Ajustado (0-100)</th>
                            <th scope="col" style="text-align:center">Variable Aleatoria</th>
                            <th class="tabTitAjust" scope="col" style="text-align:center">Marca de Clase</th>
                            <th scope="col" style="text-align:center">Caudal Dia</th>
                            <th scope="col" style="text-align:center">Alerta</th>
                            <th scope="col" style="text-align:center">Litros Dia</th>
                            <th scope="col" style="text-align:center">Provision personas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @for ($i = 0; $i < $aleatorios01->count(); $i++)
                            <tr>
                                <td style="text-align:center">{{$i}}</td>
                                <td style="text-align:center">{{number_format($aleatorios01->get($i),2,',','.')}}</td>
                                <td style="text-align:center">
                                    {{number_format($numerosAjustados0100->get($i),2,',','.')}}</td>
                                <td style="text-align:center">{{number_format($varAleatorias->get($i),2,',','.')}}</td>
                                <td style="text-align:center">{{$marcasVA->get($i)}}</td>
                                <td style="text-align:center">{{number_format($caudales->get($i),2,',','.')}}</td>
                                <td style="text-align:center">@if ($alerta->get($i)==true)
                                    <i class="nav-icon la la-exclamation-triangle" style="color:red"></i>
                                    @else
                                    <i class="nav-icon la la-check-circle" style="color:green"></i>
                                    @endif
                                </td>
                                <td style="text-align:center">{{$litrosDia->get($i)}}</td>
                                <td style="text-align:center">{{$personasDia->get($i)}}</td>

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
{!! $graficoHidrologia->script() !!}


@endsection
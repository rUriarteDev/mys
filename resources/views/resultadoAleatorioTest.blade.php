@extends(backpack_view('blank'))

@section('content')

<div class="container-fluid">

    <div class="card border-primary mb-3 mx-auto" style="width: 60%">
        <div class="card-header">
            Resultado Chi2
        </div>
        <div class="card-body">
            El valor calculado chi2 para los numeros generados es: {{$chi2}}
        </div>
    </div>

    <div class="card border-primary mb-3 mx-auto" style="width: 100%">
        <div class="card-header">
            Grafico de distribucion numeros generados
        </div>
        <div class="card-body">
            {!! $resultados->container() !!}
        </div>
    </div>

    <div class="card border-primary mb-3 mx-auto" style="width: 60%">
        <div class="card-header">
            Numeros Aleatorios Generados
        </div>
        <div class="card-body">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">Posicion</th>
                        <th scope="col">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($aleatorios as $id => $value)
                    <tr>
                        <td>{{$id}}</td>
                        <td>{{$value}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js"></script>

{!! $resultados->script() !!}

@endsection
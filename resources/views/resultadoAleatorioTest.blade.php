@extends(backpack_view('blank'))

@php
Widget::add([
'type' => 'chart',
'controller' => \App\Http\Controllers\Admin\Charts\GraficoResultadoChartController::class,
// OPTIONALS
'class' => 'card border-primary mb-3 mx-auto ',
'wrapper' => [
'class' => '', // customize the class on the parent element (wrapper)
'style' => 'margin-right: auto;margin-left: auto;max-width: 100%;'],
'content' => [
'header' => 'New Users',
'body' => 'This chart should make it obvious how many new users have signed up in the past 7 days.',
],
]);
@endphp

@section('content')

<body>

    <div class="container-fluid">
        <div class="card border-primary mb-3 mx-auto" style="width: 60%">
            <div class="card-header">
                Resultado Chi2
            </div>
            <div class="card-body">
                El valor calculado chi2 para los numeros generados es: {{$chi2}}
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

</body>

@endsection
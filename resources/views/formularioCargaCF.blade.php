@extends('layout.mainlayout')

@section('content')

@foreach (Alert::getMessages() as $type => $messages)
@foreach ($messages as $message)
<div class="alert alert-{{ $type }}">{{ $message }}</div>
@endforeach
@endforeach

<body>
    <form action="{{route('formularioResultados')}}" method="post" enctype="multipart/form-data">
        @csrf

        <div class="card border-primary mb-3 mx-auto" style="width: 65%">

            <div class="card-header">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseCF"
                    aria-expanded="false" aria-controls="collapseCF">
                    N° ALEATORIOS (CONG.FUND.)
                </button>
            </div>
            <div class="collapse" id="collapseCF">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm">
                                <label for="cantidad">Cantidad de numeros a calcular.<span
                                        style="color: red">*</span></label>
                                <input type="number" class="form-control" name="cantidad" id="cantidad"
                                    placeholder="Ingrese la cantidad de numeros que desea calcular"
                                    value="{{old('cantidad')}}" required>
                            </div>
                            <div class="col-sm">
                                <label for="a">Valor de la variable "a".<span style="color: red">*</span></label>
                                <input type="number" class="form-control" name="a" id="a"
                                    placeholder="Ingrese un entero >= 0" value="{{old('a')}}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <label for="c">Valor de la variable "c".<span style="color: red">*</span></label>
                                <input type="number" class="form-control" name="c" id="c"
                                    placeholder="Ingrese un entero >= 0" value="{{old('c')}}" required>
                            </div>
                            <div class="col-sm">
                                <label for="m">Valor de la variable "m".<span style="color: red">*</span></label>
                                <input type="number" class="form-control" name="m" id="m"
                                    placeholder="Ingrese el mayor entero primo, que sea menor a 127 (113)"
                                    value="{{old('m')}}" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <label for="semillas">Semillas.<span style="color: red">*</span></label>
                                <input type="text" class="form-control" id="semillas" name="semillas"
                                    placeholder="Ingrese las semillas separadas por una coma (p.ej: 45,89,74)"
                                    pattern="[0-9 _,]*" value="{{old('semillas')}}" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer"> <strong>AYUDA</strong> <br>
                V[i+1] = ((a * V[i] + c * V[i-k]) mod m) <br>
                a = multiplicador (a>=0) <br>
                c = constante aditiva (c>=0) <br>
                m = p*e -> p=2(computadora binaria), e=64(arq 64bits) -> m=127 (m>V[i]) (m>a) (m>0) <br>
                k = seran las cantidad de seeds cargadas por el usuario <br>
            </div>
        </div>

        <div class="card border-primary mb-3 mx-auto" style="width: 65%">
            <div class="card-header">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseMarcas"
                    aria-expanded="false" aria-controls="collapseMarcas">
                    MARCAS DE CLASE
                </button>
            </div>

            <div class="collapse" id="collapseMarcas">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm">
                                <label for="minimo">Valor minimo del rango para las variables aleatorias<span
                                        style="color: red">*</span></label>
                                <input type="number" class="form-control" id="minimo" name="minimo" step="0.1" required
                                    placeholder="Ingrese el valor minimo del rango para las variables aleatorias."
                                    value="{{old('minimo')}}">
                            </div>
                            <div class="col-sm">
                                <label for="maximo">Valor maximo del rango para las variables aleatorias<span
                                        style="color: red">*</span></label>
                                <input type="number" class="form-control" id="maximo" name="maximo" step="0.1" required
                                    placeholder="Ingrese el valor maximo del rango para las variables aleatorias."
                                    value="{{old('maximo')}}">
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm">
                                <div class="table-responsive">
                                    <table class="table" id="marcas_table">
                                        <thead>
                                            <tr>
                                                <th>Etiqueta <span style="color: red">*</span></th>
                                                <th>Probabilidad <span style="color: red">*</span></th>
                                                <th>Accion</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (old('etiqueta'))
                                            @for( $i=0; $i < count(old('etiqueta')); $i++) <tr>
                                                <td>
                                                    <input type="text" name="etiqueta[]" class="form-control" required
                                                        placeholder="Ingrese una etiqueta"
                                                        value="{{old('etiqueta.'.$i)}}">
                                                </td>
                                                <td>
                                                    <input type="number" step="0.0001" min="0.0001" max="1"
                                                        name="probabilidad[]" class="form-control" required
                                                        placeholder="Ingrese el valor de probabilidad"
                                                        value="{{old('probabilidad.'.$i)}}">
                                                </td>
                                                <td><button class="delete_row pull-right btn btn-danger"><i
                                                            class="la la-remove"></i></button></td>
                                                </tr>
                                                @endfor
                                                @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-sm">
                                <button id="add_row" class="float-sm-left btn btn-default ">+ Agregar Marca
                                    Clase</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card border-primary mb-3 mx-auto" style="width: 65%">
            <div class="card-header">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseHidrologia"
                    aria-expanded="false" aria-controls="collapseHidrologia">
                    VAR. HIDROLOGIA
                </button>
            </div>

            <div class="collapse" id="collapseHidrologia">
                <div class="card-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm">
                                <label for="caudal_habitual">Caudal constante habitual<span
                                        style="color: red">*</span></label>
                                <input type="number" class="form-control" id="caudal_habitual" name="caudal_habitual"
                                    placeholder="Ingrese el valor del caudal habitual del curso de agua en m^3" required
                                    value="{{old('caudal_habitual')}}">
                            </div>
                            <div class="col-sm">
                                <label for="caudal_minimo">Caudal minimo de agua<span
                                        style="color: red">*</span></label>
                                <input type="number" class="form-control" id="caudal_minimo" name="caudal_minimo"
                                    placeholder="Ingrese el valor del caudal minimo del curso de agua en m^3" required
                                    value="{{old('caudal_minimo')}}">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm">
                                <label for="consumo_persona">Consumo minimo por persona<span
                                        style="color: red">*</span></label>
                                <input type="number" class="form-control" id="consumo_persona" name="consumo_persona"
                                    placeholder="Ingrese el valor de consumo minimo diario de una persona en litros" required
                                    value="{{old('consumo_persona')}}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mx-auto" style="width: 65%">
            <div class="row">
                <div class="col-sm">
                    <button type="submit" class="btn btn-success btn-flat btn-sm float-sm-right">GENERAR</button>
                </div>
            </div>
        </div>
    </form>
    <br>

</body>
{{-- en el resumen conocer los picos, alertas, promedio litros y cantidad de gente. --}}

@endsection

@section('after-scripts')
<script type="text/javascript">
    $(document).ready(function() {

    $("#add_row").click(function(e) {
        e.preventDefault();
        //new row
        $("#marcas_table").append(
            '<tr>\
                <td>\
                    <input type="text" name="etiqueta[]" class="form-control" required placeholder="Ingrese una etiqueta" />\
                </td>\
                <td>\
                    <input type="number" step="0.0001" min="0.0001" max="1" name="probabilidad[]" class="form-control" required placeholder="Ingrese el valor de probabilidad" />\
                </td>\
                <td><button class="delete_row pull-right btn btn-danger"><i class="la la-remove"></i></button></td>\
            </tr>'
        );
    });

    $("#marcas_table").on("click", ".delete_row", function() {
        $(this).closest("tr").remove();
    });

});
</script>
@endsection
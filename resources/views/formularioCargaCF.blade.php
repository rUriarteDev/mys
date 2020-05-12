@extends(backpack_view('blank'))

@section('content')

<body>
    <div class="card border-primary mb-3 mx-auto" style="width: 65%">
        <div class="card-header">
            Congruencia Fundamental
        </div>
        <div class="card-body">
            <form action="{{route('calcularCF')}}" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="cantidad">Cantidad de numeros a calcular (incluyendo las semillas)</label>
                    <input type="number" class="form-control" name="cantidad" id="cantidad"
                        placeholder="Ingrese la cantidad de numeros que desea calcular">
                </div>
                <div class="form-group">
                    <label for="cantidad">Valor de la variable "a"</label>
                    <input type="number" class="form-control" name="a" id="a" placeholder="Ingrese un entero >= 0">
                </div>
                <div class="form-group">
                    <label for="cantidad">Valor de la variable "c"</label>
                    <input type="number" class="form-control" name="c" id="c" placeholder="Ingrese un entero >= 0">
                </div>
                <div class="form-group">
                    <label for="cantidad">Valor de la variable "m"</label>
                    <input type="number" class="form-control" name="m" id="m"
                        placeholder="Ingrese el mayor entero primo, que sea menor a 127 (113)">
                </div>
                <div class="form-group">
                    <label for="semillas">Semillas</label>
                    <input type="text" class="form-control" id="semillas" name="semillas"
                        placeholder="Ingrese las semillas separadas por una coma (p.ej: 45,89,74)" pattern="[0-9 _,]*">
                </div>
                @csrf
                <div align="right">
                    <button type="submit" class="btn  btn-success  btn-flat btn-sm">GENERAR</button>
                </div>
            </form>
        </div>
        <div class="card-footer"> <strong>AYUDA</strong> <br>
            V[i+1] = ((a * V[i] + c * V[i-k]) mod m) <br>
            a = multiplicador (a>=0) <br>
            c = constante aditiva (c>=0) <br>
            m = p*e -> p=2(computadora binaria), e=64(arq 64bits) -> m=127 (m>V[i]) (m>a) (m>0) <br>
            k = seran las cantidad de seeds cargadas por el usuario <br>
        </div>
    </div>
</body>

@endsection
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Congruencia Fundamental</title>
</head>
<header>
    <style>
        .vertical-center {
            min-height: 100%;
            /* Fallback for browsers do NOT support vh unit */
            min-height: 100vh;
            /* These two lines are counted as one :-)       */

            display: flex;
            align-items: center;
        }

        body,
        html {
            height: 100%;
        }
    </style>
</header>

<body>
    <div class="container d-flex h-100">
        <div class="card border-primary mb-3 mx-auto align-self-center" style="width: 65%">
            <div class="card-header">
                Congruencia Fundamental
            </div>
            <div class="card-body">
                <form action="{{route('calcularCongruenciaFundamental')}}" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="cantidad">Cantidad de numeros a calcular (incluyendo las semillas)</label>
                        <input type="number" class="form-control" name="cantidad" id="cantidad" placeholder="Ingrese una cantidad">
                    </div>
                    <div class="form-group">
                        <label for="semillas">Semillas</label>
                        <input type="text" class="form-control" id="semillas" name="semillas" placeholder="Ingrese las semillas separadas por una coma">
                    </div>
                    @csrf
                    <div align="right">
                        <button type="submit" class="btn  btn-success  btn-flat btn-sm">Generar Reporte</button>
                    </div>
                </form>
            </div>
            <div class="card-footer"> <strong>AYUDA</strong>  <br>     
                V[i+1] = ((a * V[i] + c * V[i-k]) mod m) <br>
                a = multiplicador (a>=0) <br>
                c = constante aditiva (c>=0) <br>
                m = p*e -> p=2(computadora binaria), e=64(arq 64bits) -> m=127 (m>V[i]) (m>a) (m>0) <br>
                k = seran las cantidad de seeds cargadas por el usuario <br>
            </div>

        </div>
    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
</body>

</html>
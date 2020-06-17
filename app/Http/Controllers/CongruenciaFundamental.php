<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Charts\UserChart;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Prologue\Alerts\Facades\Alert;

class CongruenciaFundamental extends Controller
{
    public function formularioCargaCF()
    {
        return view('formularioCargaCF');
    }

    public function calcularCF(Request $request)
    {
        //ECUACIONES A USAR
        //V[i+1] = (a*V[i] + c*V[i-k]) mod m
        //a=multiplicador (a>=0)
        //c=constante aditiva (c>=0)
        //m=p*e -> p=2(computadora binaria), e=64(arq 64bits) -> m=127 (m>V[i]) (m>a) (m>0)
        //k= seran las cantidad de seeds cargadas por el usuario

        //VALORES PARA PRUEBA
        //$cantidad=1000;
        //$v0=1234;
        //$v1=5678;
        //$v2=9012;
        //$a=3;
        //$c=5;
        //$m=127;

        //VALORES DEL FORMULARIO
        $cantidad = $request->cantidad;
        $a = $request->a;
        $c = $request->c;
        $m = $request->m;
        $semillas = $request->semillas;

        $semillas = explode(',', $semillas);
        $k = count($semillas);

        $v = collect();
        //ingreso las semillas a la coleccion para comenzar a calcular los valores
        foreach ($semillas as $semilla) {
            $v->push($semilla);
        }
        //genero la cantidad de numeros aleatorios solicitados a partir de las semillas
        for ($i = $k; $cantidad + $k != $v->count(); $i++) {
            $vi = ($a * $v->get($i) + $c * $v->get($i - $k)) % $m;
            $v->push($vi);
        }
        //saco los valores de las semillas ingresadas, de la coleccion final
        $v = $v->splice($k);

        //a los numeros generados (entre 0 y m) los convierto a un rango(0 a 1)
        $aleatorios01 = collect();
        foreach ($v as $vi) {
            $vi = $vi / $m;
            $aleatorios01->push(number_format((float) $vi, 3, '.', ','));
        }
        return array($aleatorios01, $cantidad, $m);
    }

    public function testAleatoriedad(Collection $aleatorios01, $cantidad,  $m)
    {
        //ECUACIONES A USAR
        //n=cantidad numeros generados
        //k=cantidad numeros posibles=valor m de la fn calcularCF
        //gl=k-1
        //fobs=frecuencias observadas
        //fesp=n/k

        $n = $cantidad;
        $k = $m;
        $gl = $k - 1;
        $fesp = $n / $k;

        //calculo la frecuencia observada de cada numero aleatorio
        $fobsNA = $aleatorios01->groupBy([
            function ($item) {
                return $item;
            },
        ], $preserveKeys = true)
            ->map(function ($item) {
                return count($item);
            });

        //calculo el valor de chi2 para mi cada uno de mis numeros aleatorios
        $chi2 = collect();
        foreach ($fobsNA as $key => $value) {
            $aux = pow(($value - $fesp), 2) / $fesp;
            $chi2[$key] = $aux;
        }
        //calculo el valor de chi2 para toda mi coleccion de numeros aleatorios
        $chi2 = $chi2->sum();

        //ordeno la coleccion de frecuencias observadas de numeros aleatorios, de menor a mayor para pasar al grafico
        $fobsNA = $fobsNA->sortBy(function ($item, $key) {
            return $key;
        });

        return array($fobsNA, $chi2);
    }

    public function calcularClases(Request $request, Collection $aleatorios01)
    {
        $minimo = floatval($request->minimo);
        $maximo = floatval($request->maximo);
        $etiquetas = collect($request->etiqueta);
        $probabilidades = collect($request->probabilidad);

        //los valores posibles segun el maximo y minimo indicado por el experto
        $valoresposibles = $maximo - $minimo;

        //calculo cuanto es el tamaño de cada rango segun su probabilidad y valores posibles
        $rangos = collect();
        foreach ($probabilidades as $probabilidad) {
            $aux1 = $probabilidad * $valoresposibles;
            $rangos->push($aux1);
        }

        $rangomin = collect();
        $rangomax = collect();
        //pongo como primer valor del primer rango minimo el valor indicado por el experto
        $rangomin->push($minimo);
        //calculo los minimos y maximos de cada una de las marcas de clases.
        foreach ($rangos as $rango) {
            if (count($rangomin) == 1) {
                $aux2 = $rangomin->last() + $rango;
                $aux3 = $rangomin->last() + $rango;
            } else {
                $aux2 = $rangomin->last() + $rango;
                $aux3 = $rangomin->last() + $rango;
            }
            $rangomax->push($aux3);
            $rangomin->push($aux2);
        }
        //saco el ultimo valor de rangomin ya que el primero lo puse por defecto
        $rangomin->pop();


        $marcasClase = collect();
        //creo una coleccion con la etiqueta de la marca de clase, la probabilidad de ocurrencia cargada
        // su valor minimo y maximo de rango calculado y su frecuencia esperada
        for ($i = 0; $i < count($etiquetas); $i++) {
            $aux4 = collect();
            $aux4->put('etiqueta', $etiquetas->get($i));
            $aux4->put('probabilidad', $probabilidades->get($i));
            $aux4->put('min', $rangomin->get($i));
            $aux4->put('max', $rangomax->get($i));
            $aux4->put('fespMC', $aleatorios01->count() * (floatval($probabilidades->get($i))));
            $marcasClase->push($aux4);
        }

        //transformo los aleatorios en rango 0-1 a un rango 0-100
        //numeroAjustado = valorInferior + abs( [ numeroOriginal * cantidadValoresRango ] )
        $numerosAjustados0100 = collect();
        foreach ($aleatorios01 as $aleatorio01) {
            $aux5 = 0 + abs((floatval($aleatorio01) * 100));
            $numerosAjustados0100->push($aux5);
        }

        //transformo el numero ajustado (0-100) a una variable aleatoria dentro del rango de mi dominio($minimo-$maximo)
        $varAleatorias = collect();
        foreach ($numerosAjustados0100 as $numeroAjustado0100) {
            $aux6 = ($numeroAjustado0100 / 100 * ($maximo - $minimo)) + $minimo;
            $varAleatorias->push($aux6);
        }

        //la variables aleatorias obtenidas las clasifico en las marcas de clases segun los rangos.
        $marcasVA = collect();
        $varAleatorias->map(function ($va) use ($marcasClase, $marcasVA) {
            foreach ($marcasClase as $marca) {
                if (($marca->get('min') <= $va) and ($va < $marca->get('max'))) {
                    $marcasVA->push($marca->get('etiqueta'));
                    break;
                }
            }
        });

        //agrupo la clasificacion obtenida y cuento las frecuencias observadas de cada marca de clase
        $fobsMC = $marcasVA->groupBy(function ($item, $key) {
            return ($item);
        })->map(function ($item) {
            return count($item);
        });

        //a la coleccion de marcas de clase le agrego la frecuencia observada
        $marcasClase->map(function ($mc) use ($fobsMC) {
            foreach ($fobsMC as $key => $value) {
                if ($key == $mc->get('etiqueta')) {
                    $mc->put('fobsMC', $value);
                    break;
                }
            }
        });
        return array($marcasClase, $numerosAjustados0100, $varAleatorias, $marcasVA);
    }

    public function hidrologia(Collection $varAleatorias, Request $request)
    {
        $caudalh = intval($request->caudal_habitual);
        $caudalm = intval($request->caudal_minimo);
        $consumop = intval($request->consumo_persona);

        //calculo el caudal del dia
        $aux = $caudalh;
        $caudales = collect();
        foreach ($varAleatorias as $i => $va) {
            $aux += $va;
            $caudales->push($aux);
        }

        //verifico si el caudal del dia cae por debajo del minimo establecido
        $alerta = collect();
        foreach ($caudales as $i => $caudal) {
            if ($caudal < $caudalm) {
                $aux2 = true;
            } else {
                $aux2 = false;
            }
            $alerta->push($aux2);
        }

        //calculo cuantos litros de agua tengo segun el caudal del dia
        //1m3/s = 1000lt/s
        //1m3/s = 86.400.0000lt/dia
        $litros_dia = collect();
        foreach ($caudales as $i => $caudal) {
            $aux3 = $caudal * 86400000;
            $litros_dia->push($aux3);
        }

        //calculo a cuantas personas puedo abastecer con esa cantidad de litros
        $personas_dia = collect();
        foreach ($litros_dia as $i => $ld) {
            $aux4 = $ld / $consumop;
            $personas_dia->push($aux4);
        }

        return array($caudales, $alerta, $litros_dia, $personas_dia);
    }

    public function formularioResultados(Request $request)
    {
        $probabilidad = $request->probabilidad;

        if ($probabilidad == null) {
            Alert::error('Debe ingresar al menos una marca de clase')->flash();
            return Redirect::back()->withInput($request->input());
        }
        $aux = array_sum($probabilidad);
        if ($aux != 1) {
            Alert::error('La suma de las probabilidades debe ser igual a 1 o 100%')->flash();
            return Redirect::back()->withInput($request->input());
        }

        list($aleatorios01, $cantidad, $m) = $this->calcularCF($request);
        list($fobsNA, $chi2) = $this->testAleatoriedad($aleatorios01, $cantidad, $m);
        list($marcasClase, $numerosAjustados0100, $varAleatorias, $marcasVA) =  $this->calcularClases($request, $aleatorios01);
        list($caudales, $alerta, $litros_dia, $personas_dia) = $this->hidrologia($varAleatorias, $request);


        $graficoFobsNA = new UserChart;
        $graficoFobsNA->labels($fobsNA->keys());
        $graficoFobsNA->dataset('Frecuencia observada', 'bar', $fobsNA->values())->color('black');

        $graficoMC = new UserChart;
        $graficoMC->labels($marcasClase->pluck('etiqueta'));
        $graficoMC->dataset('Frecuencia esperada MC', 'line', $marcasClase->pluck('fespMC'))->color('black');
        $graficoMC->dataset('Frecuencia observada MC', 'line', $marcasClase->pluck('fobsMC'))->color('red');

        $graficoHidrologia = new UserChart;
        $graficoHidrologia->labels($caudales->keys());
        $graficoHidrologia->dataset('Caudal diario', 'line', $caudales->values())->color('red');
        // $graficoHidrologia->dataset('Caudal minimo', 'line', intval($request->caudal_minimo))->color('black');

        return view(
            'resultadoAleatorioTest',
            [
                'aleatorios01' => $aleatorios01,
                'chi2' => $chi2,
                'graficoFobsNA' => $graficoFobsNA,
                'graficoMC' => $graficoMC,
                'marcasClase' => $marcasClase,
                'numerosAjustados0100' => $numerosAjustados0100,
                'varAleatorias' => $varAleatorias,
                'marcasVA' => $marcasVA,

                'graficoHidrologia' => $graficoHidrologia,
                'caudales' => $caudales,
                'alerta' => $alerta,
                'litrosDia' => $litros_dia,
                'personasDia' => $personas_dia
            ]
        );
    }
}

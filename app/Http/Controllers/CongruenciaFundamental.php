<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;

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
        foreach ($semillas as $semilla) {
            $v->push($semilla);
        }
        for ($i = $k; $cantidad + $k != $v->count(); $i++) {
            $vi = ($a * $v->get($i) + $c * $v->get($i - $k)) % $m;
            $v->push($vi);
        }
        $v = $v->splice($k);

        return $this->testAleatoriedad($v, $cantidad, $m);
    }

    public function testAleatoriedad(Collection $aleatorios, $cantidad,  $m)
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

        $fobs = $aleatorios->groupBy([
            function ($item) {
                return $item;
            },
        ], $preserveKeys = true)->toArray();

        $chi2 = collect();
        foreach ($fobs as $key => $value) {
            $aux = pow((count($value) - $fesp), 2) / $fesp;
            $chi2[$key] = $aux;
        }
        return $this->formularioResultados($aleatorios, $chi2);
        //dd($fobs,$chi2,$chi2->sum());
    }

    public function formularioResultados(Collection $aleatorios, $chi2)
    {
        // $this->calcularCF($request);
        // $this->testAleatoriedad();
        return view(
            'resultadoAleatorioTest',
            [
                'aleatorios' => $aleatorios,
                'chi2' => $chi2->sum(),
                'chi2G' => $chi2
            ]
        );
    }
}

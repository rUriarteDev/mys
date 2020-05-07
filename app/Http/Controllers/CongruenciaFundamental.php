<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CongruenciaFundamental extends Controller
{
    //V[i+1] = (a*V[i] + c*V[i-k]) mod m
    //a=multiplicador (a>=0)
    //c=constante aditiva (c>=0)
    //m=p*e -> p=2(computadora binaria), e=64(arq 64bits) -> m=127 (m>V[i]) (m>a) (m>0)
    //k= seran las cantidad de seeds cargadas por el usuario

    public function calcular(Request $request)
    {
        $cantidad = $request->cantidad;
        $semillas = $request->semillas;
        $semillas= explode(',',$semillas);
        //$cantidad=1000;
        $a=3;
        $c=5;
        $m=127;
        //$v0=1234;
        //$v1=5678;
        //$v2=9012;
        $k=count($semillas);
        $v=collect();
        foreach ($semillas as $semilla) {
            $v->push($semilla);
        }
        //$v->push($v0,$v1,$v2);
        for ($i=$k; $cantidad+$k != $v->count(); $i++) { 
            //$aux=$v->get($i);
            //$aux2=$v->get($i-$k);
            $vi= ($a * $v->get($i) + $c * $v->get($i-$k)) % $m;
            $v->push($vi);
        }


        dd($v);

    }

    public function formulario()
    {
        return view('formularioCongruenciaFundamental');
    }
    

}

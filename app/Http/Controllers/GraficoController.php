<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class GraficoController extends Controller
{
    //Enlazamos a la base datos
    public function getDatos(){
    //Obtenemos las etiquetas
     $etiquetas = DB::SELECT("SELECT DISTINCT(mes) 
    		FROM datos");


     $labels= [];
     //Convertimos el array JSON a un array Plano
     foreach ($etiquetas as $etiqueta) {
     	array_push($labels,$etiqueta->mes);
     }


     //Obtenemos los datos de la SERIE 1
    $serie1=DB::SELECT("SELECT total
     	FROM datos
     	WHERE annio=2021");

   	//Convertivos el arra JSON a array Plano
     $s1=[];
     foreach ($serie1 as $ser1) {
     	array_push($s1,$ser1->total);
     }

     	//return $s1;
     $serie2=DB::SELECT("SELECT total 
        FROM datos
        WHERE annio=2022");
     $s2=[];
     foreach ($serie2 as $ser2) {
         array_push($s2,$ser2->total);
     }

    return $datos=[
     	'labels'=>$labels,
     	'serie1'=>$s1,
        'serie2'=>$s2
     ];
     
    }
}

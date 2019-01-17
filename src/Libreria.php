<?php


class Libreria 
{

    // Compemdio de funciones comunes
    // declarar el include -> use Libreria;
    
    
    
    public function damefechaInicial(String $fecha){
        // devuelve la fecha del primer día del mes de la quefa que recibe
        return date("Y-m-d",mktime(0,0,0,intval(substr($fecha,3,2)),1,intval(substr($fecha,6,4))));
        
    }
    public function damefechaFinal(String $fecha){
        // devuelve la fecha del último día del mes de la quefa que recibe
        return date("Y-m-d",mktime(0,0,0,intval(substr($fecha,3,2))+1,0,intval(substr($fecha,6,4))));
        
    }
    
    public function convierteFecha(String $fecha){
        // Transforma una fecha de "d-m-y" a Y-m-d
        return date("Y-m-d",mktime(0,0,0,intval(substr($fecha,3,2)),intval(substr($fecha,0,2)),intval(substr($fecha,6,4))));
        
    }
    
    // Devuelve un array con las fechas inicial y final
    public function dameFechas($mes,$inicio,$fin){
        $datos=[];
        $fecha = new \DateTime;
        $anio = $fecha->format("Y");
        
            if (is_null($mes)) {
                if (!is_null($inicio)) {
                    $datos['inicio'] = $inicio->format("Y-m-d");
                    if (!is_null($fin)) {
                        $datos['fin']= $fin->format("Y-m-d");
                    }
                } else {
                    $mes = $fecha->format("m");
                    $datos['inicio'] =date("Y-m-d",mktime(0,0,0,$mes,1,$anio));
                    $datos['fin'] =date("Y-m-d",mktime(0,0,0,$mes+1,0,$anio));                    
                }

            } else {
                $datos['inicio'] =date("Y-m-d",mktime(0,0,0,$mes,1,$anio));
                $datos['fin'] =date("Y-m-d",mktime(0,0,0,$mes+1,0,$anio));
            }
        return $datos;
    }
    
}

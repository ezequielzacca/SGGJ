<?php

namespace Gremio\DefaultBundle\Twig\Extension;

class GremioExtension extends \Twig_Extension {

    public function getName() {
        return 'gremio';
    }

    public function getFunctions() {
        return array(
            'letras' => new \Twig_Function_Method($this, 'letras'),
            'completar_decimales' => new \Twig_Function_Method($this, 'completarDecimales'),
            'completar_ceros' => new \Twig_Function_Method($this, 'completarCeros'),
        );
    }
    
    public function completarDecimales($numero){
        return $this->redondear($numero);
    }
    
     public function completarCeros($entero, $largo) {
        return str_pad($entero, $largo, "0", STR_PAD_LEFT);
    }

    private function redondear ($numero, $decimales=2) {
$factor = pow(10, $decimales);
$float_redondeado=round($numero*$factor)/$factor;
$float_redondeado=number_format($float_redondeado,$decimales,',','.');
return $float_redondeado;
}
    
    public function letras($valor) {
        
        
        $numeros = explode(".",$valor);
        $numero = $numeros[0];
        $extras = array("/[\$]/", "/ /", "/,/", "/-/");
        $limpio = preg_replace($extras, "", $numero);
        $partes = explode(".", $limpio);
        if (count($partes) > 2) {
            return "Error, el n&uacute;mero no es correcto";
            exit();
        }

        // Ahora explotamos la parte del numero en elementos de un array que 
        // llamaremos $digitos, y contamos los grupos de tres digitos 
        // resultantes 

        $digitos_piezas = chunk_split($partes[0], 1, "#");
        $digitos_piezas = substr($digitos_piezas, 0, strlen($digitos_piezas) - 1);
        $digitos = explode("#", $digitos_piezas);
        $todos = count($digitos);
        $grupos = ceil(count($digitos) / 3);

        // comenzamos a dar formato a cada grupo 

        $unidad = array('un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve');
        $decenas = array('diez', 'once', 'doce', 'trece', 'catorce', 'quince');
        $decena = array('dieci', 'veinti', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa');
        $centena = array('ciento', 'doscientos', 'trescientos', 'cuatrociento  s', 'quinientos', 'seiscientos', 'setecientos', 'ochoc  ientos', 'novecientos');
        $resto = $todos;

        for ($i = 1; $i <= $grupos; $i++) {

            // Hacemos el grupo 
            if ($resto >= 3) {
                $corte = 3;
            } else {
                $corte = $resto;
            }
            $offset = (($i * 3) - 3) + $corte;
            $offset = $offset * (-1);

            // la siguiente seccion es una adaptacion de la contribucion de cofyman y JavierB 

            $num = implode("", array_slice($digitos, $offset, $corte));
            $resultado[$i] = "";
            $cen = (int) ($num / 100);              //Cifra de las centenas 
            $doble = $num - ($cen * 100);             //Cifras de las decenas y unidades 
            $dec = (int) ($num / 10) - ($cen * 10);    //Cifra de las decenas 
            $uni = $num - ($dec * 10) - ($cen * 100);   //Cifra de las unidades 
            if ($cen > 0) {
                if ($num == 100)
                    $resultado[$i] = "cien";
                else
                    $resultado[$i] = $centena[$cen - 1] . ' ';
            }//end if 
            if ($doble > 0) {
                if ($doble == 20) {
                    $resultado[$i] .= " veinte";
                } elseif (($doble < 16) and ($doble > 9)) {
                    $resultado[$i] .= $decenas[$doble - 10];
                } else {
                    $resultado[$i] .=' ' . $decena[$dec - 1];
                }//end if 
                if ($dec > 2 and $uni <> 0)
                    $resultado[$i] .=' y ';
                if (($uni > 0) and ($doble > 15) or ($dec == 0)) {
                    if ($i == 1 && $uni == 1)
                        $resultado[$i].="uno";
                    elseif ($i == 2 && $num == 1)
                        $resultado[$i].="";
                    else
                        $resultado[$i].=$unidad[$uni - 1];
                }
            }

            // Le agregamos la terminacion del grupo 
            switch ($i) {
                case 2:
                    $resultado[$i].= ($resultado[$i] == "") ? "" : " mil ";
                    break;
                case 3:
                    $resultado[$i].= ($num == 1) ? " mill&oacute;n " : " millones ";
                    break;
            }
            $resto-=$corte;
        }

        // Sacamos el resultado (primero invertimos el array) 
        $resultado_inv = array_reverse($resultado, TRUE);
        $final = "";
        foreach ($resultado_inv as $parte) {
            $final.=$parte;
        }
        if($numero==$valor)
        {
             return $final;
        
        }
        else
        {
           return $final." con ".$numeros[1]."/100";
        }   
    }

}

?>

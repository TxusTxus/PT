<?php
namespace UsuariosBundle\Controller\librerias;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use Symfony\Component\Finder\SplFileInfo;

class funciones {
    
    public static function Enmascara ($action='encripta',$string=false){
        $action = trim($action);
        $output = false;

        $myKey = 'FIStanDANtiLUS';
        $myIV = '!21-doce-69^';
        $encrypt_method = 'AES-256-CBC';

        $secret_key = hash('sha256',$myKey);
        $secret_iv = substr(hash('sha256',$myIV),0,16);

        if ( $action && ($action == 'encripta' || $action == 'desencripta') && $string )
        {
            $string = trim(strval($string));

            if ( $action == 'encripta' )
            {
                $output = openssl_encrypt($string, $encrypt_method, $secret_key, 0, $secret_iv);
                $output = str_replace("/", "5lF4r", $output);
            };

            if ( $action == 'desencripta' )
            {
                $cadena = str_replace("5lF4r","/" , $string);
                $output = openssl_decrypt($cadena, $encrypt_method, $secret_key, 0, $secret_iv);
            };
        };

        return $output;
    }
    
    /* ******************************************************
     * Devuelve un nombre de fichero enmascarado sin la barra
     * ******************************************************
     */
    
    public static function dameNombreFicheroValido(){
        $salir = false;
        do {
            // Obtiene una cadena para nombrar al fichero de excel
            $date = new \DateTime();
            $enlaceFichero = Funciones::Enmascara('encripta', 'usuarios a excel'.$date->format('u').'alfa').'.xlsx';
            if (strpos($enlaceFichero, '/') == false){
                $salir=true;
            }
        } while ($salir== false);
        
        return $enlaceFichero;
    }
     /* ******************************************************
     * Devuelve una cadena enmascarada sin la barra
     * ******************************************************
     */
     public static function dameNombreValido(){
        $salir = false;
        do {
            // Obtiene una cadena para nombrar al fichero de excel
            $date = new \DateTime();
            $enlaceFichero = Funciones::Enmascara('encripta', 'usuarios a excel'.$date->format('u').'alfa').'.xlsx';
            if (strpos($enlaceFichero, '/') == false){
                $salir=true;
            }
        } while ($salir== false);
        
        return $enlaceFichero;
    }   
  
    
    
    public static function eliminaExcel(){
        // Elimina todos los ficheros excel anteriores a una hora
        $directorio = 'documentos';
        $i=0;
        $ficheros  = scandir($directorio);
        foreach ($ficheros as $miraExtension) {
            $extension = new SplFileInfo($miraExtension, $directorio,$directorio );
            if ($extension->getExtension() == 'xlsx') {
                $tiempoExistencia = time()-filemtime($directorio.'/'.$miraExtension);
                if ( $tiempoExistencia> 7200){
                    unlink($directorio.'/'.$miraExtension);
                    $i++;   
                }
                
            }
        }
        
    }
    
    
    
}


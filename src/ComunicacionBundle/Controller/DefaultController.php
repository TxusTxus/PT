<?php

namespace ComunicacionBundle\Controller;

use UsuariosBundle\Entity\User;
use TrabajadoresBundle\Entity\Trabajadores;
use ClientesBundle\Entity\Cliente;
use PartesBundle\Entity\Partes;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class DefaultController extends Controller
{
    public function indexAction($cadena)
    {
        $response = new JsonResponse();
        $encoders = array(new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);
        $lista = $this->accion($cadena);
        $response->setContent(json_encode(array(
            'clientes' => $serializer->serialize($lista, 'json'),
        )), JSON_UNESCAPED_SLASHES);

        $response->headers->set('Content-Type', 'application/json');
        
        return $response;
    }
    
        
    // requirements={"cadena"=".+"})

   
    public function accion($cadena)
    {
            // Acciones
            // 001 -> Inicia conexión
            //        Código Accion - Código trabajador  
            //     -> devuelve la lista de Clientes.
            //     -> devuelve ¿partes? opción módulo gestión de partes.
            // 
            // 002 -> Nuevo Usuario
            //        Código Accion - Nombre trabajador
            //     -> devuelve datos trabajador.
            // 003 -> Nuevo Parte
            //        Código acción - Código trabajador - Código Cliente
            //        Fecha - Entrada - Salida - Material - 
            //        Comentario

        // ->  para posterior uso
        // $cadenaEncriptada = funciones::Enmascara($action='desencripta',$cadena);
        // -> $accionSeleccionada = substr($cadenaEncriptada,0,3);
        
        $accionSeleccionada = substr($cadena,0,3);

                $trabajador = $this->getDoctrine()->getRepository(Trabajadores::class)->findOneBy(array('codigoActivacion' => substr($cadena,3,9)));
         switch ($accionSeleccionada) {
            case '001':
                $this->iniciaConexion($trabajador);


                break;
            case '002':
                $this->iniciaConexion($trabajador,true);
                break;
            case '003':
                if ($this-> registraNuevoParte($trabajador,$cadena)) {
                    print_r('000'.substr($cadena,3,19).'V');
                } else {
                    print_r('000ERROR');
                }

                
                break;
            case '004':

                break;
            case '005':

                break;
            case '006':
                 
                break;
        }    

        
       return true; 
    }
    
    // Al iniciar la conexion obtiene el listado de clientes
    private function iniciaConexion(Trabajadores $trabajador,$primeraVez=null){

                if ($trabajador) {
                    $clientes=$this->getDoctrine()->getRepository(Cliente::class)->dameListaClientes($trabajador->getEmpresa());
                    // revisar respuesta json
                    return json_encode($clientes, JSON_UNESCAPED_SLASHES);
                    // return $clientes;
                } else {
                    return 'Accese no válido';
                }
    }
    // Extrae los datos de la cadena de entrada y si es correcto lo gusrda en un nuevo parte.
    private function registraNuevoParte(Trabajadores $trabajador,$cadena){
                $parte = new Partes();

                $cliente = $this->getDoctrine()->getRepository(Cliente::class)->find(intval(substr($cadena,12,4)));
                $fecha = new \DateTime($this->dameFecha(substr($cadena,16,6)));
                $entrada = new \DateTime($this->dameHora(substr($cadena,22,4),substr($cadena,16,6)));
                $salida = new \DateTime($this->dameHora(substr($cadena,26,4),substr($cadena,16,6)));
                $intervalo = $salida->diff($entrada);
                $minutosTotal = ($intervalo->format('%H')*60)+$intervalo->format('%I');
                
                $parte->setEmpresa($trabajador->getEmpresa());
                $parte->setTrabajador($trabajador);
                $parte->setCliente($cliente);
                $parte->setFechaParte($fecha);
                $parte->setFechaEntrada($entrada);
                $parte->SetFechaSalida($salida);
                $parte->setTiempo($minutosTotal);
                $parte->setObservaciones(substr($cadena,30));
 
            $em = $this->getDoctrine()->getManager();
            $em->persist($parte);
            $em->flush();
            return true;

    }
    private function dameFecha($fecha) {
        
        return date("Y-m-d",mktime(0,0,0,intval(substr($fecha,2,2)),intval(substr($fecha,0,2)),intval(substr($fecha,4,2))));
    }
    
    private function dameHora($hora,$fecha) {
        
        return date("Y-m-d H:i",mktime(intval(substr($hora,0,2)),intval(substr($hora,2,2)),0,intval(substr($fecha,2,2)),intval(substr($fecha,0,2)),intval(substr($fecha,4,2))));
    }
}

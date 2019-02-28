<?php

namespace PartesBundle\Controller;

use PartesBundle\Entity\Partes;
use ClientesBundle\Entity\Cliente;
use EmpresasBundle\Entity\Empresa;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Parte controller.
 *
 */
class PartesController extends Controller
{
    /**
     * Listado de todos los partes.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        // $partes = $em->getRepository('PartesBundle:Partes')->findAll();
        $fecha = new \DateTime;
        $partes = $em->getRepository('PartesBundle:Partes')->damePartesDia($empresa->getId(),$fecha->format('d-m-Y'));
        $dias = $em->getRepository('PartesBundle:Partes')->dameFechasPartes($empresa->getId(),$fecha->format('d-m-Y'));
        return $this->render('PartesBundle:Default:index.html.twig', array(
            'partes' => $partes,
            'dias'          => $dias,
            'accionBuscar'  => '',
            'empresa' => $empresa,
            'fecha'         => ''
        ));
    }

     /**
     * Listado de todos los partes de una fecha dada.
     *
     */
    public function diarioPartesAction($fecha)
    {
        
        $em = $this->getDoctrine()->getManager();
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $partes = $em->getRepository('PartesBundle:Partes')->damePartesDia($empresa->getId(),$fecha);
        $dias = $em->getRepository('PartesBundle:Partes')->dameFechasPartes($empresa->getId(),$fecha);
        
        return $this->render('PartesBundle:Default:index.html.twig', array(
            'partes'        => $partes,
            'dias'          => $dias,
            'accionBuscar'  => '',
            'empresa'       => $empresa,
            'fecha'         => $fecha
        ));
    }
    

    /**
     * Crear un nuevo parte de trabajo.
     * Para producto
     * Valores -> Cliente, Direccion, Producto.
     *
     */
    public function nuevoMantenimientoAction(Request $request, $id,$fecha)
    {
        
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $em = $this->getDoctrine()->getManager();
        // Selecciona el producto para el mantenimiento
        $direccion = $em->getRepository('ClientesBundle:Direccion')->dameProductosPorDireccion($id,$fecha);
        $cliente = $this->getDoctrine()->getRepository('ClientesBundle:Cliente')->find($direccion['0']['cliente']);
        // Asigna campos iniciales
        $parte = $this->actualizaValoresParte($direccion, $cliente, $empresa, 1);

        $form = $this->createForm('PartesBundle\Form\PartesType', $parte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {            
            $em->persist($parte);
            $em->flush();
            $this->procesaProductoParaPlanificarlas($direccion,true);
            return $this->redirectToRoute('partes_show', array('id' => $parte->getId()));
        }
        //$this->marcaProductoPlanificado($direccion);
        return $this->render('PartesBundle:Default:new.html.twig', array(
            'tipo'          => 'Mantenimiento',
            'parte'         => $parte,
            'direccion'     => $direccion,
            'form'          => $form->createView(),
            'accionBuscar'  => '',
            'empresa'       => $empresa,
            'cliente'       => $cliente
        ));
    }

    /**
     * Crear un nuevo parte de trabajo.
     * Para una incidencia
     * Valores -> Cliente, Direccion, Producto.
     *
     */
    public function nuevaIncidenciaAction(Request $request, $id)
    {
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $em = $this->getDoctrine()->getManager();
        // Selecciona la incidencia 
        $direccion = $em->getRepository('ClientesBundle:Direccion')->dameIndicenciasPorDireccion($id);
        $cliente = $this->getDoctrine()->getRepository('ClientesBundle:Cliente')->find($direccion['0']['cliente']);
        // Asigna campos iniciales
        $parte = $this->actualizaValoresParte( $direccion, $cliente, $empresa,2);

        $form = $this->createForm('PartesBundle\Form\PartesType', $parte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($parte);
            $em->flush();
            $this->marcaIncidenciaPlanificado($direccion['0']['incidencia'],true);

            return $this->redirectToRoute('partes_show', array('id' => $parte->getId()));
        }
        //$this->marcaProductoPlanificado($direccion);
        return $this->render('PartesBundle:Default:new.html.twig', array(
            'tipo'          => 'Incidencia',
            'parte'         => $parte,
            'direccion'     => $direccion,
            'form'          => $form->createView(),
            'accionBuscar'  => '',
            'empresa'       => $empresa,
            'cliente'       => $cliente,
        ));
    }    
    
    /**
     * Finds and displays a parte entity.
     *
     */
    public function showAction(Partes $parte)
    {
        $deleteForm = $this->createDeleteForm($parte);
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        return $this->render('PartesBundle:Default:show.html.twig', array(
            'parte' => $parte,
            'delete_form' => $deleteForm->createView(),
            'accionBuscar'  => '',
            'empresa' => $empresa,
        ));
    }

     /**
     * Hoja de ruta a PDF.
     *
     */
    public function rutaPDFAction($fecha, $tecnico)
    {
        $em = $this->getDoctrine()->getManager();
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $partes = $em->getRepository('PartesBundle:Partes')->dameRutaTrabajador($empresa->getId(),$tecnico,$fecha);

        return $this->render('PartesBundle:Default:pdf.html.php', array(
            'tecnico'       => $tecnico,
            'partes'        => $partes,
            'empresa'       => $empresa,
            'fecha'         => $fecha
        ));
    }
    
    /**
     * Displays a form to edit an existing parte entity.
     *
     */
    public function editAction(Request $request, Partes $parte)
    {
        $editForm = $this->createForm('PartesBundle\Form\PartesEditType', $parte);
        $editForm->handleRequest($request);

        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            if ($editForm->get('save')->isClicked()){
                $this->getDoctrine()->getManager()->flush();
                return $this->redirectToRoute('partes_edit', array('id' => $parte->getId()));
            } else {
                return $this->redirectToRoute('partes_eliminar', array('id' => $parte->getId()));
            }
        }

        return $this->render('PartesBundle:Default:edit.html.twig', array(
            'parte' => $parte,
            'edit_form' => $editForm->createView(),
            'accionBuscar'  => '',
            'empresa' => $empresa,
        ));
    }

    /**
     * Deletes a parte entity.
     *
     */
    public function deleteAction(Request $request, Partes $parte)
    {
        $deleteForm = $this->createDeleteForm($parte);
        $terminado = $parte->getTerminado();
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $deleteForm->handleRequest($request);
        $fecha = $parte->getFechaParte()->format('d-m-Y');
        
        if ($deleteForm->isSubmitted() && $deleteForm->isValid()) {
            $producto = $parte->getProducto();           
            foreach ($producto as $item) {
                // Asigna los productos al parte
                $this->marcaProductoPlanificado($item,null);
                // Borra el producto
                $parte->removeProducto($item);
            }
            $incidencia = $parte->getIncidencia();
            if ($incidencia!=null){
                $this->marcaIncidenciaPlanificado($incidencia,null);
            }
            // Elimina el parte
            $em = $this->getDoctrine()->getManager();
            $em->remove($parte);
            $em->flush();
            
            return $this->redirectToRoute('partes_diario', array('fecha' => $fecha));
        }

        return $this->render('PartesBundle:Default:eliminar.html.twig', array(
            'parte' => $parte,
            'delete_form' => $deleteForm->createView(),
            'accionBuscar'  => '',
            'empresa' => $empresa,
        ));
    }

    /**
     * Creates a form to delete a parte entity.
     *
     * @param Partes $parte The parte entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Partes $parte)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partes_delete', array('id' => $parte->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    
    private function actualizaValoresParte($direccion, Cliente $cliente, Empresa $empresa, $tipo){
        // Incluye la descripción de la incidencia como observación del parte de trabajo.
        $textoIncidencia='';
        $parte = new Partes();
        $parte->setEmpresa($empresa->getId());
        $parte->setCliente($cliente);
        $parte->setDireccion($this->getDoctrine()->getRepository('ClientesBundle:Direccion')->find($direccion['0']['id']));
        foreach ( $direccion as $item) {
            // Asigna los productos al parte
            $parte->addProducto($this->getDoctrine()->getRepository('ProductosBundle:Producto')->find($item['producto']));
            // Asigna la incidencia como observación
         if ($tipo==2) {
            $parte->setIncidencia($direccion['0']['incidencia']); // guarda el número de la incidencia
            $textoIncidencia = $textoIncidencia.' - '.$item['descripcion'].PHP_EOL;
        }           
        }
        if ($tipo==2) {
            $parte->setIncidencia($direccion['0']['incidencia']); // guarda el número de la incidencia
            $parte->setObservaciones('Incidencia:'.PHP_EOL.$textoIncidencia);
        }
        $parte->setIVA($direccion['0']['IVA']);
        $parte->setImporte($direccion['0']['importe']);
        if ($cliente->getTipoPago() == 'Pago al contado'){
            $parte->setCobrar(true);
        } else {
            $parte->setCobrar(false);
        }
        return $parte;
    }
    
//    private function dameEmpresaUsuario(){
//        $user = $this->get('security.token_storage')->getToken()->getUser();
//        $empresa = $user->getEmpresa();
//        return $empresa;
//    }
    
    private function procesaProductoParaPlanificarlas($array,$valor){
        // recorre todo el array de productos de la dirección
        foreach ( $array as $item) {
            $producto = $this->getDoctrine()->getRepository('ProductosBundle:Producto')->find($item['producto']);
            $this->marcaProductoPlanificado($producto,$valor);
        }
    }
    
    private function marcaProductoPlanificado($producto,$valor){
        $em = $this->getDoctrine()->getManager();   
        // Marca los productos como planificados 
            $producto->setPlanificada($valor);
            $em->flush($producto);
    }
    
    private function marcaIncidenciaPlanificado($id,$valor){
        $em = $this->getDoctrine()->getManager();
        // Marca la incidencia como planificada
            $incidencia = $this->getDoctrine()->getRepository('IncidenciasBundle:Incidencia')->find($id);
            $incidencia->setPlanificada($valor);
            $em->flush($incidencia);      
    }
    
//    private function convierteFecha(String $fecha){
//        
//        return date("Y-m-d",mktime(0,0,0,intval(substr($fecha,3,2)),intval(substr($fecha,0,2)),intval(substr($fecha,6,4))));
//        
//    }
}

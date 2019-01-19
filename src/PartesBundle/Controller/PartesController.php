<?php

namespace PartesBundle\Controller;

use PartesBundle\Entity\Partes;
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
        $empresa = $this->dameEmpresaUsuario();
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
        $empresa = $this->dameEmpresaUsuario();
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
        $parte = new Partes();
        $empresa = $this->dameEmpresaUsuario();
        $em = $this->getDoctrine()->getManager();
        // Selecciona el producto para el mantenimiento
        $direccion = $em->getRepository('ClientesBundle:Direccion')->dameProductosPorDireccion($id,$fecha);
        $parte->setIVA($direccion['0']['IVA']);

        $form = $this->createForm('PartesBundle\Form\PartesType', $parte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parte->setEmpresa($empresa->getId());
            $parte->setCliente($this->getDoctrine()->getRepository('ClientesBundle:Cliente')->find($direccion['0']['cliente']));
            $parte->setDireccion($this->getDoctrine()->getRepository('ClientesBundle:Direccion')->find($direccion['0']['id']));
            foreach ( $direccion as $item) {
                // Asigna los productos al parte
                $parte->addProducto($this->getDoctrine()->getRepository('ProductosBundle:Producto')->find($item['producto']));
            }
            
            $em->persist($parte);
            $em->flush();
            dump($direccion);
            $this->marcaProductoPlanificado($direccion);
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
        $parte = new Partes();
        $empresa = $this->dameEmpresaUsuario();
        $em = $this->getDoctrine()->getManager();
        // Selecciona la incidencia 
        $direccion = $em->getRepository('ClientesBundle:Direccion')->dameIndicenciasPorDireccion($id);
        // Incluye la descripción de la incidencia como observación del parte de trabajo.
        $parte->setObservaciones('Incidencia:'.$direccion['0']['descripcion']);
        $parte->setIVA($direccion['0']['IVA']);
        $parte->setImporte($direccion['0']['importe']);

        $form = $this->createForm('PartesBundle\Form\PartesType', $parte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $parte->setEmpresa($empresa->getId());
            $parte->setIncidencia($direccion['0']['incidencia']); // guarda el número de la incidencia
            $parte->setCliente($this->getDoctrine()->getRepository('ClientesBundle:Cliente')->find($direccion['0']['cliente']));
            $parte->setDireccion($this->getDoctrine()->getRepository('ClientesBundle:Direccion')->find($direccion['0']['id']));
            $parte->addProducto($this->getDoctrine()->getRepository('ProductosBundle:Producto')->find($direccion['0']['producto']));
            $em->persist($parte);
            $em->flush();
            $this->marcaIncidenciaPlanificado($direccion['0']['incidencia']);

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
        ));
    }    
    
    /**
     * Finds and displays a parte entity.
     *
     */
    public function showAction(Partes $parte)
    {
        $deleteForm = $this->createDeleteForm($parte);
        $empresa = $this->dameEmpresaUsuario();
        return $this->render('PartesBundle:Default:show.html.twig', array(
            'parte' => $parte,
            'delete_form' => $deleteForm->createView(),
            'accionBuscar'  => '',
            'empresa' => $empresa,
        ));
    }

    /**
     * Displays a form to edit an existing parte entity.
     *
     */
    public function editAction(Request $request, Partes $parte)
    {
        $deleteForm = $this->createDeleteForm($parte);
        $editForm = $this->createForm('PartesBundle\Form\PartesType', $parte);
        $editForm->handleRequest($request);
        $empresa = $this->dameEmpresaUsuario();
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partes_edit', array('id' => $parte->getId()));
        }

        return $this->render('PartesBundle:Default:edit.html.twig', array(
            'parte' => $parte,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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
        $form = $this->createDeleteForm($parte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($parte);
            $em->flush();
        }

        return $this->redirectToRoute('partes_listado');
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
    
    private function dameEmpresaUsuario(){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $user->getEmpresa();
        return $empresa;
    }
    
    private function marcaProductoPlanificado($array){
        $em = $this->getDoctrine()->getManager();
        // Marca los productos como planificados 
        dump($array);
        foreach ( $array as $item) {
            $producto = $this->getDoctrine()->getRepository('ProductosBundle:Producto')->find($item['producto']);
            $producto->setPlanificada(true);
            $em->flush($producto);
        }
    }

    private function marcaIncidenciaPlanificado($id){
        $em = $this->getDoctrine()->getManager();
        // Marca la incidencia como planificada
            $incidencia = $this->getDoctrine()->getRepository('IncidenciasBundle:Incidencia')->find($id);
            $incidencia->setPlanificada(true);
            $em->flush($incidencia);      
    }
    
//    private function convierteFecha(String $fecha){
//        
//        return date("Y-m-d",mktime(0,0,0,intval(substr($fecha,3,2)),intval(substr($fecha,0,2)),intval(substr($fecha,6,4))));
//        
//    }
}

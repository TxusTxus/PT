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
        $partes = $em->getRepository('PartesBundle:Partes')->damePartesEmpresa($empresa->getId(),$fecha->format('Y-m-d'));
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
        // $partes = $em->getRepository('PartesBundle:Partes')->findAll();


        $partes = $em->getRepository('PartesBundle:Partes')->damePartesEmpresa($empresa->getId(),$this->convierteFecha($fecha));
        $dias = $em->getRepository('PartesBundle:Partes')->dameFechasPartes($empresa->getId(),$fecha);
        dump($dias);
        dump($partes);
        
        return $this->render('PartesBundle:Default:index.html.twig', array(
            'partes'        => $partes,
            'dias'          => $dias,
            'accionBuscar'  => '',
            'empresa' => $empresa,
            'fecha'         => $fecha
        ));
    }
    

    /**
     * Crear un nuevo parte de trabajo.
     * Valores -> Cliente, Direccion, Producto.
     *
     */
    public function newAction(Request $request)
    {
        $parte = new Parte();
        $empresa = $this->dameEmpresaUsuario();
        $form = $this->createForm('PartesBundle\Form\PartesType', $parte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($parte);
            $em->flush();

            return $this->redirectToRoute('partes_show', array('id' => $parte->getId()));
        }

        return $this->render('PartesBundle:Default:new.html.twig', array(
            'parte' => $parte,
            'form' => $form->createView(),
            'accionBuscar'  => '',
            'empresa' => $empresa,
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
    
    private function convierteFecha(String $fecha){
        
        return date("Y-m-d",mktime(0,0,0,intval(substr($fecha,3,2)),intval(substr($fecha,0,2)),intval(substr($fecha,6,4))));
        
    }
}

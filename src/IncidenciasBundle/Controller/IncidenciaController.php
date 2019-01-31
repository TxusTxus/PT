<?php

namespace IncidenciasBundle\Controller;

use IncidenciasBundle\Entity\Incidencia;
use ClientesBundle\Entity\Direccion;
use ClientesBundle\Entity\Cliente;
use ProductosBundle\Entity\Producto;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Incidencium controller.
 *
 */
class IncidenciaController extends Controller
{
    /**
     * Lists all incidencia entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $incidencias = $em->getRepository('IncidenciasBundle:Incidencia')->findAll();

        return $this->render('IncidenciasBundle:Default:index.html.twig', array(
            'incidencias' => $incidencias,
        ));
    }

    /**
     * Crea una nueva incidencia, los datos de Cliente, direccion y producto le son pasados
     *
     */
    public function newAction(Request $request, Cliente $cliente, Direccion $direccion, Producto $producto)
    {
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $incidencia = new Incidencia();
        $incidencia->setCliente($cliente);
        $incidencia->setDireccion($direccion);
        $incidencia->setProducto($producto);
        $form = $this->createForm('IncidenciasBundle\Form\IncidenciaType', $incidencia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($incidencia);
            $em->flush();

            return $this->redirectToRoute('cliente_show', array('id' => $cliente->getId(),'ficha'=>'incidencias'));
        }

        return $this->render('IncidenciasBundle:Default:new.html.twig', array(
            'incidencia' => $incidencia,
            'accionBuscar'  => 'cliente_busca',
            'empresa' => $empresa,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a incidencia entity.
     *
     */
    public function showAction(Incidencia $incidencia)
    {
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $deleteForm = $this->createDeleteForm($incidencia);

        return $this->render('IncidenciasBundle:Default:show.html.twig', array(
            'incidencia' => $incidencia,
            'delete_form' => $deleteForm->createView(),
            'accionBuscar'  => 'cliente_busca',
            'empresa' => $empresa,
        ));
    }

    /**
     * Displays a form to edit an existing incidencia entity.
     *
     */
    public function editAction(Request $request, Incidencia $incidencia)
    {
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $deleteForm = $this->createDeleteForm($incidencia);
        $editForm = $this->createForm('IncidenciasBundle\Form\IncidenciaEditType', $incidencia);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cliente_show', array('id' => $incidencia->getCliente()->getId(), 'ficha'=>'incidencias'));
        }

        return $this->render('IncidenciasBundle:Default:edit.html.twig', array(
            'incidencia' => $incidencia,
            'accionBuscar'  => 'cliente_busca',
            'empresa' => $empresa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a incidencia entity.
     *
     */
    public function deleteAction(Request $request, Incidencia $incidencia)
    {
        $form = $this->createDeleteForm($incidencia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($incidencia);
            $em->flush();
        }

        return $this->redirectToRoute('incidencia_index');
    }

    /**
     * Creates a form to delete a incidencia entity.
     *
     * @param Incidencia $incidencia The incidencia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Incidencia $incidencia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('incidencia_delete', array('id' => $incidencia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
 
}

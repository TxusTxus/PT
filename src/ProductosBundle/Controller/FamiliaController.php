<?php

namespace ProductosBundle\Controller;

use ProductosBundle\Entity\Familia;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Familium controller.
 *
 */
class FamiliaController extends Controller
{
    /**
     * Lists all familia entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $familias = $em->getRepository('ProductosBundle:Familia')->findAll();

        return $this->render('ProductosBundle:familia:index.html.twig', array(
            'familias' => $familias,
            'empresa'       => $empresa,
            'accionBuscar'  => 'cliente_busca',
        ));
    }

    /**
     * Creates a new familia entity.
     *
     */
    public function newAction(Request $request)
    {
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $familia = new Familia();
        $form = $this->createForm('ProductosBundle\Form\FamiliaType', $familia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($familia);
            $em->flush();

            return $this->redirectToRoute('familia_show', array('id' => $familia->getId()));
        }

        return $this->render('ProductosBundle:familia:new.html.twig', array(
            'familia' => $familia,
            'form' => $form->createView(),
            'empresa'       => $empresa,
            'accionBuscar'  => 'cliente_busca',
        ));
    }


    /**
     * Displays a form to edit an existing familia entity.
     *
     */
    public function editAction(Request $request, Familia $familia)
    {
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $deleteForm = $this->createDeleteForm($familia);
        $editForm = $this->createForm('ProductosBundle\Form\FamiliaType', $familia);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('listado_familias');
        }

        return $this->render('ProductosBundle:familia:edit.html.twig', array(
            'familia' => $familia,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'empresa'       => $empresa,
            'accionBuscar'  => 'cliente_busca',
        ));
    }

    /**
     * Deletes a familia entity.
     *
     */
    public function deleteAction(Request $request, Familia $familia)
    {
        $form = $this->createDeleteForm($familia);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($familia);
            $em->flush();
        }

        return $this->redirectToRoute('familia_index');
    }

    /**
     * Creates a form to delete a familia entity.
     *
     * @param Familia $familia The familia entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Familia $familia)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('familia_delete', array('id' => $familia->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

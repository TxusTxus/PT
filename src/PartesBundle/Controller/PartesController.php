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
     * Lists all parte entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $partes = $em->getRepository('PartesBundle:Partes')->findAll();

        return $this->render('partes/index.html.twig', array(
            'partes' => $partes,
        ));
    }

    /**
     * Creates a new parte entity.
     *
     */
    public function newAction(Request $request)
    {
        $parte = new Parte();
        $form = $this->createForm('PartesBundle\Form\PartesType', $parte);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($parte);
            $em->flush();

            return $this->redirectToRoute('partes_show', array('id' => $parte->getId()));
        }

        return $this->render('partes/new.html.twig', array(
            'parte' => $parte,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a parte entity.
     *
     */
    public function showAction(Partes $parte)
    {
        $deleteForm = $this->createDeleteForm($parte);

        return $this->render('partes/show.html.twig', array(
            'parte' => $parte,
            'delete_form' => $deleteForm->createView(),
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

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('partes_edit', array('id' => $parte->getId()));
        }

        return $this->render('partes/edit.html.twig', array(
            'parte' => $parte,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
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

        return $this->redirectToRoute('partes_index');
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
}

<?php

namespace AlbaranesBundle\Controller;

use AlbaranesBundle\Entity\Albaran;
use AlbaranesBundle\Entity\Conceptos;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Albaran controller.
 *
 */
class AlbaranController extends Controller
{
    /**
     * Lists all albaran entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $albaran = $em->getRepository('AlbaranesBundle:Albaran')->findAll();

        return $this->render('AlbaranesBundle:Default:index.html.twig', array(
            'albarans' => $albaran,
            'empresa'       => $empresa,
            'accionBuscar'  => 'albaran_busca',
        ));
    }

    /**
     * Crea un nuevo albarán, una nueva venta.
     * -> Dirije a nuevo concepto
     *
     */
    public function newAction(Request $request)
    {
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $albaran = new Albaran();
        $fecha = new \DateTime;
        $albaran->setFecha($fecha);
        $form = $this->createForm('AlbaranesBundle\Form\AlbaranEditType', $albaran);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($albaran);
            $em->flush();

            return $this->redirectToRoute('concepto_nuevo', array('albaran' => $albaran->getId()));
        }

        return $this->render('AlbaranesBundle:Default:new.html.twig', array(
            'albaran' => $albaran,
            'form' => $form->createView(),
            'empresa'       => $empresa,
            'accionBuscar'  => 'cliente_busca'
        ));
    }

    /**
     * Finds and displays a albaran entity.
     *
     */
    public function showAction(Albaran $albaran)
    {
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
//        $deleteForm = $this->createDeleteForm($albaran);

        return $this->render('AlbaranesBundle:Default:show.html.twig', array(
            'albaran' => $albaran,
            'empresa'       => $empresa,
            'accionBuscar'  => 'albaran_busca',
            
        ));
    }

    /**
     * Displays a form to edit an existing albaran entity.
     *
     */
    public function editAction(Request $request, Albaran $albaran)
    {
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $editForm = $this->createForm('AlbaranesBundle\Form\AlbaranEditType', $albaran);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        }

        return $this->render('AlbaranesBundle:Default:edit.html.twig', array(
            'albaran' => $albaran,
            'edit_form' => $editForm->createView(),
            'empresa'       => $empresa,
            'accionBuscar'  => 'albaran_busca',
        ));
    }

    
    
     /**
     * Muestra una nueva linea de concepto para el albaran
     *
     */
    public function nuevoConceptoAction(Request $request, Albaran $albaran)
    {
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $concepto = new Conceptos();
        $concepto->addAlbaran($albaran);
        $editForm = $this->createForm('AlbaranesBundle\Form\ConceptoType', $concepto);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($concepto);
            $em->flush($concepto);
            
            $albaran->addConcepto($concepto);
            $em->flush($albaran);
            $importeTotal = $this->getDoctrine()->getRepository('AlbaranesBundle:Conceptos')->dameImporteTotalAlbaran($albaran->getId());
            $albaran->setTotal($importeTotal);
            $em->flush($albaran);
            $concepto = new Conceptos();
            $concepto->addAlbaran($albaran);
            $editForm = $this->createForm('AlbaranesBundle\Form\ConceptoType', $concepto);
            
        } 
        return $this->render('AlbaranesBundle:Default:nuevoConcepto.html.twig', array(
            'venta' => $albaran,
            'edit_form' => $editForm->createView(),
            'empresa'       => $empresa,
            'accionBuscar'  => 'albaran_busca',
        ));
    }
    
    
     /**
     * Busca albaranes en todos sus campos según la cadena de búsqueda
     *
     */    
    public function buscaAlbaranesNombreAction(Request $request)
    {
        $cadena = $request->request->get("CadenaBusqueda");
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        
        if (strlen($cadena)>=1){
            $albaranes = $this->getDoctrine()->getRepository('AlbaranesBundle:Albaran')->buscaAlbaranSegunTexto($cadena);
        } else {
            $em = $this->getDoctrine()->getManager();
            $albaranes = $em->getRepository('AlbaranesBundle:Albaran')->findAll();
        }
        return $this->render('AlbaranesBundle:Default:index.html.twig', array(
            'albarans' => $albaranes,
            'empresa'       => $empresa,
            'accionBuscar'  => 'albaran_busca',
        ));
    }  
    
    
     /**
     * Albaran a PDF para impresion.
     *
     */
    public function albaranPDFAction(Albaran $albaran)
    {
        $em = $this->getDoctrine()->getManager();
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
//        $partes = $em->getRepository('PartesBundle:Partes')->dameRutaTrabajador($empresa->getId(),$tecnico,$fecha);

        return $this->render('AlbaranesBundle:Default:albaranpdf.html.php', array(
            'albaran'       => $albaran,
            'empresa'       => $empresa,
        ));
    }
    
//    /**
//     * Deletes a albaran entity.
//     *
//     */
//    public function deleteAction(Request $request, Albaran $albaran)
//    {
//        $form = $this->createDeleteForm($albaran);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($albaran);
//            $em->flush();
//        }
//
//        return $this->redirectToRoute('albaran_index');
//    }
//
//    /**
//     * Creates a form to delete a albaran entity.
//     *
//     * @param Albaran $albaran The albaran entity
//     *
//     * @return \Symfony\Component\Form\Form The form
//     */
//    private function createDeleteForm(Albaran $albaran)
//    {
//        return $this->createFormBuilder()
//            ->setAction($this->generateUrl('albaran_delete', array('id' => $albaran->getId())))
//            ->setMethod('DELETE')
//            ->getForm()
//        ;
//    }
}

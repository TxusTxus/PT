<?php

namespace ClientesBundle\Controller;

use Libreria;

use ClientesBundle\Entity\Direccion;
use \ClientesBundle\Entity\Distrito;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Direccion controller.
 *
 */
class DireccionController extends Controller
{
//    /**
//     * Lists all direccion entities.
//     *
//     */
//    public function indexAction()
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $direccions = $em->getRepository('ClientesBundle:Direccion')->findAll();
//
//        return $this->render('ClientesBundle:direccion:index.html.twig', array(
//            'direccions' => $direccions,
//        ));
//    }

//    /**
//     * Creates a new direccion entity.
//     *
//     */
//    public function newAction(Request $request)
//    {
//        $direccion = new Direccion();
//        $form = $this->createForm('ClientesBundle\Form\DireccionType', $direccion);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($direccion);
//            $em->flush();
//
//            return $this->redirectToRoute('direccion_show', array('id' => $direccion->getId()));
//        }
//
//        return $this->render('direccion/new.html.twig', array(
//            'direccion' => $direccion,
//            'form' => $form->createView(),
//        ));
//    }

//    /**
//     * Finds and displays a direccion entity.
//     *
//     */
//    public function showAction(Direccion $direccion)
//    {
//        $deleteForm = $this->createDeleteForm($direccion);
//
//        return $this->render('direccion/show.html.twig', array(
//            'direccion' => $direccion,
//            'delete_form' => $deleteForm->createView(),
//        ));
//    }

    /**
     * Displays a form to edit an existing direccion entity.
     *
     */
    public function editaDireccionAction(Request $request, Direccion $direccion)
    {
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
        $cliente = $this->getDoctrine()->getRepository('ClientesBundle:Direccion')->dameClienteDireccion($direccion->getId());
        
 
        $deleteForm = $this->createDeleteForm($direccion);
        $editForm = $this->createForm('ClientesBundle\Form\DireccionType', $direccion);
        $editForm->handleRequest($request);
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            // Guarda el nuevo distrito y lo asigna a la dirección
            $Ndistrito = $request->request->get('clientesbundle_direccion')['Ndistrito'];
            if (strlen($Ndistrito)>0){
                $distrito = $this->guardaNuevoDistrito($Ndistrito);
                $direccion->setDistrito($distrito);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cliente_editar_direccion', array('id' => $direccion->getId()));
        }

        return $this->render('ClientesBundle:direccion:edit.html.twig', array(
            'direccion'     => $direccion,
            'cliente'       => $cliente,
            'empresa'       => $empresa,
            'edit_form'     => $editForm->createView(),
            'delete_form'   => $deleteForm->createView(),
            'accionBuscar'  => 'cliente_busca',
        ));
    }

    public function listadoDistritosAction(Request $request){
        $empresa = $this->get('security.token_storage')->getToken()->getUser()->getEmpresa();
//        $listado = $this->getDoctrine()->getRepository('ClientesBundle:Direccion')->dameDistritoDireccion();
        $buscarForm = $this->createForm('ClientesBundle\Form\ListadoRevisionesType');
        $buscarForm->handleRequest($request);
//        $fin = new \DateTime;
//        $fecha = new \DateTime;
        $inicio =date("Y-m-d",mktime(0,0,0,11,1,2018));
        if ($buscarForm->isSubmitted() && $buscarForm->isValid()) {
            $datos = Libreria::dameFechas($buscarForm->get('mes')->getData(),$buscarForm->get('fechaDesde')->getData(),$buscarForm->get('fechaHasta')->getData());

        } else {
            // Mes actual
            $datos = Libreria::dameFechas(null,null,null);
        }
            

        $listado = $this->getDoctrine()->getRepository('ClientesBundle:Direccion')->dameDistritoDireccionEntreFechas($datos['inicio'], $datos['fin']);
        $listadoIncidencias = $this->getDoctrine()->getRepository('ClientesBundle:Direccion')->dameDistritoDireccionIncidenciasEntreFechas($datos['inicio'], $datos['fin']);
        
        $listadoAnteriores = $this->getDoctrine()->getRepository('ClientesBundle:Direccion')->dameMantenimientosAnteriores($inicio, $datos['inicio']);
        return $this->render('ClientesBundle:distritos:listado.html.twig', array(
            'form_buscar'       => $buscarForm->createView(),
            'listado'           => $listado,
            'listadoIncidencias'=> $listadoIncidencias,
            'anteriores'        => $listadoAnteriores,
//            'cliente'       => $cliente,
            'fechaInicio'       => $datos['inicio'],
            'fechaFin'          => $datos['fin'],
            'empresa'           => $empresa,
            'accionBuscar'      => 'cliente_busca'
        ));
    }
//    private function dameFechas($mes,$inicio,$fin){
//        $datos=[];
//        $fecha = new \DateTime;
//        $anio = $fecha->format("Y");
//        
//            if (is_null($mes)) {
//                if (!is_null($inicio)) {
//                    $datos['inicio'] = $inicio->format("Y-m-d");
//                    if (!is_null($fin)) {
//                        $datos['fin']= $fin->format("Y-m-d");
//                    }
//                } else {
//                    $mes = $fecha->format("m");
//                    $datos['inicio'] =date("Y-m-d",mktime(0,0,0,$mes,1,$anio));
//                    $datos['fin'] =date("Y-m-d",mktime(0,0,0,$mes+1,0,$anio));                    
//                }
//
//            } else {
//                $datos['inicio'] =date("Y-m-d",mktime(0,0,0,$mes,1,$anio));
//                $datos['fin'] =date("Y-m-d",mktime(0,0,0,$mes+1,0,$anio));
//            }
//        return $datos;
//    }




    private function guardaNuevoDistrito($NDistrito){
        $distrito = new Distrito();
            $em = $this->getDoctrine()->getManager();
            $distrito->setDistrito($NDistrito);
            $em->persist($distrito);
            $em->flush();        
        return $distrito;
    }
        
    public function actualizaDireccionPrincipalAction(Direccion $id, Direccion $id2){
        // Actualiza como principal la direccion id quitándola de $id2
        $cliente = $this->getDoctrine()->getRepository('ClientesBundle:Direccion')->dameClienteDireccion($id2->getId());
        $em = $this->getDoctrine()->getManager();
        $id2->setPrincipal(null);
        $em->flush($id2);
        $id->setPrincipal(true);
        $em->flush($id);
        return $this->redirectToRoute('cliente_show', array('id' => $cliente,'ficha'=>'ficha'));
    }
    
    
    /**
     * Deletes a direccion entity.
     *
     */
    public function deleteAction(Request $request, Direccion $direccion)
    {
        $form = $this->createDeleteForm($direccion);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($direccion);
            $em->flush();
        }

        return $this->redirectToRoute('direccion_index');
    }

    /**
     * Creates a form to delete a direccion entity.
     *
     * @param Direccion $direccion The direccion entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Direccion $direccion)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('direccion_delete', array('id' => $direccion->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
      

}

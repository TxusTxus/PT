<?php

namespace TrabajadoresBundle\Controller;

use TrabajadoresBundle\Entity\Trabajadores;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Trabajadores controller.
 *
 */
class TrabajadoresController extends Controller
{
    /**
     * Lists all trabajadores entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $empresa = $this->dameEmpresaUsuario();
        $trabajadores = $em->getRepository('TrabajadoresBundle:Trabajadores')->findAll();

        return $this->render('TrabajadoresBundle:Default:index.html.twig', array(
            'trabajadores' => $trabajadores,
            'accionBuscar'  => 'buscaTrabajador',
            'nombreEmpresa' => $empresa->getNombre()
        ));
    }

    /**
     * Creates a new trabajadores entity.
     *
     */
    public function newAction(Request $request)
    {
        $trabajadores = new Trabajadores();
        $empresa = $this->dameEmpresaUsuario();  
        $form = $this->createForm('TrabajadoresBundle\Form\TrabajadoresType', $trabajadores);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $trabajadores->setEmpresa($empresa);
            $trabajadores->setCodigoActivacion($this->codigoActivacion());
            $em = $this->getDoctrine()->getManager();
            $em->persist($trabajadores);
            $em->flush();

            return $this->redirectToRoute('trabajadores_show', array('id' => $trabajadores->getId(),'ficha' => 'ficha'));
        }

        return $this->render('TrabajadoresBundle:Default:new.html.twig', array(
            'trabajadores' => $trabajadores,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a trabajadore entity.
     *
     */
    public function showAction(Trabajadores $trabajadores,$ficha=null)
    {
        $deleteForm = $this->createDeleteForm($trabajadores);
        $empresa = $this->dameEmpresaUsuario();  
        $posicion =$this->dameAnteriorPosterior($empresa->getId(), $trabajadores->getId());
        
        return $this->render('TrabajadoresBundle:Default:show.html.twig', array(
            'trabajadores' => $trabajadores,
            'delete_form' => $deleteForm->createView(),
            'nombreEmpresa' => $empresa->getNombre(),
            'accionBuscar'  => 'buscaTrabajador',
            'ficha'         => $ficha,
            'btnPri' => $posicion['primero'],
            'btnAnt' => $posicion['anterior'],
            'btnPost' => $posicion['posterior'],
            'btnUlt' => $posicion['ultimo']
        ));
    }

    /**
     * Displays a form to edit an existing trabajadore entity.
     *
     */
    public function editAction(Request $request, Trabajadores $trabajadores)
    {
        $deleteForm = $this->createDeleteForm($trabajadores);
        $editForm = $this->createForm('TrabajadoresBundle\Form\TrabajadoresType', $trabajadores);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trabajadores_edit', array('id' => $trabajadores->getId()));
        }

        return $this->render('TrabajadoresBundle:Default:edit.html.twig', array(
            'trabajadore' => $trabajadores,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a trabajadore entity.
     *
     */
    public function deleteAction(Request $request, Trabajadores $trabajadores)
    {
        $form = $this->createDeleteForm($trabajadores);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($trabajadores);
            $em->flush();
        }

        return $this->redirectToRoute('trabajadores_lista');
    }

    /**
     * Creates a form to delete a trabajadore entity.
     *
     * @param Trabajadores $trabajadores The trabajadore entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Trabajadores $trabajadores)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('trabajadores_baja', array('id' => $trabajadores->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
    
    private function dameEmpresaUsuario(){
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $user->getEmpresa();
        return $empresa;
    }
    
    /**
     * Busca trabajadores en todos sus campos según la cadena de búsqueda
     *
     */    
    public function buscaTrabajadorNombreAction(Request $request)
    {

        $cadena = $request->request->get("CadenaBusqueda");
        $empresa = $this->dameEmpresaUsuario();        
        $trabajadores = $this->getDoctrine()->getRepository('TrabajadoresBundle:Trabajadores')->buscaTrabajadoresSegunTexto($cadena,$empresa->getId());

        return $this->render('TrabajadoresBundle:Default:index.html.twig', array(
            'trabajadores'      => $trabajadores,
            'nombreEmpresa' => $empresa->getNombre(),
            'accionBuscar'  => 'buscaTrabajador',
            'filtro'        => true
            )); 
    }  
    
    private function dameAnteriorPosterior($numEmpresa, $numTrabajador){
        $posiciones = [];
        $posiciones['ultimo']=0;
        $leerposterior = false;
        $arrayTrabajadores = $this->getDoctrine()->getRepository('TrabajadoresBundle:Trabajadores')->dameListaTrabajadoresArray($numEmpresa);
        $posiciones['primero'] = $arrayTrabajadores[0]['id'];
        foreach ($arrayTrabajadores as $item){
            if ($leerposterior) {
                $posiciones['posterior'] = $item['id'];
                $leerposterior=false;
            }
            if ($item['id']==$numTrabajador){
                $posiciones['anterior'] =$posiciones['ultimo'];
                $posiciones['posterior'] = 0; // para el caso de que sea el último de la fila
                $leerposterior=true;
            }
            $posiciones['ultimo'] = $item['id'];
        }
        return $posiciones;
    }
    
    public function codigoActivacion(){
        
        $cadena=chr(rand(65,90));
        for ($i = 1; $i <= 8; $i++) {
            $opcion = rand(1,3);
            switch ($opcion) {
            case 1:
                $cadena.=chr(rand(65,90));
                break;
            case 2:
                $cadena.=chr(rand(97,122));
                break;                
            case 3:
                $cadena.=chr(rand(48,57));
                break; 
            }
        }
        return $cadena;
    }
}

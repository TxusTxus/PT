<?php

namespace ClientesBundle\Controller;

use ClientesBundle\Entity\Cliente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cliente controller.
 *
 */
class ClienteController extends Controller
{
    /**
     * Lista todos los clientes de una empresa.
     *
     */
    public function indexAction()
    {
        $empresa = $this->dameEmpresaUsuario();

        $clientes = $this->getDoctrine()->getRepository('ClientesBundle:Cliente')->dameClientesEmpresa($empresa);

        return $this->render('ClientesBundle:Default:index.html.twig', array(
            'clientes'      => $clientes,
            'nombreEmpresa' => $empresa->getNombre(),
            'accionBuscar'  => 'buscaCliente',
            'filtro'        => false
        ));
    }

    /**
     * Creates a new cliente entity.
     *
     */
    public function newAction(Request $request)
    {
        $empresa = $this->dameEmpresaUsuario();
        $cliente = new Cliente();
        $form = $this->createForm('ClientesBundle\Form\ClienteType', $cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Añade la empresa del usuario que crea el cliente
            $cliente->setEmpresa($empresa);
            $em = $this->getDoctrine()->getManager();
            $em->persist($cliente);
            $em->flush();

            return $this->redirectToRoute('cliente_show', array('id' => $cliente->getId()));
        }

        return $this->render('ClientesBundle:Default:new.html.twig', array(
            'cliente' => $cliente,
            'form' => $form->createView(),
            'nombreEmpresa' => $empresa->getNombre(),
            'accionBuscar'  => ''
        ));
    }

    /**
     * Finds and displays a cliente entity.
     *
     */
    public function showAction(Cliente $cliente,$ficha=null)
    {

        $empresa = $this->dameEmpresaUsuario();
        $empresaCliente = $cliente->getEmpresa();
        if ($empresa!=$empresaCliente) {
            print_r('Sin concordancia...'.$empresa.'->'.$empresaCliente.'<br>');
            die();
        }
        $deleteForm = $this->createDeleteForm($cliente);
        // Obtiene el anterior y siguiente cliente para los manejadores
        $posicion =$this->dameAnteriorPosterior($empresa->getId(), $cliente->getId());

        return $this->render('ClientesBundle:Default:show.html.twig', array(
            'cliente'       => $cliente,
            'delete_form'   => $deleteForm->createView(),
            'nombreEmpresa' => $empresa->getNombre(),
            'accionBuscar'  => 'buscaCliente',
            'ficha'         => $ficha,
            'btnPri' => $posicion['primero'],
            'btnAnt' => $posicion['anterior'],
            'btnPost' => $posicion['posterior'],
            'btnUlt' => $posicion['ultimo']
        ));
    }
    
    private function dameAnteriorPosterior($numEmpresa, $numCliente){
        $posiciones = [];
        $posiciones['ultimo']=0;
        $leerposterior = false;
        $arrayClientes = $this->getDoctrine()->getRepository('ClientesBundle:Cliente')->dameListaClientesArray($numEmpresa);
        $posiciones['primero'] = $arrayClientes[0]['id'];
        foreach ($arrayClientes as $item){
            if ($leerposterior) {
                $posiciones['posterior'] = $item['id'];
                $leerposterior=false;
            }
            if ($item['id']==$numCliente){
                $posiciones['anterior'] =$posiciones['ultimo'];
                $posiciones['posterior'] = 0; // para el caso de que sea el último de la fila
                $leerposterior=true;
            }
            $posiciones['ultimo'] = $item['id'];
        }
        return $posiciones;
    }

    /**
     * Displays a form to edit an existing cliente entity.
     *
     */
    public function editAction(Request $request, Cliente $cliente)
    {
        $empresa = $this->dameEmpresaUsuario();
        $deleteForm = $this->createDeleteForm($cliente);
        $editForm = $this->createForm('ClientesBundle\Form\ClienteType', $cliente);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cliente_edit', array('id' => $cliente->getId()));
        }

        return $this->render('ClientesBundle:Default:edit.html.twig', array(
            'cliente' => $cliente,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'nombreEmpresa' => $empresa->getNombre(),
            'accionBuscar'  => ''
        ));
    }

    /**
     * Deletes a cliente entity.
     *
     */
    public function deleteAction(Request $request, Cliente $cliente)
    {
        $form = $this->createDeleteForm($cliente);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->remove($cliente);
//            $em->flush();
        }

        return $this->redirectToRoute('cliente_lista');
    }

    /**
     * Creates a form to delete a cliente entity.
     *
     * @param Cliente $cliente The cliente entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cliente $cliente)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cliente_delete', array('id' => $cliente->getId())))
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
     * Busca clientes en todos sus campos según la cadena de búsqueda
     *
     */    
    public function buscaClienteNombreAction(Request $request)
    {

        $cadena = $request->request->get("CadenaBusqueda");
        $empresa = $this->dameEmpresaUsuario();        
        $clientes = $this->getDoctrine()->getRepository('ClientesBundle:Cliente')->buscaClientesSegunTexto($cadena,$empresa->getId());

        return $this->render('ClientesBundle:Default:index.html.twig', array(
            'clientes'      => $clientes,
            'nombreEmpresa' => $empresa->getNombre(),
            'accionBuscar'  => 'buscaCliente',
            'filtro'        => true
            )); 
    }  
}

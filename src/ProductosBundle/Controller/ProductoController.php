<?php

namespace ProductosBundle\Controller;

use ProductosBundle\Entity\Producto;
use ClientesBundle\Entity\Cliente;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Producto controller.
 *
 */
class ProductoController extends Controller
{
    /**
     * Lists all producto entities.
     *
     */
    public function indexAction()
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $user->getEmpresa();
        
        $em = $this->getDoctrine()->getManager();

        $productos = $em->getRepository('ProductosBundle:Producto')->findAll();

        return $this->render('ProductosBundle:Default:index.html.twig', array(
            'productos'     => $productos,
            'empresa'       => $empresa,
            'accionBuscar'  => 'cliente_busca',
        ));
    }

    /**
     * Creates a new producto entity.
     *
     */
    public function newAction(Request $request,Cliente $cliente)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $user->getEmpresa();
        
        $producto = new Producto();

        $direcciones = $cliente->getDirecciones();
        
        $form = $this->createForm('ProductosBundle\Form\ProductoType', $producto, array('direcciones' => $direcciones));

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Ndireccion = $request->request->get('productosbundle_producto')['seleccionDireccion'];
            if (strlen($Ndireccion)>0){
                $direccion = $this->getDoctrine()->getRepository('ClientesBundle:Direccion')->find($Ndireccion);
                $producto->setDireccion($direccion);
            }
            $producto->addCliente($cliente);
            $cliente->addProducto($producto);
            $em = $this->getDoctrine()->getManager();
            $em->persist($producto);
            $em->flush();

            return $this->redirectToRoute('cliente_show', array('id' => $cliente->getId(), 'ficha' =>'productos'));
        }

        return $this->render('ProductosBundle:Default:new.html.twig', array(
            'titulo'        => 'Nuevo producto',
            'producto'      => $producto,
            'form'          => $form->createView(),
            'empresa'       => $empresa,
            'direcciones'   => $direcciones,
            'cliente'       => $cliente->getId(),
            'accionBuscar'  => 'cliente_busca',
        ));
    }

    /**
     * Finds and displays a producto entity.
     *
     */
    public function showAction(Producto $producto)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $user->getEmpresa();
        $deleteForm = $this->createDeleteForm($producto);

        return $this->render('ProductosBundle:Default:show.html.twig', array(
            'producto' => $producto,
            'delete_form' => $deleteForm->createView(),
            'empresa'       => $empresa,
            'accionBuscar'  => 'cliente_busca',
        ));
    }

    /**
     * Displays a form to edit an existing producto entity.
     *
     */
    public function editAction(Request $request, Producto $producto, Cliente $cliente)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $user->getEmpresa();
        
        $direcciones = $cliente->getDirecciones();
        $form = $this->createForm('ProductosBundle\Form\ProductoType', $producto, array('direcciones' => $direcciones));
        
//        $editForm = $this->createForm('ProductosBundle\Form\ProductoType', $producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $Ndireccion = $request->request->get('productosbundle_producto')['seleccionDireccion'];
            if (strlen($Ndireccion)>0){
                $direccion = $this->getDoctrine()->getRepository('ClientesBundle:Direccion')->find($Ndireccion);
                $producto->setDireccion($direccion);
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cliente_show', array('id' => $cliente->getId(), 'ficha' =>'productos'));
        }

        return $this->render('ProductosBundle:Default:new.html.twig', array(
            'titulo'        => 'Modificar producto',
            'producto'      => $producto,
            'empresa'       => $empresa,
            'direcciones'   => $direcciones,
            'accionBuscar'  => 'cliente_busca',
            'cliente'       => $cliente->getId(),
            'form'          => $form->createView()
        ));
    }

    /**
     * Deletes a producto entity.
     *
     */
    public function deleteAction(Request $request, Producto $producto)
    {
        $form = $this->createDeleteForm($producto);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($producto);
            $em->flush();
        }

        return $this->redirectToRoute('producto_index');
    }

    /**
     * Creates a form to delete a producto entity.
     *
     * @param Producto $producto The producto entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Producto $producto)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('producto_delete', array('id' => $producto->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

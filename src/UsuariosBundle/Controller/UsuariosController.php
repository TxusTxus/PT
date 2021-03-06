<?php

namespace UsuariosBundle\Controller;

use UsuariosBundle\Controller\librerias\funciones;
use UsuariosBundle\Controller\librerias\QR_BarCode;

use UsuariosBundle\Entity\User;
//use TrabajadoresBundle\Entity\Trabajadores;
//use ClientesBundle\Entity\Cliente;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * User controller.
 *
 * @Route("/")
 */
class UsuariosController extends Controller
{
    /**
     * Lists all user entities.
     *
     * @Route("/", name="user_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $user = $this->get('security.token_storage')->getToken()->getUser();
        // Opción QR
        $cadena = '';
        dump($cadena);
        
        $muestra='';
        // Fin opción QR
        $roles = $user->getRoles();
        if (isset($roles[0])) {
            switch ($roles[0]){
                case 'ROLE_ADMIN':
                            $em = $this->getDoctrine()->getManager();
                            $users = $em->getRepository('UsuariosBundle:User')->findAll();
                            return $this->render('UsuariosBundle:Default:listadoUsuarios.html.twig', array(
                                'users'     => $users,
                                'muestra'    => $muestra
                            ));
                    break;
                case 'ROLE_QR':
                            // opción código QR
                            $cadena = $request->request->get("nombreQR");
                            if (strlen($cadena)>0) {
                                $fecha = new \DateTime;
                                $cadena = 'Se ha generado un QR con el nombre: '.$cadena.' en el instante  '.$fecha->format('d-m-Y h:i:s');
                                 $imagen = $this->generaQR($cadena);
                                 $muestra = 'si';
                            }
                            // Fin QR
                            return $this->render('UsuariosBundle:Default:QR.html.twig', array(
                                'cadenaQR'  => $cadena,
                                'muestra'    => $muestra
                            ));
                    break;
                case 'ROLE_USER':
                    return $this->redirectToRoute('user_inicio');
                    break;
            }
        }
        

    }

    

    public function generaQR($nombre)
    {
        $qr = new QR_BarCode();
        $qr->text($nombre); 
        $qr->qrCode(350,'QR-reunion.png');
    }   
       
    /**
    * @Route("/login", name="login")
    */
    public function loginAction(Request $request){

        $cadena = '';
        $authenticationUtils = $this->get('security.authentication_utils');
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        //recoge todos los datos del user
        $user = $this->get('security.token_storage')->getToken()->getUser();

        // Selecciona por tipo de usuario
        if($user != 'anon.'){
            $baja = $user->getBaja();
            if ($baja==true){
                return $this->AccionNoPermitida();
            } else {
                return $this->iniciaAccesoUsuario($user);
            }

        } else {

            return $this->render('UsuariosBundle:Default:index.html.twig', array(
              'last_username' => $lastUsername,
              'error'         => $error,
              'cadena'        => $cadena
            ));
        }
    }
    
    public function iniciaAccesoUsuario(User $user){
        $this->registraActividad($user);
        $roles = $user->getRoles();
        if (isset($roles[0])) {
            switch ($roles[0]){
                case 'ROLE_ADMIN':
                    return $this->redirectToRoute('user_inicio');
                    break;
                case 'ROLE_USER':
                    return $this->redirectToRoute('user_inicio');
                    break;
            }
        }
    }
    
    /**
    * @Route("/logout", name="logout")
    */
    public function logoutAction()
    {
      return $this->render('UsuarioBundle:Default:index.html.twig');
    }
    
    
    /**
     * Creates a new user entity.
     *
     * @Route("/nuevousuario", name="user_nuevo")
     * @Method({"GET", "POST"})
     */
    public function nuevoAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm('UsuariosBundle\Form\UserType', $user);
        $form->handleRequest($request);
        $authenticationUtils = $this->get('security.authentication_utils');
        $error = $authenticationUtils->getLastAuthenticationError();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $password = $this->get('security.password_encoder')->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(["ROLE_USER"]);
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $numUsuario = $user->getId()*23;
            return $this->redirectToRoute('user_show', array('usuario' => $numUsuario));
        }

        return $this->render('UsuariosBundle:Default:new.html.twig', array(
            'user' => $user,
            'form' => $form->createView(),
        ));
    }

    
    /**
     * Finds and displays a user entity.
     *
     * @Route("/inicio", name="user_inicio")
     * @Method("GET")
     */
    public function usuarioInicioAction()
    {
        // Mira al usuario que está logeado
        $user = $this->get('security.token_storage')->getToken()->getUser();
        $empresa = $user->getEmpresa();

        return $this->render('UsuariosBundle:Default:inicioEmpresa.html.twig', array(
            'user'          => $user,
            'empresa'       => $empresa,
            'accionBuscar'  => 'cliente_busca'
        ));
    }    
    /**
     * Finds and displays a user entity.
     *
     * @Route("/usuario/{usuario}", name="user_show")
     * @Method("GET")
     */
    public function showAction($usuario)
    {
        $user = $this->getDoctrine()->getRepository('UsuariosBundle:User')->find($usuario/23);
        $empresa = $user->getEmpresa();
        $deleteForm = $this->createDeleteForm($user);

        return $this->render('UsuariosBundle:Default:show.html.twig', array(
            'user' => $user,
            'empresa'       => $empresa,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing user entity.
     *
     * @Route("/{usuario}/edit", name="user_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request,$usuario)
    {
        $user = $this->getDoctrine()->getRepository('UsuariosBundle:User')->find($usuario/23);
        $empresa = $user->getEmpresa();
        $deleteForm = $this->createDeleteForm($user);
        $editForm = $this->createForm('UsuariosBundle\Form\UserType', $user);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_edit', array('id' => $user->getId()));
        }

        return $this->render('UsuariosBundle:Default:edit.html.twig', array(
            'user' => $user,
            'empresa'       => $empresa,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a user entity.
     *
     * @Route("/{id}", name="user_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, User $user)
    {
        $form = $this->createDeleteForm($user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($user);
            $em->flush();
        }

        return $this->redirectToRoute('user_index');
    }

    /**
     * Creates a form to delete a user entity.
     *
     * @param User $user The user entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(User $user)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('user_delete', array('id' => $user->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

}

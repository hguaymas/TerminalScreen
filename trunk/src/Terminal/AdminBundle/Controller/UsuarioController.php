<?php

namespace Terminal\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Terminal\SecurityBundle\Form\ChangePasswordType;
use FOS\UserBundle\Model\UserInterface;
use Terminal\AdminBundle\Entity\Usuario;
use Terminal\AdminBundle\Form\UsuarioType;
use Terminal\AdminBundle\Form\MiCuentaType;
use Terminal\AdminBundle\Form\EditUsuarioType;

/**
 * Usuario controller.
 *
 */
class UsuarioController extends Controller
{

    /**
     * Lists all Usuario entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForms = array();
        $entities = $em->getRepository('TerminalAdminBundle:Usuario')->findAll();
        foreach ($entities as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
        }        
        return $this->render('TerminalAdminBundle:Usuario:index.html.twig', array(
            'entities' => $entities,
            'deleteForms' => $deleteForms
        ));
    }
    /**
     * Creates a new Usuario entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Usuario();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se creó correctamente el Usuario');
            return $this->redirect($this->generateUrl('usuario_show', array('id' => $entity->getId())));
        }

        return $this->render('TerminalAdminBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Usuario $entity)
    {
        $form = $this->createForm(new UsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_create'),
            'method' => 'POST',
        ));
        

        return $form;
    }

    /**
     * Displays a form to create a new Usuario entity.
     *
     */
    public function newAction()
    {
        $entity = new Usuario();
        $form   = $this->createCreateForm($entity);

        return $this->render('TerminalAdminBundle:Usuario:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Usuario entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TerminalAdminBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TerminalAdminBundle:Usuario:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Usuario entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TerminalAdminBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TerminalAdminBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Usuario entity.
    *
    * @param Usuario $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Usuario $entity)
    {
        $form = $this->createForm(new EditUsuarioType(), $entity, array(
            'action' => $this->generateUrl('usuario_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));        

        return $form;
    }
    /**
     * Edits an existing Usuario entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TerminalAdminBundle:Usuario')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Usuario entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se modificó correctamente el Usuario');
            return $this->redirect($this->generateUrl('usuario', array('id' => $id)));
        }

        return $this->render('TerminalAdminBundle:Usuario:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Usuario entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TerminalAdminBundle:Usuario')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('No se pudo encontrar el usuario');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se eliminó correctamente el Usuario');
        }

        return $this->redirect($this->generateUrl('usuario'));
    }

    /**
     * Creates a form to delete a Usuario entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('usuario_delete', array('id' => $id)))
            ->setMethod('DELETE')            
            ->getForm()
        ;
    }
    
    public function micuentaAction(Request $request)
    {
        $user = $this->getUser();//$this->container->get('security.context')->getToken()->getUser();
        if (!$user) {
            throw $this->createNotFoundException('No se pudieron recuperar los datos del usuario');
        }
        if (!is_object($user) || !$user instanceof UserInterface) {
            throw new AccessDeniedException('Este usuario no tiene acceso a esta sección');
        }        

        $editForm = $this->createForm(new MiCuentaType(), $user);        
        $changePasswordForm = $this->createForm(new ChangePasswordType(), $user);
        $tab_error = 0;
        if ($request->isMethod('POST')) {
            $form = $this->getRequest()->request->get('form');
            if($form == 'edit')
            {
                $editForm->bind($request);

                if ($editForm->isValid()) {
                    
                    /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
                    $userManager = $this->container->get('fos_user.user_manager');               
                    $userManager->updateUser($user);

                    $url = $this->container->get('router')->generate('_welcome');
                    $this->get('session')->getFlashBag()->add('success', 'Se ha actualizado el usuario con éxito.');
                    $response = new RedirectResponse($url);                                
                    return $response;
                }
                else
                {
                    $tab_error = 0;
                }
            }            
            elseif($form == 'change_password')
            {
                $changePasswordForm->bind($request);

                if ($changePasswordForm->isValid()) {
                    /** @var $userManager \FOS\UserBundle\Model\UserManagerInterface */
                    $userManager = $this->container->get('fos_user.user_manager');               
                    $userManager->updateUser($user);

                    $url = $this->container->get('router')->generate('_welcome');
                    $this->get('session')->getFlashBag()->add('success', 'Se ha modificado la contraseña con éxito.');
                    $response = new RedirectResponse($url);                                
                    return $response;
                }
                else
                {
                    $tab_error = 1;
                }
            }
        }        
        
        return $this->render('TerminalAdminBundle:Usuario:micuenta.html.twig', array(
            'entity'      => $user,
            'edit_form'   => $editForm->createView(),            
            'change_password'   => $changePasswordForm->createView(),            
            'tab_error' => $tab_error
        ));
    }     
}

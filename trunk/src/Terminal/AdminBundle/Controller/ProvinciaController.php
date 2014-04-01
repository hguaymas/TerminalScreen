<?php

namespace Terminal\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Terminal\AdminBundle\Entity\Provincia;
use Terminal\AdminBundle\Form\ProvinciaType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Provincia controller.
 *
 */
class ProvinciaController extends Controller {

    /**
     * Lists all Provincia entities.
     *
     */
    public function indexAction() {
        $em = $this->getDoctrine()->getManager();
        $deleteForms = array();
        $entities = $em->getRepository('TerminalAdminBundle:Provincia')->findAll();
        foreach ($entities as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
        }
        return $this->render('TerminalAdminBundle:Provincia:index.html.twig', array(
                    'entities' => $entities,
                    'deleteForms' => $deleteForms
        ));
    }

    /**
     * Creates a new Provincia entity.
     *
     */
    public function createAction(Request $request) {
        $entity = new Provincia();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se creó correctamente la Provincia');
            return $this->redirect($this->generateUrl('provincia'));
        }

        return $this->render('TerminalAdminBundle:Provincia:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Provincia entity.
     *
     * @param Provincia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Provincia $entity) {
        $form = $this->createForm(new ProvinciaType(), $entity, array(
            'action' => $this->generateUrl('provincia_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Provincia entity.
     *
     */
    public function newAction() {
        $entity = new Provincia();
        $form = $this->createCreateForm($entity);

        return $this->render('TerminalAdminBundle:Provincia:new.html.twig', array(
                    'entity' => $entity,
                    'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Provincia entity.
     *
     */
    public function showAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TerminalAdminBundle:Provincia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Provincia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TerminalAdminBundle:Provincia:show.html.twig', array(
                    'entity' => $entity,
                    'delete_form' => $deleteForm->createView(),));
    }

    /**
     * Displays a form to edit an existing Provincia entity.
     *
     */
    public function editAction($id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TerminalAdminBundle:Provincia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Provincia entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TerminalAdminBundle:Provincia:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Creates a form to edit a Provincia entity.
     *
     * @param Provincia $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createEditForm(Provincia $entity) {
        $form = $this->createForm(new ProvinciaType(), $entity, array(
            'action' => $this->generateUrl('provincia_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }

    /**
     * Edits an existing Provincia entity.
     *
     */
    public function updateAction(Request $request, $id) {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TerminalAdminBundle:Provincia')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Provincia entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se modificó correctamente la Provincia');
            return $this->redirect($this->generateUrl('provincia'));
        }

        return $this->render('TerminalAdminBundle:Provincia:edit.html.twig', array(
                    'entity' => $entity,
                    'form' => $editForm->createView(),
                    'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Provincia entity.
     *
     */
    public function deleteAction(Request $request, $id) {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TerminalAdminBundle:Provincia')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Provincia entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se eliminó correctamente la Provincia');
        }

        return $this->redirect($this->generateUrl('provincia'));
    }

    /**
     * Creates a form to delete a Provincia entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id) {
        return $this->createFormBuilder()
                        ->setAction($this->generateUrl('provincia_delete', array('id' => $id)))
                        ->setMethod('DELETE')
                        ->getForm()
        ;
    }

    public function provinciasPaisAction(Request $request) {
        $id = $request->request->get('id');
        
        $em = $this->getDoctrine()->getManager();
        $results= array();
        $provincias = $em->getRepository('TerminalAdminBundle:Provincia')->findProvinciasByPaisId($id);
        $localidades = $em->getRepository('TerminalAdminBundle:Localidad')->findLocalidadesByPaisId($id);
        
        $results['provincias'] = $this->renderView('TerminalAdminBundle:Default:includes/ajax_selects.html.twig', array(
                    'items' => $provincias,
                    'empty_value' => 'Seleccione una provincia'
        ));
        $results['localidades'] = $this->renderView('TerminalAdminBundle:Default:includes/ajax_selects.html.twig', array(
                    'items' => $localidades,
                    'empty_value' => 'Seleccione una localidad'
        ));
        
        $response = new JsonResponse();
        $response->setData($results);
        return $response;
        
         
    }

}

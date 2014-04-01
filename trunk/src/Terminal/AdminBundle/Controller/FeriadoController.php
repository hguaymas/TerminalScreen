<?php

namespace Terminal\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Terminal\AdminBundle\Entity\Feriado;
use Terminal\AdminBundle\Form\FeriadoType;

/**
 * Feriado controller.
 *
 */
class FeriadoController extends Controller
{

    /**
     * Lists all Feriado entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForms = array();
        $entities = $em->getRepository('TerminalAdminBundle:Feriado')->findAll();
        foreach ($entities as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
        } 
        return $this->render('TerminalAdminBundle:Feriado:index.html.twig', array(
            'entities' => $entities,
            'deleteForms' => $deleteForms
        ));
    }
    /**
     * Creates a new Feriado entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Feriado();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se creó correctamente el Feriado');
            return $this->redirect($this->generateUrl('feriados'));
        }

        return $this->render('TerminalAdminBundle:Feriado:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Feriado entity.
    *
    * @param Feriado $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Feriado $entity)
    {
        $form = $this->createForm(new FeriadoType(), $entity, array(
            'action' => $this->generateUrl('feriados_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Feriado entity.
     *
     */
    public function newAction()
    {
        $entity = new Feriado();
        $form   = $this->createCreateForm($entity);

        return $this->render('TerminalAdminBundle:Feriado:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Feriado entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TerminalAdminBundle:Feriado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Feriado entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TerminalAdminBundle:Feriado:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Feriado entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TerminalAdminBundle:Feriado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Feriado entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TerminalAdminBundle:Feriado:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Feriado entity.
    *
    * @param Feriado $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Feriado $entity)
    {
        $form = $this->createForm(new FeriadoType(), $entity, array(
            'action' => $this->generateUrl('feriados_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Feriado entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TerminalAdminBundle:Feriado')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Feriado entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se modificó correctamente el Feriado');
            return $this->redirect($this->generateUrl('feriados'));
        }

        return $this->render('TerminalAdminBundle:Feriado:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Feriado entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TerminalAdminBundle:Feriado')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Feriado entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se eliminó correctamente el Feriado');
        }

        return $this->redirect($this->generateUrl('feriados'));
    }

    /**
     * Creates a form to delete a Feriado entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('feriados_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

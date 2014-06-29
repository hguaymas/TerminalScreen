<?php

namespace Terminal\AdminBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Terminal\AdminBundle\Entity\Servicio;
use Terminal\AdminBundle\Form\ServicioType;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Servicio controller.
 *
 */
class ServicioController extends Controller
{

    /**
     * Lists all Servicio entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $deleteForms = array();
        $entities = $em->getRepository('TerminalAdminBundle:Servicio')->findAll();
        foreach ($entities as $entity) {
            $deleteForms[$entity->getId()] = $this->createDeleteForm($entity->getId())->createView();
        }
        return $this->render('TerminalAdminBundle:Servicio:index.html.twig', array(
            'entities' => $entities,
            'deleteForms' => $deleteForms,
            'estadosJson' => Servicio::getEstadosJson()
        ));
    }
    /**
     * Creates a new Servicio entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Servicio();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se creó correctamente el Servicio');
            return $this->redirect($this->generateUrl('servicio'));
        }

        return $this->render('TerminalAdminBundle:Servicio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Servicio entity.
    *
    * @param Servicio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Servicio $entity)
    {
        $form = $this->createForm(new ServicioType(), $entity, array(
            'action' => $this->generateUrl('servicio_create'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Servicio entity.
     *
     */
    public function newAction()
    {
        $entity = new Servicio();
        $form   = $this->createCreateForm($entity);

        return $this->render('TerminalAdminBundle:Servicio:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Servicio entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TerminalAdminBundle:Servicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Servicio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TerminalAdminBundle:Servicio:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Servicio entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TerminalAdminBundle:Servicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Servicio entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('TerminalAdminBundle:Servicio:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Servicio entity.
    *
    * @param Servicio $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Servicio $entity)
    {
        $form = $this->createForm(new ServicioType(), $entity, array(
            'action' => $this->generateUrl('servicio_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        return $form;
    }
    /**
     * Edits an existing Servicio entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TerminalAdminBundle:Servicio')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Servicio entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se modificó correctamente el Servicio');
            return $this->redirect($this->generateUrl('servicio'));
        }

        return $this->render('TerminalAdminBundle:Servicio:edit.html.twig', array(
            'entity'      => $entity,
            'form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Servicio entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TerminalAdminBundle:Servicio')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Servicio entity.');
            }

            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add('success', 'Se eliminó correctamente el Servicio');
        }

        return $this->redirect($this->generateUrl('servicio'));
    }

    /**
     * Creates a form to delete a Servicio entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('servicio_delete', array('id' => $id)))
            ->setMethod('DELETE')            
            ->getForm()
        ;
    }
    
    public function actualizarAction(Request $request) {
        $id = $request->request->get('pk');
        $campo = $request->request->get('name');
        $valor = $request->request->get('value');
        
        $em = $this->getDoctrine()->getManager();
        $respuesta = array();
        $servicio = $em->getRepository('TerminalAdminBundle:Servicio')->find($id);
        
        if (!$servicio) {
            $respuesta['success'] = false;
            $respuesta['message'] = 'No se pudo encontrar el servicio';                        
        }
        else
        {
            $field = 'set'.$campo;
            $servicio->{$field}($valor);
            $em->persist($servicio);
            $em->flush();      
            $respuesta['success'] = true;
        }                
        $response = new JsonResponse();
        $response->setData($respuesta);
        return $response;
        
         
    }
    
    public function serviciosActualizadosAction(Request $request) {        
        
        $em = $this->getDoctrine()->getManager();
        $respuesta = array();
        $fecha_hora = new \DateTime();
        $fecha_hora_desde = $fecha_hora->sub(new \DateInterval('PT30M'));
        $fecha_hora = new \DateTime();
        $fecha_hora_hasta = $fecha_hora->add(new \DateInterval('PT1H'));
        
        $salidas = $em->getRepository('TerminalAdminBundle:Servicio')->findServiciosActuales('salida', $fecha_hora_desde, $fecha_hora_hasta);
        $arribos = $em->getRepository('TerminalAdminBundle:Servicio')->findServiciosActuales('arribo', $fecha_hora_desde, $fecha_hora_hasta);
        
        $respuesta['salidas'] = $this->renderView('TerminalFrontBundle:Default:tabla_servicios.html.twig', array(
            'servicios' => $salidas            
        ));
        $respuesta['arribos'] = $this->renderView('TerminalFrontBundle:Default:tabla_servicios.html.twig', array(
            'servicios' => $arribos            
        ));
        $respuesta['fecha_hora'] = $this->renderView('TerminalFrontBundle:Default:fecha_hora.html.twig');
                
        $response = new JsonResponse();
        $response->setData($respuesta);
        return $response;
        
         
    }
    
    public function serviciosActualizadosAdminAction(Request $request) {        
                
        $respuesta = array();
        
        $servicios = $this->getServiciosActualizados();
        
        $respuesta['salidas'] = $this->renderView('TerminalAdminBundle:Servicio:tabla_servicios_admin.html.twig', array(
            'servicios' => $servicios['salidas']
        ));
        $respuesta['arribos'] = $this->renderView('TerminalAdminBundle:Servicio:tabla_servicios_admin.html.twig', array(
            'servicios' => $servicios['arribos']
        ));
                
        $response = new JsonResponse();
        $response->setData($respuesta);
        return $response;                 
    }
    
    public function serviciosActualesAdminAction()
    {              
        $servicios = $this->getServiciosActualizados();
                
        return $this->render('TerminalAdminBundle:Servicio:servicios_actuales.html.twig', array(
            'estadosJson' => Servicio::getEstadosJson(),
            'salidas' => $servicios['salidas'],
            'arribos' => $servicios['arribos']
        ));
    }
    
    private function getServiciosActualizados()
    {
        $em = $this->getDoctrine()->getManager();
        $fecha_hora = new \DateTime();
        $fecha_hora_desde = $fecha_hora->sub(new \DateInterval('PT20M'));
        $fecha_hora = new \DateTime();
        $fecha_hora_hasta = $fecha_hora->add(new \DateInterval('PT45M'));
        
        $salidas = $em->getRepository('TerminalAdminBundle:Servicio')->findServiciosActuales('salida', $fecha_hora_desde, $fecha_hora_hasta);
        $arribos = $em->getRepository('TerminalAdminBundle:Servicio')->findServiciosActuales('arribo', $fecha_hora_desde, $fecha_hora_hasta);
        return array('salidas' => $salidas, 'arribos' => $arribos);
    }
}

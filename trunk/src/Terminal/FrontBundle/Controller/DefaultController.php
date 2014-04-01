<?php

namespace Terminal\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $fecha_hora = new \DateTime();
        $fecha_hora_desde = $fecha_hora->sub(new \DateInterval('PT15M'));
        $fecha_hora = new \DateTime();
        $fecha_hora_hasta = $fecha_hora->add(new \DateInterval('PT1H'));
        
        $entities = $em->getRepository('TerminalAdminBundle:Servicio')->findServiciosActuales('salida', $fecha_hora_desde, $fecha_hora_hasta);
        
        return $this->render('TerminalFrontBundle:Default:index.html.twig', array(
            'entities' => $entities            
        ));
    }
}

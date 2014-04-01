<?php
 
namespace Terminal\SecurityBundle\Listener;
 
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\Bundle\DoctrineBundle\Registry as Doctrine;
use Symfony\Component\DependencyInjection\ContainerInterface;
 
/**
 * Custom login listener.
 */
class LoginListener
{
	/** @var \Symfony\Component\Security\Core\SecurityContext */
	private $securityContext;
	
	/** @var \Doctrine\ORM\EntityManager */
	private $em;
	
        /** @var \Symfony\Component\DependencyInjection\ContainerInterface */
        private $container;
        
        private $locale;
	
	/**
	 * Constructor
	 * 
	 * @param SecurityContext $securityContext
	 * @param Doctrine        $doctrine
	 * @param ContainerInterface        $container
	 */
	public function __construct(SecurityContext $securityContext, Doctrine $doctrine, ContainerInterface $container, $locale)
	{
		$this->securityContext = $securityContext;
		$this->em              = $doctrine->getEntityManager();
                $this->container = $container;
                $this->locale = $locale;
	}
	
	/**
	 * Do the magic.
	 * 
	 * @param InteractiveLoginEvent $event
	 */
	public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
	{
		if ($this->securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
			// user has just logged in
		}
		
		if ($this->securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
			// user has logged in using remember_me cookie
		}
				
		// do some other magic here
		$user = $event->getAuthenticationToken()->getUser();
                if(!$user->getLocale())
                {
                    $user->setLocale($this->locale);
                }
                $this->container->get('session')->set('_locale', $user->getLocale());
                
		$consorcio = $this->container->get('session')->get('consorcio');
                if(!$consorcio)
                {
                    $consorcios = $this->em->getRepository('TerminalAdminBundle:Consorcio')->findAll();
                    if(count($consorcios) > 0)
                        $this->container->get('session')->set('consorcio', $consorcios[0]);
                }		
	}
}
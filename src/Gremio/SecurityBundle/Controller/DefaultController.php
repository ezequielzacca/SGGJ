<?php

namespace Gremio\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Cierre controller.
 *
 * @Route("/")
 */
class DefaultController extends Controller
{
	
	
	/**
	 * Lista todos los cierres realizados
	 *
	 * @Route("/", name="principal")
	 * @Template()
	 */
    public function indexAction()
    {
        if($this->get('security.context')->isGranted('ROLE_SOCIO'))
        {
        	$pagina = $this->get('router')->generate('socio_panel');
        	$event->setResponse(new RedirectResponse($pagina));
        }
        	else if($this->get('security.context')->isGranted('ROLE_GREMIO'))
        	{
        		$pagina = $this->get('router')->generate('socio');
        		$event->setResponse(new RedirectResponse($pagina));
        	}
        	
        	else if($this->get('security.context')->isGranted('ROLE_PROVEEDOR')){
        		$pagina = $this->get('router')->generate('proveedores');
        		$event->setResponse(new RedirectResponse($pagina));
        	}
        	
    }
}

<?php

namespace Gremio\DefaultBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;
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
    	$pagina="";
        if($this->get('security.context')->isGranted('ROLE_SOCIO'))
        {
        	$pagina = $this->get('router')->generate('socio_panel');
        	
        }
        	else if($this->get('security.context')->isGranted('ROLE_GREMIO'))
        	{
        		$pagina = $this->get('router')->generate('socio');
        		
        	}
        	
        	else if($this->get('security.context')->isGranted('ROLE_PROVEEDOR')){
        		$pagina = $this->get('router')->generate('proveedores');
        		
        	}
        	
        	$response = new RedirectResponse($pagina);
        	
        	return $response;
    }
}

